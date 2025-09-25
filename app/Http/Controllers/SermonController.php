<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sermon;
use Carbon\Carbon;

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
        return view('admin.sermons.create');
    }
}
