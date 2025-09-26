<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sermon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SermonController extends Controller
{
    public function index(Request $request)
    {
        $dateFilter = $request->input('date');

        $query = Sermon::with('preacher');

        // Apply filtering and sorting based on the selected date option
        switch ($dateFilter) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'last-month':
                $query->where('created_at', '>=', Carbon::now()->subMonth())
                    ->orderBy('created_at', 'desc');
                break;
            case 'last-3-months':
                $query->where('created_at', '>=', Carbon::now()->subMonths(3))
                    ->orderBy('created_at', 'desc');
                break;
            case 'recent':
            case '':
            case null:
                $query->orderBy('created_at', 'desc');
                break;
            default:
                // If the filter is a specific year like 2023, 2022
                if (is_numeric($dateFilter) && strlen($dateFilter) === 4) {
                    $query->whereYear('created_at', (int) $dateFilter)
                        ->orderBy('created_at', 'desc');
                } else {
                    // Fallback to recent
                    $query->orderBy('created_at', 'desc');
                }
                break;
        }

        $sermons = $query->simplePaginate(6)->appends($request->query());

        if ($request->ajax()) {
            $listView = view('admin.sermons.sermon-list', compact('sermons'))->render();
            return response()->json(['list' => $listView]);
        }

        return view('admin.sermons.index', compact('sermons'));
    }

    public function create()
    {
        $preachers = User::with('officers')
            ->whereHas('officers', fn($officer) =>
                $officer->where('role_id', 1))->get(['id', 'first_name', 'last_name']);
        return view('admin.sermons.create', compact('preachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'preacher_id' => ['required', 'integer', 'exists:users,id'],
            'video_url' => ['nullable', 'string', 'max:2048'],
            'date_preached' => ['required', 'date'],
            'tags' => ['nullable', 'string', 'max:1024'],
        ]);

        $sermon = new Sermon();
        $sermon->title = $validated['title'];
        $sermon->description = $validated['description'] ?? null;
        $sermon->preacher_id = $validated['preacher_id'];
        $sermon->video_url = $validated['video_url'];
        $sermon->date_preached = $validated['date_preached'];
        $sermon->tags = $validated['tags'] ?? null;
        $sermon->save();

        return redirect()
            ->route('admin.sermons.index')
            ->with('success', 'Sermon created successfully.');
    }

    /**
     * Handle async video upload from the create form. Stores the video on the public disk
     * and returns a JSON payload with the public URL that can be saved as video_url.
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video_file' => ['required', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm', 'max:512000'], // 500MB
        ]);

        try {
            $file = $request->file('video_file');
            $path = $file->store('sermons/videos', 'public');
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path,
                'message' => 'Video uploaded successfully.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Sermon video upload failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload video. Please try again.'
            ], 422);
        }
    }
}
