<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty as ModelsFaculties;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class Faculties extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultas = ModelsFaculties::all();
        return view('admin.faculties', compact('fakultas'));
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'unique:faculties','string', 'max:255'],
//            'icon' => ['required','file','mimes:jpg,jpeg,png'],
        ],[
            'name.required' => 'Nama Fakultas Harus Di Isi',
            'code.required' => 'Kode Fakultas Harus Di Isi',
            'code.unique' => 'Kode Fakultas Sudah Terdaftar',
        ]);

//        $file = $request->file('icon');
//        $fileName = time() . '.' . $file->getClientOriginalExtension();
//        $file->storeAs('faculties', $fileName, 'public');

        ModelsFaculties::create([
            'name' => $request->name,
            'code' => $request->code,
//            'icon' => $fileName
        ]);


        return redirect()->route('admin.faculties')->with('success', 'Fakultas Berhasil Ditambahkan');
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'icon' => ['file','mimes:jpg,jpeg,png'],
        ]);

        if ($request->hasFile('icon')) {
           if(ModelsFaculties::where('id', $id)->first()->icon){
                Storage::delete('faculties/'.ModelsFaculties::where('id', $id)->first()->icon);
            }
            $file = $request->file('icon');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('faculties', $fileName, 'public');
            ModelsFaculties::where('id', $id)->update([
                'icon' => $fileName
            ]);
        }


        ModelsFaculties::where('id', $id)->update([
            'name' => $request->name,
            'code' => $request->code,
            // 'icon' => $fileName
        ]);


        return redirect()->route('admin.faculties')->with('success', 'Fakultas Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsFaculties::where('id', $id)->delete();
        return redirect()->route('admin.faculties')->with('success', 'Fakultas Berhasil Dihapus');
    }
}
