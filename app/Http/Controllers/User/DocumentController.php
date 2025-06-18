<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentTypes = \App\Models\DocumentType::all();
        $documents = \App\Models\Document::where('user_id', Auth::user()->id)->paginate(5);
        return view('user.documents.index', compact('documentTypes', 'documents'));
    }

     public function departments($id)
    {
        $faculty = Faculty::with('departments')->findOrFail($id);
        return response()->json($faculty->departments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentTypes = \App\Models\DocumentType::all();
        $departments = \App\Models\Department::all();
        $faculties = \App\Models\Faculty::all();
        return view('user.documents.create', compact('documentTypes', 'faculties', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'abstract_id' => 'required|string',
            'publication_year' => 'required|integer|min:2000|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'keywords' => 'required|array|min:3',
            'keywords.*' => 'string|max:50',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        // Create the document
        $document = Auth::user()->documents()->create([
            'title' => $request->title,
            'document_type_id' => $request->document_type_id,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'abstract_id' => $request->abstract_id,
            'abstract_en' => $request->abstract_en,
            'publication_year' => $request->publication_year,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            // file size dalam kb
            'file_size' => $file->getSize() / 1024,
            'file_mime_type' => $file->getMimeType(),
            'status' => 'under_review',
        ]);
         // Add keywords
        foreach ($request->keywords as $keyword) {
            $document->keywords()->create(['keyword' => $keyword]);
        }

        // Add author (student)
        $document->authors()->attach(Auth::id(), [
            'author_order' => 1,
            'is_corresponding' => true
        ]);

        return redirect()->route('user.documents.index')->with('success', 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::findOrFail($id);
        $document->load(['documentType', 'faculty', 'department', 'keywords', 'authors']);
        
        return view('user.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = \App\Models\Document::findOrFail($id);
        $documentTypes = \App\Models\DocumentType::all();
        $faculties = \App\Models\Faculty::all();
        $departments = \App\Models\Department::where('faculty_id', $document->faculty_id)->get();
        $keywords = $document->keywords->pluck('keyword')->toArray();

        return view('user.documents.edit', compact('document', 'documentTypes', 'faculties', 'departments', 'keywords'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        if($document->status === 'published'){
            return redirect()->route('user.documents.index')->with('error', 'Document already published.');
            
        }
        $request->validate([
           'title' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'abstract_id' => 'required|string',
            'publication_year' => 'required|integer|min:2000|max:' . date('Y'),
            // 'language' => 'required|in:id,en,both',
            'file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'keywords' => 'required|array|min:3',
            'keywords.*' => 'string|max:50', 
        ]);
         $data = [
            'title' => $request->title,
            'document_type_id' => $request->document_type_id,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'abstract_id' => $request->abstract_id,
            'abstract_en' => $request->abstract_en,
            'publication_year' => $request->publication_year,
            // 'language' => $request->language,
            'status' => 'under_review',
        ];
         // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize() / 1024;
            $data['file_mime_type'] = $file->getMimeType();
        }

        $document->update($data);

        // Update keywords
        $document->keywords()->delete(); // Delete existing keywords
        foreach ($request->keywords as $keyword) {
            $document->keywords()->create(['keyword' => $keyword]);
        }
        return redirect()->route('user.documents.index')->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function search(Request $request)
    {
        $query = Document::query()
            ->where('status', 'published')
            ->with(['documentType', 'user'])
            ->orderBy('created_at', 'desc');

        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('abstract_id', 'like', "%$search%")
                  ->orWhere('abstract_en', 'like', "%$search%")
                  ->orWhereHas('keywords', function($k) use ($search) {
                      $k->where('keyword', 'like', "%$search%");
                  });
            });
        }

        if ($request->has('document_type_id')) {
            $query->where('document_type_id', $request->document_type_id);
        }

        if ($request->has('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->has('year')) {
            $query->where('publication_year', $request->year);
        }

        $documents = $query->paginate(10);
        $documentTypes = DocumentType::all();
        $faculties = Faculty::all();
        $years = Document::select('publication_year')
            ->distinct()
            ->orderBy('publication_year', 'desc')
            ->pluck('publication_year');

        return view('user.documents.search', compact('documents', 'documentTypes', 'faculties', 'years'));
    }
}
