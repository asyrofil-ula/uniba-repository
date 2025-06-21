<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('faculty')->get();

        $faculties = Faculty::all();
        // dd(($departments));
        return view('admin.department', compact('departments', 'faculties'));
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
            'faculty_id' => ['required'],
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'faculty_id.required' => 'Fakultas tidak boleh kosong',
        ]);

        Department::create([
            'name' => $request->name,
            'faculty_id' => $request->faculty_id,
        ]);
        // error message


        return redirect()->route('admin.departments')->with('success', 'Data Berhasil Ditambahkan');
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
            'name' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required'],
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'faculty_id.required' => 'Fakultas tidak boleh kosong',
        ]);

        Department::where('id', $id)->update([
            'name' => $request->name,
            'faculty_id' => $request->faculty_id,
        ]);

        return redirect()->route('admin.departments')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Department::where('id', $id)->delete();
        return redirect()->route('admin.departments');
    }
}
