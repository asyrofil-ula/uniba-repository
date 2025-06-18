<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'uploaded_documents' => $user->documents()->count(),
            'published_documents' => $user->documents()->where('status', 'published')->count(),
            'pending_documents' => $user->documents()->where('status', 'under_review')->count(),
            'rejected_documents' => $user->documents()->where('status', 'rejected')->count(),
        ];

        $recentDocuments = $user->documents()
            ->with('documentType')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentDocuments'));
    }
}
