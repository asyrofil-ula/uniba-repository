<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function index()
    {
        $documents = \App\Models\Document::all();
        $types = DocumentType::withCount('documents')->get();

        $totalDocuments = Document::all()->where('status', 'published')->count();
        $totalFaculties = Faculty::all()->count();
        $totalDownloads = Document::sum('download_count');
        $totalViews = Document::sum('view_count');
//        total author relasi ke user dan yang mempunyai document
        $totalAuthors = Author::with('user')->distinct()->count('user_id');

        $faculties = Faculty::withCount('documents')->get();
        $newDocuments = Document::with(['authors', 'documentType', 'faculty'])->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('landing.index', compact('documents','newDocuments', 'faculties','types', 'totalDocuments', 'totalFaculties', 'totalDownloads', 'totalViews', 'totalAuthors'));
    }

    public function allDocuments(Request $request)
    {
        $query = Document::with(['documentType', 'faculty', 'authors', 'keywords'])
            ->where('status', 'published');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('year')) {
            $query->where('publication_year', $request->year);
        }

        if ($request->filled('faculty_id')) {
            $query->whereIn('faculty_id', $request->faculty_id);
        }

        if ($request->filled('document_type_id')) {
            $query->whereIn('document_type_id', $request->document_type_id);
        }

        $documents = $query->orderByDesc('created_at')->paginate(10);

        $faculties = Faculty::all();
        $documentTypes = DocumentType::all();
        $minYear = Document::min('publication_year') ?? 2000;

        return view('landing.documents', compact('documents', 'faculties', 'documentTypes', 'minYear'));
    }

    public function exploreByFaculty()
    {
        $faculties = Faculty::withCount('documents')->get();
        return view('landing.fakultas', compact('faculties'));
    }

    public function exploreByYear()
    {
        $years = Document::select('publication_year')
            ->distinct()
            ->orderByDesc('publication_year')
            ->pluck('publication_year');
        return view('landing.tahun', compact('years'));
    }

    public function exploreByAuthor()
    {
        $authors = Author::with('user')->get()
            ->unique('user_id')
            ->sortBy(fn($a) => $a->user->name);

        return view('landing.penulis', compact('authors'));
    }

    public function exploreByType()
    {
        $types = DocumentType::withCount('documents')->get();
        return view('landing.jenis-dokumen', compact('types'));
    }

    public function fakultas_detail(string $id)
    {
        $faculty = Faculty::findOrFail($id);
        $documents = $faculty->documents()
            ->where('status', 'published')
            ->with('authors')->latest()->get();

//        dd($documents);
        return view('landing.detail.fakultas', compact('faculty', 'documents'));
    }
    public function tahun_detail(string $year)
    {
        $documents = Document::with('authors')
            ->where('status', 'published')
            ->where('publication_year', $year)->latest()->get();
        return view('landing.detail.tahun', compact('year', 'documents'));
    }

    public function penulis_detail(string $id)
    {
        $author = Author::with('user')->findOrFail($id);

        // Ambil user_id
        $userId = $author->user_id;

        // Ambil semua dokumen yang ditulis oleh user tersebut
        $documents = Document::whereHas('authors', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->where('status', 'published')
            ->with('authors') // authors di sini = Users
            ->latest()
            ->get();

        return view('landing.detail.penulis', compact('author', 'documents'));
    }


    public function jenis_dokumen_detail(string $id)
    {
        $type = DocumentType::findOrFail($id);

        $documents = $type->documents()
            ->where('status', 'published')
            ->with([
                'authors' => fn ($query) => $query->orderBy('author_order')
            ])
            ->latest()
            ->get();

        return view('landing.detail.jenis-dokumen', compact('type', 'documents'));
    }



    public function search(Request $request)
    {
        // Ambil semua parameter pencarian
        $searchQuery = $request->q;
        $year = $request->year;
        $facultyIds = (array)$request->faculty_id;
        $documentTypeIds = (array)$request->document_type_id;
        $sort = $request->sort ?? 'relevance';

        // Query dasar
        $query = Document::with(['documentType', 'faculty', 'authors', 'keywords'])
            ->where('status', 'published');

        // Filter pencarian teks
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%$searchQuery%")
                  ->orWhere('abstract_id', 'like', "%$searchQuery%")
                  ->orWhere('abstract_en', 'like', "%$searchQuery%")
                  ->orWhereHas('keywords', function($k) use ($searchQuery) {
                      $k->where('keyword', 'like', "%$searchQuery%");
                  })
                  ->orWhereHas('authors', function($a) use ($searchQuery) {
                      $a->where('name', 'like', "%$searchQuery%");
                  });
            });
        }

        // Filter penulis
        if ($request->filled('author')) {
            $author = $request->input('author');
            $query->whereHas('authors', function ($q) use ($author) {
                $q->where('name', 'like', "%{$author}%");
            });
        }

        // Filter tahun
        if ($year) {
            $query->where('publication_year', '<=', $year);
        }

        // Filter fakultas
        if (!empty($facultyIds)) {
            $query->whereIn('faculty_id', $facultyIds);
        }

        // Filter jenis dokumen
        if (!empty($documentTypeIds)) {
            $query->whereIn('document_type_id', $documentTypeIds);
        }

        // Sorting
        switch ($sort) {
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'title_asc':
                $query->orderBy('title');
                break;
            case 'title_desc':
                $query->orderByDesc('title');
                break;
            case 'popular':
                $query->orderByDesc('views');
                break;
            default: // relevance
                if ($searchQuery) {
                    $query->orderByRaw("
                        CASE
                            WHEN title LIKE '%$searchQuery%' THEN 1
                            WHEN abstract_id LIKE '%$searchQuery%' THEN 2
                            WHEN abstract_en LIKE '%$searchQuery%' THEN 3
                            ELSE 4
                        END
                    ");
                } else {
                    $query->orderByDesc('created_at');
                }
                break;
        }

        // Data untuk filter
        $faculties = Faculty::orderBy('name')->get();
        $documentTypes = DocumentType::orderBy('name')->get();
        $minYear = Document::min('publication_year') ?? 2000;

        // Paginasi hasil
        $documents = $query->paginate(10)
            ->appends($request->query());

        return view('landing.result', compact(
            'documents',
            'faculties',
            'documentTypes',
            'minYear',
            'searchQuery'
        ));
    }

    public function show(Document $document)
    {
        // Ambil array dari session (jika belum ada, defaultkan array kosong)
        $viewed = session()->get('viewed_documents', []);

        // Jika dokumen ini belum pernah dilihat dalam sesi ini
        if (!in_array($document->id, $viewed)) {
            $document->increment('view_count'); // Tambah view
            session()->push('viewed_documents', $document->id); // Simpan ID ke session
        }

        // Load relasi
        $document->load([
            'documentType',
            'faculty',
            'department',
            'authors',
            'keywords'
        ]);

        // Ambil dokumen terkait
        $relatedDocuments = Document::with(['documentType', 'authors'])
            ->where('id', '!=', $document->id)
            ->where('faculty_id', $document->faculty_id)
            ->where('document_type_id', $document->document_type_id)
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        return view('landing.item-detail', compact('document', 'relatedDocuments'));
    }


    public function download(Document $document)
    {
        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

//        ambil array dari session (jika belum ada, defaultkan array kosong)
        $downloaded = session()->get('downloaded_documents', []);

        // Jika dokumen ini belum pernah diunduh dalam sesi ini
        if (!in_array($document->id, $downloaded)) {
            $document->increment('download_count'); // Tambah download
            session()->push('downloaded_documents', $document->id); // Simpan ID ke session
        }

        // Get file path
        $filePath = storage_path('app/public/' . $document->file_path);

        // Return download response
        return response()->download($filePath, $document->file_name);
    }
}
