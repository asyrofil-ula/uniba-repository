<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentTypes = DocumentType::all();
        return view('admin.documents.document-type', compact('documentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        DocumentType::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.documenttypes')->with('success', 'Jenis dokumen berhasil ditambahkan.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $documentType = DocumentType::findOrFail($id);
        $documentType->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.documenttypes')->with('success', 'Jenis dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $documentType = DocumentType::findOrFail($id);
        $documentType->delete();
        return redirect()->route('admin.documenttypes')->with('success', 'Jenis dokumen berhasil dihapus.');
    }
}
