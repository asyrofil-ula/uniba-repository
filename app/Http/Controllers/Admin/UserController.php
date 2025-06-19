<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('faculty')->withCount('documents')->paginate(5);
        // dd($users);
        $faculties = Faculty::all();


        return view('admin.users.index', compact('users', 'faculties'));
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
        $user = User::with('faculty')->withCount('documents')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('faculty')->withCount('documents')->findOrFail($id);
        $departments = Department::where('faculty_id', $user->faculty_id)->get();
        $faculties = Faculty::all();
        return view('admin.users.edit', compact('user', 'faculties', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
                'faculty_id' => 'required',
                'department_id' => 'required',
                'phone' => 'required',
                'student_id' => 'nullable|unique:users,student_id,' . $user->id,
                'lecturer_id' => 'nullable|unique:users,lecturer_id,' . $user->id
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'role.required' => 'Role tidak boleh kosong',
                'faculty_id.required' => 'Fakultas tidak boleh kosong',
                'department_id.required' => 'Departemen tidak boleh kosong',
                'phone.required' => 'Nomor Telepon tidak boleh kosong',
//                'student_id.required' => 'NIM tidak boleh kosong',
                'student_id.unique' => 'NIM sudah terdaftar',
                'lecturer_id.unique' => 'NIM sudah terdaftar'
            ]);
            $user->update($validated);
            return redirect()->route('admin.users')->with('success', 'Update Berhasil');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->withInput()
                ->with('error', 'Gagal memperbarui data pengguna. ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
