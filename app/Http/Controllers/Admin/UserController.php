<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\User;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Exports\UsersTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('faculty')->withCount('documents');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10)->withQueryString(); // Agar pagination tetap membawa query search

        $faculties = Faculty::with('departments')->get();
        $departments = Department::all();

        return view('admin.users.index', compact('users', 'faculties', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.users.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'faculty_id' => 'required',
            'department_id' => 'required',
            'phone' => 'nullable',
            'student_id' => 'nullable|unique:users,student_id',
            'lecturer_id' => 'nullable|unique:users,lecturer_id',
            'password' => 'required|min:6|confirmed',
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'faculty_id.required' => 'Fakultas tidak boleh kosong',
            'department_id.required' => 'Departemen tidak boleh kosong',
            'student_id.required' => 'NIM tidak boleh kosong',
            'student_id.unique' => 'NIM sudah terdaftar',
            'lecturer_id.unique' => 'NIM sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'faculty_id' => $request->faculty_id,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'student_id' => $request->student_id,
            'lecturer_id' => $request->lecturer_id,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan');
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
                'lecturer_id' => 'nullable|unique:users,lecturer_id,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'role.required' => 'Role tidak boleh kosong',
                'faculty_id.required' => 'Fakultas tidak boleh kosong',
                'department_id.required' => 'Departemen tidak boleh kosong',
                'phone.required' => 'Nomor Telepon tidak boleh kosong',
//                'student_id.required' => 'NIM tidak boleh kosong',
                'student_id.unique' => 'NIM sudah terdaftar',
                'lecturer_id.unique' => 'NIM sudah terdaftar',
//                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Password tidak cocok',
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Data pengguna berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function exportTemplate()
    {
        return Excel::download(new UsersTemplateExport, 'user_template.xlsx');
    }
}
