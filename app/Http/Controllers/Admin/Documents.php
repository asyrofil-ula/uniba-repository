<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document as ModelsDocuments;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Documents extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = ModelsDocuments::paginate(3);
        $totalDocuments = ModelsDocuments::count();
        $faculties = Faculty::all();
        return view('admin.documents.documents', compact('documents',  'faculties', 'totalDocuments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            //    'user_id' => ,
            'category_id' => 'required|exists:categories,id',
            'faculty_id' => 'required|exists:faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:20480',
            'author' => 'required|string|max:255',
            'discipline' => 'required|string|max:255',
            'year' =>  'required|integer|min:1900|max:' . (date('Y') + 1),
            'collection_type' => 'required|in:skripsi,thesis,jurnal,laporan',
            //    'is_public' => 'sometimes|boolean',
        ]);

        // simpan melalui storage link
        $file = $request->file('file_path');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/documents', $fileName);


        ModelsDocuments::create([
            'user_id' => Auth::user()->id,
            'category_id' => $validated['category_id'],
            'faculty_id' => $validated['faculty_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $fileName,
            'author' => $validated['author'],
            'discipline' => $validated['discipline'],
            'year' => $validated['year'],
            'collection_type' => $validated['collection_type'],
            // 'is_public' => $validated['is_public'],
        ]);

        return redirect()->route('admin.documents');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = ModelsDocuments::findOrFail($id);
        $document->load([
            'user',
            'faculty',
            'department',
            'documentType',
            'license',
            'authors',
            'keywords',
            'downloads' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'views' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'revisions'
        ]);

        return view('admin.documents.document-show', compact('document'));
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
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'faculty_id' => 'required|exists:faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Ubah menjadi nullable
            'author' => 'required|string|max:255',
            'discipline' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'collection_type' => 'required|in:skripsi,thesis,jurnal,laporan',
            'is_public' => 'sometimes|boolean',
        ]);

        $document = ModelsDocuments::findOrFail($id);

        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($document->file_path) {
                Storage::delete('public/documents/' . $document->file_path);
            }

            // Upload file baru
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/documents', $fileName);
            $validated['file_path'] = $fileName;
        }

        $document->update($validated);

        return redirect()->route('admin.documents')->with('success', 'Dokumen berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsDocuments::where('id', $id)->delete();
        return redirect()->route('admin.documents');
    }

    public function review(Request $request, string $id)
    {
        $document = ModelsDocuments::findOrFail($id);
        $request->validate([
            'status' => 'required|in:published,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500'
        ]);

        $document->update([
            'status' => $request->status,
            'rejection_reason' => $request->rejection_reason
        ]);

        if ($request->status === 'published') {
            $document->update([
                'published_at' => now()
            ]);
        }

        if ($request->status === 'rejected') {
            $document->revisions()->create([
                'user_id' => Auth::user()->id,
                'status' => $request->status,
                'revision_note' => $request->rejection_reason,
                'document_id' => $document->id,
            ]);
        }

        return redirect()->route('admin.documents')->with('success', 'Document reviewed successfully.');
    }

    public function download(string $id)
    {
        $document = ModelsDocuments::findOrFail($id);
        return Storage::download('public/documents/' . $document->file_path);
    }
}
