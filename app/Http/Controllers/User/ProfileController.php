<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'student_id' => ['required','unique:users', 'string', 'max:255'],
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'faculty_id.required' => 'Fakultas tidak boleh kosong',
            'department_id.required' => 'Departemen tidak boleh kosong',
            'phone.required' => 'Nomor Telepon tidak boleh kosong',
            'student_id.required' => 'NIM tidak boleh kosong',
            'student_id.unique' => 'NIM sudah terdaftar',
        ]);
        $user->update($validated);

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
