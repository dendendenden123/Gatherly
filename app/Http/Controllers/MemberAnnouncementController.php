<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Models\Notification;
use App\Models\Event;
use Carbon\Carbon;

class MemberAnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Build audience groups for the logged-in user
        $audiences = ['all'];

        // Derive age-based group if birthdate is available
        try {
            if ($user && $user->birthdate) {
                $age = Carbon::parse($user->birthdate)->age;
                if ($age <= 17) {
                    $audiences[] = 'binhi';
                } elseif ($age <= 30) {
                    $audiences[] = 'kadiwa';
                } else {
                    // Default remaining to Buklod
                    $audiences[] = 'buklod';
                }
            }
        } catch (\Throwable $e) {
            // Fail-safe: ignore age grouping if parsing fails
        }

        // Determine if user is an officer/volunteer
        try {
            if ($user && method_exists($user, 'officers')) {
                $officers = $user->officers()->with('role')->get();
                // If any officer record exists and role_id not equal to a placeholder (e.g., 100), consider as volunteer
                $isVolunteer = $officers->filter(function ($o) {
                    return isset($o->role_id) && (int) $o->role_id !== 100; // 100 appears to be a default placeholder
                })->isNotEmpty();
                if ($isVolunteer) {
                    $audiences[] = 'volunteers';
                }

                // Add explicit role names to audience list (so notifications can target specific roles)
                foreach ($officers as $officer) {
                    if ($officer->relationLoaded('role') && $officer->role && !empty($officer->role->name)) {
                        $audiences[] = $officer->role->name;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Ignore officer determinations on error
        }

        // Fetch notifications targeted to any of the user's audiences
        $notifications = Notification::query()
            ->when(!empty($audiences), function ($q) use ($audiences) {
                $q->whereIn('recipient_group', $audiences);
            })
            ->latest()
            ->take(15)
            ->get();

        // Fetch upcoming events (no per-audience targeting available in schema, so show all upcoming)
        $events = Event::query()
            ->where('status', 'upcoming')
            ->orderBy('start_date')
            ->take(12)
            ->get();

        return view('member.announcement', compact('events', 'notifications'));
    }
}
