<?php

namespace App\Services;

use App\Models\User;
use App\Mail\MemberStatusNotification;
use App\Models\Notification;
use App\Helpers\AttendanceHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getAllUsers()
    {
        return User::with('officers.role')->get();
    }

    public function isUserAuthorize()
    {
        $userId = Auth::id();
        $loggedUser = User::with('officers')->find($userId);
        return ($loggedUser->officers->contains('role_id', 1) ||
            $loggedUser->officers->contains('role_id', 9));
    }

    //get the user association (KAPISANAN): binhi, kadiwa buklod
    public function getUserAssociation($userid)
    {
        try {
            $user = User::find($userid);
            if ($user && $user->birthdate) {
                $age = Carbon::parse($user->birthdate)->age;
                if ($age <= 17) {
                    return 'binhi';
                } elseif ($age >= 18 && $user->marital_status == 'married') {
                    return 'buklod';
                } else {
                    return 'kadiwa';
                }
            }
        } catch (\Throwable $e) {
            \log::error('failed to get user association', ['error' => $e]);
        }
    }

    public function getUsersRoles($userId)
    {
        try {
            $roles = [];
            $user = User::find($userId);
            if ($user && method_exists($user, 'officers')) {
                $officers = $user->officers()->with('role')->get();
                // If any officer record exists and role_id not equal to a placeholder (e.g., 100), consider as volunteer
                $isVolunteer = $officers->filter(function ($o) {
                    return isset($o->role_id) && (int) $o->role_id !== 100; // 100 appears to be a default placeholder
                })->isNotEmpty();
                if ($isVolunteer) {
                    $roles[] = 'volunteers';
                }

                // Add explicit role names to audience list (so notifications can target specific roles)
                foreach ($officers as $officer) {
                    if ($officer->relationLoaded('role') && $officer->role && !empty($officer->role->name)) {
                        $roles[] = $officer->role->name;
                    }
                }
            }

            return $roles;
        } catch (\Throwable $e) {
            \log::error('failed to get users role', ['error' => $e]);
            return [];
        }
    }

    public function isMailExist($mail)
    {
        return User::where('email', $mail)->count() > 0;
    }

    public function isEmailHasFaceId($email)
    {
        return User::where('email', $email)->whereNotNull('rekognition_face_id')->exists();
    }

    public function updateUser($userId, $arr)
    {
        User::findOrFail($userId)->update($arr);
    }

    public function recalculateMemberStatus()
    {
        $users = User::with([
            'attendances' => function ($attendance) {
                $attendance->where('status', 'present')
                    ->whereBetween('created_at', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth()
                    ]);
            },
            'attendances.event_occurrence.event'
        ])->get();

        $ministersIds = User::with('officers')->whereHas('officers', function ($officers) {
            $officers->where('role_id', 1);
        })->pluck('id');


        $worshipDaysCount = AttendanceHelper::getWorshipDaysCountLastMonth();

        foreach ($users as $user) {
            if (
                $user->created_at > Carbon::now()->subMonth()->startOfMonth() ||
                $user->status == 'transferred' ||
                $user->status == 'pending' ||
                $user->status == 'expelled'
            ) {
                continue;
            }

            if ($user->attendances->count() == '0') {
                logger('user has been inactive', ['user' => $user]);
                $user->update(['status' => 'inactive']);

                // Send email to member
                try {
                    Mail::to($user->email)->send(new MemberStatusNotification($user, 'inactive'));
                } catch (\Exception $e) {
                    \Log::error('Failed to send inactive email to member: ' . $e->getMessage());
                }

                // Send email to ministers
                foreach ($ministersIds as $ministerId) {
                    $minister = User::find($ministerId);
                    if ($minister && $minister->email) {
                        try {
                            Mail::to($minister->email)->send(new MemberStatusNotification($user, 'inactive', true));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send inactive notification to minister: ' . $e->getMessage());
                        }
                    }
                }

                Notification::create([
                    'recipient_group' => 'specific_member',
                    'sender_id' => Auth::id(),
                    'receiver_id' => $user->id,
                    'subject' => 'Inactive Notice',
                    'message' => 'You have been marked as inactive for the previous month. Please attend worship services regularly to maintain your active status. Thank you.',
                    'category' => 'reminder'
                ]);

                foreach ($ministersIds as $id) {
                    Notification::create([
                        'recipient_group' => $id,
                        'sender_id' => Auth::id(),
                        'receiver_id' => $id,
                        'subject' => 'Inactive Member Notice',
                        'message' => 'The member was inactive last month. Please follow up and provide guidance. Thank you.',
                        'category' => 'reminder'
                    ]);
                }


                continue;

            } else if ($user->attendances->count() <= ($worshipDaysCount / 2)) {
                logger('user has been partially-active', ['user' => $user]);
                $user->update(['status' => 'partially-active']);

                // Send email to member
                try {
                    Mail::to($user->email)->send(new MemberStatusNotification($user, 'partially-active'));
                } catch (\Exception $e) {
                    \Log::error('Failed to send partially-active email to member: ' . $e->getMessage());
                }

                // Send email to ministers
                foreach ($ministersIds as $ministerId) {
                    $minister = User::find($ministerId);
                    if ($minister && $minister->email) {
                        try {
                            Mail::to($minister->email)->send(new MemberStatusNotification($user, 'partially-active', true));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send partially-active notification to minister: ' . $e->getMessage());
                        }
                    }
                }

                $notif = Notification::create([
                    'recipient_group' => 'specific_member',
                    'sender_id' => Auth::id(),
                    'receiver_id' => $user->id,
                    'subject' => 'Partially-Active Notice',
                    'message' => "Hello! Your attendance last month was partially active. We will be visiting your home soon to connect and support you. Looking forward to seeing you!",
                    'category' => 'reminder'
                ]);

                foreach ($ministersIds as $id) {
                    Notification::create([
                        'recipient_group' => $id,
                        'sender_id' => Auth::id(),
                        'receiver_id' => $id,
                        'subject' => 'Partially-active Member Notice',
                        'message' => 'The member was partially-active last month. Please follow up and provide guidance. Thank you.',
                        'category' => 'reminder'
                    ]);
                }

                continue;

            } else if ($user->attendances->count() >= $worshipDaysCount) {
                logger('user has been active', ['user' => $user]);
                $user->update(['status' => 'active']);
                continue;
            }

        }
    }
}
