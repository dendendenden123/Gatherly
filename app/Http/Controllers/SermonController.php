<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sermon;
use App\Models\User;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Auth;

class SermonController extends Controller
{
    public function index(Request $request)
    {
        logger( $request->all);

        $dateFilter = $request->input('date');
        $sermonName = $request->input('search') ?? null;
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

        

        $sermons = $query->when($sermonName,function($sermons)use($sermonName){
            $sermons->where('title', "like", '%' . $sermonName . '%');
        } )
        ->simplePaginate(6)->appends($request->query());

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
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'preacher_id' => ['required', 'integer', 'exists:users,id'],
                'video_file' => ['nullable', 'file', 'mimes:mp4,avi,mov,webm,wmv,flv,mkv'], // max 500MB
                'date_preached' => ['required', 'date'],
            ]);

            $sermon = new Sermon();
            $sermon->title = $validated['title'];
            $sermon->description = $validated['description'] ?? null;
            $sermon->preacher_id = $validated['preacher_id'];

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $videoPath = $request->file('video_file')->store('sermons', 'public');
                $sermon->video_url = Storage::url($videoPath);
            } else {
                $sermon->video_url = null;
            }

            $sermon->date_preached = $validated['date_preached'];
            $sermon->save();

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'create',
                'description' => 'upload new sermon video. Detail: ' . $sermon,
            ]);

            return redirect()
                ->route('admin.sermons.index')
                ->with('success', 'Sermon created successfully.');
        } catch (Throwable $e) {
            \Log::error('failed to upload sermons', ['error' => $e]);
            return back()->withErrors('success', 'Sermon failed to upload.');
        }
    }

    public function destroy($id)
    {
        try {
            logger('code goes here');
            $sermon = Sermon::findOrFail($id);

            // Delete the video file if it exists
            if ($sermon->video_url) {
                $filePath = str_replace('/storage', 'public', $sermon->video_url);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $sermon->delete();

            // Log the action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'delete',
                'description' => 'deleted sermon: ' . $sermon->title,
            ]);

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.sermons.index')
                ->with('success', 'Sermon deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to delete sermon', ['error' => $e->getMessage()]);

            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete sermon.'], 500);
            }

            return back()->with('error', 'Failed to delete sermon.');
        }
    }

    public function mySermons(Request $request)
    {

        $dateFilter = $request->input('date');
        $search = $request->input('search');

        $query = Sermon::with('preacher');

        // Apply search filter if provided
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

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

        return view('member.sermon', compact('sermons'));
    }
}
