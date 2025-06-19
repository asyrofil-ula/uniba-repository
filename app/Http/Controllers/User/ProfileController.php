<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->load(['departments', 'faculty']);
        $faculties = \App\Models\Faculty::all();
        $departments = \App\Models\Department::all();
        return view('user.profile.index', compact('user', 'faculties', 'departments'));
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
        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'phone' => ['required', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:255'],
            'lecturer_id' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],

        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'faculty_id.required' => 'Fakultas tidak boleh kosong',
            'department_id.required' => 'Departemen tidak boleh kosong',
            'phone.required' => 'Nomor Telepon tidak boleh kosong',
            'student_id.required' => 'NIM tidak boleh kosong',
//            'student_id.unique' => 'NIM sudah terdaftar',
//            'lecturer_id.unique' => 'NIP sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
//            'role' => $request->role,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'student_id' => $request->student_id,
            'lecturer_id' => $request->lecturer_id,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
