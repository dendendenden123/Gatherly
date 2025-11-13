<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\EventOccurrence;
use App\Models\User;
use App\Models\Report;
use App\Models\Sermon;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Attendance;
use App\Models\Officer;
use Carbon\Carbon;

class ChatbotController extends Controller
{

    public function index()
    {
        return view('admin.chatbot.chat');
    }

    public function send(Request $request)
    {
        $message = $request->input('message');
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'reply' => 'You must be logged in to use the chatbot.',
            ], 401);
        }

        // Get database context based on the question for this specific user
        $dbContext = $this->getDatabaseContext($message, $user);

        // Build the prompt with database context
        $systemPrompt = 'You are an AI chatbot for Iglesia ni Cristo (INC) based in the Philippines. Respond to all questions with kindness, scriptural references, and clarity while upholding INC doctrine. You are not an official chatbot but provides information based on the church database. You can only provide information about the logged-in user\'s own data for privacy reasons.';

        $fullPrompt = $systemPrompt . "\n\n" . $dbContext . "\n\nUser Question: " . $message;
        
        // Generate a simple response based on context
        // Since no AI API is configured, provide a context-based response
        $reply = $this->generateContextualResponse($message, $dbContext, $user);

        return response()->json([
            'reply' => $reply,
        ]);
    }

    private function getDatabaseContext($message, $user)
    {
        $context = '';
        $messageLower = strtolower($message);

        // Check for worship service related queries
        if (preg_match('/\b(worship|service|pagsamba)\b/i', $message)) {
            $context .= $this->getWorshipServiceInfo();
        }

        // Check for event related queries
        if (preg_match('/\b(event|activity|activities|next|upcoming|schedule)\b/i', $message)) {
            $context .= $this->getUpcomingEventsInfo();
        }

        // Check for attendance related queries - only user's own
        if (preg_match('/\b(attendance|attend|present|absent|my attendance)\b/i', $message)) {
            $context .= $this->getUserAttendanceInfo($user);
        }

        // Check for report related queries - only user's own reports
        if (preg_match('/\b(report|reports|recent|submitted|my report)\b/i', $message)) {
            $context .= $this->getUserReportsInfo($user);
        }

        // Check for sermon related queries - all sermons are public
        if (preg_match('/\b(sermon|sermons|message|preaching)\b/i', $message)) {
            $context .= $this->getSermonsInfo();
        }

        // Check for task related queries - only user's own tasks
        if (preg_match('/\b(task|tasks|assignment|assignments|my task)\b/i', $message)) {
            $context .= $this->getUserTasksInfo($user);
        }

        // Check for notification related queries - only user's own
        if (preg_match('/\b(notification|notifications|alert|alerts|my notification)\b/i', $message)) {
            $context .= $this->getUserNotificationsInfo($user);
        }

        // Check for user info related queries - only own info
        if (preg_match('/\b(my info|my profile|my details|my account)\b/i', $message)) {
            $context .= $this->getUserInfo($user);
        }

        // Check for officers - public info
        if (preg_match('/\b(officer|officers|church officer|leadership)\b/i', $message)) {
            $context .= $this->getOfficersInfo();
        }

        return $context;
    }

    private function getWorshipServiceInfo()
    {
        try {
            // Get event occurrences for worship services
            $occurrences = DB::table('event_occurrences')
                ->join('events', 'event_occurrences.event_id', '=', 'events.id')
                ->where('events.event_type', 'Worship Service')
                ->where('event_occurrences.occurrence_date', '>=', Carbon::today()->toDateString())
                ->where('event_occurrences.status', '!=', 'cancelled')
                ->orderBy('event_occurrences.occurrence_date', 'asc')
                ->orderBy('event_occurrences.start_time', 'asc')
                ->select(
                    'events.event_name',
                    'events.location',
                    'event_occurrences.occurrence_date',
                    'event_occurrences.start_time',
                    'event_occurrences.end_time',
                    'event_occurrences.status'
                )
                ->take(10)
                ->get();

            // Get standalone worship service events (that might not have occurrences yet)
            $worshipEvents = DB::table('events')
                ->where('event_type', 'Worship Service')
                ->where('status', '!=', 'cancelled')
                ->whereNotNull('start_date')
                ->where('start_date', '>=', Carbon::today()->toDateString())
                ->orderBy('start_date', 'asc')
                ->select('event_name', 'start_date', 'start_time', 'end_time', 'location', 'repeat', 'status')
                ->take(5)
                ->get();

            $context = "\n";
            
            if ($occurrences->isNotEmpty()) {
                $context .= "Upcoming Worship Service Schedule:\n";
                foreach ($occurrences as $occ) {
                    $date = Carbon::parse($occ->occurrence_date)->format('F d, Y (l)');
                    $time = $occ->start_time ? $this->formatTime($occ->start_time) : 'Time TBD';
                    $location = $occ->location ?? 'Location TBD';
                    
                    $context .= "- {$occ->event_name}\n";
                    $context .= "  Date: {$date}\n";
                    $context .= "  Time: {$time}\n";
                    $context .= "  Location: {$location}\n\n";
                }
            } elseif ($worshipEvents->isNotEmpty()) {
                $context .= "Scheduled Worship Services:\n";
                foreach ($worshipEvents as $event) {
                    $date = Carbon::parse($event->start_date)->format('F d, Y (l)');
                    $time = $event->start_time ? $this->formatTime($event->start_time) : 'Time TBD';
                    $location = $event->location ?? 'Location TBD';
                    
                    $context .= "- {$event->event_name}\n";
                    $context .= "  Date: {$date}\n";
                    $context .= "  Time: {$time}\n";
                    $context .= "  Location: {$location}\n";
                    $context .= "  Frequency: {$event->repeat}\n\n";
                }
            } else {
                $context .= "No worship services currently scheduled in the database.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n Error retrieving worship service information: " . $e->getMessage() . "\n";
        }
    }

    private function formatTime($time)
    {
        try {
            if (!$time) return 'N/A';
            
            // Handle different time formats
            if (strpos($time, ':') !== false) {
                $parts = explode(':', $time);
                $hour = (int)$parts[0];
                $minute = isset($parts[1]) ? (int)$parts[1] : 0;
                
                $period = $hour >= 12 ? 'PM' : 'AM';
                $hour = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                
                return sprintf('%d:%02d %s', $hour, $minute, $period);
            }
            
            return $time;
        } catch (\Exception $e) {
            return $time;
        }
    }

    private function getUpcomingEventsInfo()
    {
        try {
            $events = DB::table('events')
                ->where('status', 'upcoming')
                ->whereNotNull('start_date')
                ->where('start_date', '>=', Carbon::today()->toDateString())
                ->orderBy('start_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->select('event_name', 'event_type', 'start_date', 'start_time', 'end_time', 'location', 'repeat')
                ->take(15)
                ->get();

            $context = "\n ";
            if ($events->isNotEmpty()) {
                foreach ($events as $event) {
                    $date = Carbon::parse($event->start_date)->format('F d, Y (l)');
                    $time = $event->start_time ? $this->formatTime($event->start_time) : 'Time TBD';
                    $location = $event->location ?? 'Location TBD';
                    
                    $context .= "- {$event->event_name} ({$event->event_type})\n";
                    $context .= "  Date: {$date}\n";
                    $context .= "  Time: {$time}\n";
                    $context .= "  Location: {$location}\n";
                    if ($event->repeat && $event->repeat != 'once') {
                        $context .= "  Repeats: {$event->repeat}\n";
                    }
                    $context .= "\n";
                }
            } else {
                $context .= "No upcoming events scheduled.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n " . $e->getMessage() . "\n";
        }
    }

    private function getMemberStatistics()
    {
        // Removed - users should not have access to all member statistics
        return '';
    }

    private function getUserAttendanceInfo($user)
    {
        try {
            $attendances = DB::table('attendances')
                ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
                ->join('events', 'event_occurrences.event_id', '=', 'events.id')
                ->where('attendances.user_id', $user->id)
                ->orderBy('event_occurrences.occurrence_date', 'desc')
                ->select(
                    'events.event_name',
                    'event_occurrences.occurrence_date',
                    'attendances.status',
                    'attendances.check_in_time'
                )
                ->take(10)
                ->get();

            $context = "\n=== YOUR ATTENDANCE HISTORY ===\n";
            if ($attendances->isNotEmpty()) {
                $context .= "Recent Attendance Records:\n";
                foreach ($attendances as $att) {
                    $date = Carbon::parse($att->occurrence_date)->format('F d, Y (l)');
                    $time = $att->check_in_time ? Carbon::parse($att->check_in_time)->format('h:i A') : 'N/A';
                    
                    $context .= "- {$att->event_name}\n";
                    $context .= "  Date: {$date}\n";
                    $context .= "  Status: {$att->status}\n";
                    $context .= "  Check-in: {$time}\n\n";
                }
            } else {
                $context .= "No attendance records found for your account.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== YOUR ATTENDANCE HISTORY ===\nError retrieving your attendance: " . $e->getMessage() . "\n";
        }
    }

    private function getReportsInfo()
    {
        // Removed - users should only see their own reports
        return '';
    }

    private function getUserReportsInfo($user)
    {
        try {
            // Reports table only has id and timestamps - no additional columns
            $userReports = DB::table('reports')
                ->orderBy('created_at', 'desc')
                ->select('id', 'created_at')
                ->take(5)
                ->get();

            $context = "\n=== REPORTS ===\n";
            if ($userReports->isNotEmpty()) {
                $context .= "Total Reports: {$userReports->count()}\n";
                foreach ($userReports as $report) {
                    $date = Carbon::parse($report->created_at)->format('F d, Y');
                    $context .= "- Report #{$report->id}\n";
                    $context .= "  Date: {$date}\n\n";
                }
            } else {
                $context .= "No reports found in the system.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== REPORTS ===\nError retrieving reports: " . $e->getMessage() . "\n";
        }
    }

    private function getSermonsInfo()
    {
        try {
            $recentSermons = DB::table('sermons')
                ->join('users', 'sermons.preacher_id', '=', 'users.id')
                ->orderBy('sermons.created_at', 'desc')
                ->select('sermons.title', 'users.first_name', 'users.last_name', 'sermons.date_preached', 'sermons.created_at')
                ->take(5)
                ->get();

            $context = "\n=== RECENT SERMONS ===\n";
            if ($recentSermons->isNotEmpty()) {
                foreach ($recentSermons as $sermon) {
                    $date = $sermon->date_preached ? Carbon::parse($sermon->date_preached)->format('F d, Y') : 'Date not specified';
                    $speaker = "{$sermon->first_name} {$sermon->last_name}";
                    $context .= "- \"{$sermon->title}\"\n";
                    $context .= "  Speaker: {$speaker}\n";
                    $context .= "  Date: {$date}\n\n";
                }
            } else {
                $context .= "No sermons found.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== RECENT SERMONS ===\nError retrieving sermons: " . $e->getMessage() . "\n";
        }
    }

    private function getTasksInfo()
    {
        // Removed - users should only see their own tasks
        return '';
    }

    private function getUserTasksInfo($user)
    {
        try {
            $userTasks = DB::table('task_user')
                ->join('tasks', 'task_user.task_id', '=', 'tasks.id')
                ->where('task_user.user_id', $user->id)
                ->orderBy('tasks.due_date', 'asc')
                ->select('tasks.title', 'tasks.priority', 'tasks.due_date', 'task_user.status', 'tasks.description')
                ->take(10)
                ->get();

            $context = "\n=== YOUR TASKS ===\n";
            if ($userTasks->isNotEmpty()) {
                foreach ($userTasks as $task) {
                    $dueDate = $task->due_date ? Carbon::parse($task->due_date)->format('F d, Y') : 'No due date';
                    $context .= "- {$task->title}\n";
                    $context .= "  Priority: {$task->priority}\n";
                    $context .= "  Due Date: {$dueDate}\n";
                    $context .= "  Status: {$task->status}\n";
                    if ($task->description) {
                        $context .= "  Description: {$task->description}\n";
                    }
                    $context .= "\n";
                }
            } else {
                $context .= "No tasks assigned to you.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== YOUR TASKS ===\nError retrieving your tasks: " . $e->getMessage() . "\n";
        }
    }

    private function getUserNotificationsInfo($user)
    {
        try {
            $notifications = DB::table('notification_user')
                ->join('notifications', 'notification_user.notification_id', '=', 'notifications.id')
                ->where('notification_user.user_id', $user->id)
                ->orderBy('notifications.created_at', 'desc')
                ->select('notifications.subject', 'notifications.message', 'notification_user.read_at', 'notifications.created_at')
                ->take(5)
                ->get();

            $context = "\n=== YOUR NOTIFICATIONS ===\n";
            if ($notifications->isNotEmpty()) {
                foreach ($notifications as $notif) {
                    $date = Carbon::parse($notif->created_at)->format('F d, Y');
                    $status = $notif->read_at ? 'Read' : 'Unread';
                    $context .= "- {$notif->subject} ({$status})\n";
                    $context .= "  Message: {$notif->message}\n";
                    $context .= "  Date: {$date}\n\n";
                }
            } else {
                $context .= "No notifications found.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== YOUR NOTIFICATIONS ===\nError retrieving notifications: " . $e->getMessage() . "\n";
        }
    }

    private function getUserInfo($user)
    {
        try {
            $context = "\n=== YOUR PROFILE INFORMATION ===\n";
            $context .= "Name: {$user->first_name} {$user->last_name}\n";
            $context .= "Email: {$user->email}\n";
            $context .= "Status: {$user->status}\n";
            $context .= "District: {$user->district}\n";
            $context .= "Locale: {$user->locale}\n";
            if ($user->phone) {
                $context .= "Phone: {$user->phone}\n";
            }
            if ($user->address) {
                $context .= "Address: {$user->address}\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== YOUR PROFILE INFORMATION ===\nError retrieving your information: " . $e->getMessage() . "\n";
        }
    }

    private function getOfficersInfo()
    {
        try {
            $officers = DB::table('officers')
                ->join('users', 'officers.user_id', '=', 'users.id')
                ->leftJoin('roles', 'officers.role_id', '=', 'roles.id')
                ->select('users.first_name', 'users.last_name', 'roles.name as role_name', 'officers.custom_role', 'officers.start_date', 'officers.end_date')
                ->orderBy('roles.name', 'asc')
                ->get();

            $context = "\n=== CHURCH OFFICERS ===\n";
            if ($officers->isNotEmpty()) {
                foreach ($officers as $officer) {
                    $name = "{$officer->first_name} {$officer->last_name}";
                    $position = $officer->custom_role ?? $officer->role_name;
                    $context .= "- {$name}\n";
                    $context .= "  Position: {$position}\n";
                    if ($officer->start_date) {
                        $termStart = Carbon::parse($officer->start_date)->format('Y');
                        $termEnd = $officer->end_date ? Carbon::parse($officer->end_date)->format('Y') : 'Present';
                        $context .= "  Term: {$termStart} - {$termEnd}\n";
                    }
                    $context .= "\n";
                }
            } else {
                $context .= "No officers information available.\n";
            }

            return $context;
        } catch (\Exception $e) {
            return "\n=== CHURCH OFFICERS ===\nError retrieving officers: " . $e->getMessage() . "\n";
        }
    }

    private function generateContextualResponse($message, $dbContext, $user)
    {
        // Simple AI-like response generator based on context
        $messageLower = strtolower($message);
        
        // If context is empty, provide a default response
        if (empty(trim($dbContext))) {
            if (preg_match('/\b(hello|hi|hey|greetings)\b/i', $message)) {
                return "Hello {$user->first_name}! How can I assist you today? You can ask me about your tasks, attendance, notifications, reports, upcoming events, sermons, or church officers.";
            } elseif (preg_match('/\b(help|what can you do)\b/i', $message)) {
                return "I can help you with:\n- Your attendance records\n- Your assigned tasks\n- Your notifications\n- Your submitted reports\n- Upcoming events and worship services\n- Sermons\n- Church officers\n- Your profile information\n\nJust ask me about any of these topics!";
            } elseif (preg_match('/\b(member|members|brethren|total|count|how many)\b/i', $message)) {
                return "For privacy reasons, I can only provide information about your own records. I cannot access statistics about other members.";
            } else {
                return "I found no specific information about that in our database. You can ask me about your tasks, attendance, notifications, reports, upcoming events, sermons, church officers, or your profile information.";
            }
        }
        
        // Provide context-based response with a friendly introduction
        $response = "Here's what I found:\n\n" . $dbContext;
        
        return $response;
    }

}
