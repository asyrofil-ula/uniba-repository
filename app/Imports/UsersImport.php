<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $faculty = Faculty::where('name', $row['fakultas'])->first();
        $department = Department::where('name', $row['departemen'])->first();

        return new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'role' => $row['role'],
            'phone' => $row['telepon'],
            'student_id' => $row['nim'],
            'lecturer_id' => $row['nip'],
            'faculty_id' => $faculty ? $faculty->id : null,
            'department_id' => $department ? $department->id : null,
            'password' => Hash::make('unibamadura'), // default password
        ]);
    }
}
