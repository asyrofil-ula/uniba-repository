<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_documents = Document::where('status', 'published')->count();
        $view_count = Document::sum('view_count');
        $download_count =Document::sum('download_count');
        $totalAuthors = Author::with('user')->distinct()->count('user_id');
//        dokumen terbaru
        $recent_documents = Document::with(['authors', 'documentType', 'faculty'])->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
        return view('admin.home', compact('total_documents', 'view_count', 'download_count', 'totalAuthors','recent_documents'));
    }

    public function getChartData(): JsonResponse
    {
        $data = DB::table('documents')
            ->selectRaw('DATE(created_at) as date, SUM(view_count) as total_views, SUM(download_count) as total_downloads')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $views = [];
        $downloads = [];

        foreach ($data as $item) {
            $dates[] = $item->date . 'T00:00:00.000Z';
            $views[] = $item->total_views;
            $downloads[] = $item->total_downloads;
        }

        return response()->json([
            'dates' => $dates,
            'views' => $views,
            'downloads' => $downloads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
