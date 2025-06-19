<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::with(['faculty', 'department'])->get();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->role,
            $user->phone,
            $user->student_id,
            $user->lecturer_id,
            $user->faculty ? $user->faculty->name : '',
            $user->department ? $user->department->name : '',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Role',
            'Telepon',
            'NIM',
            'NIP',
            'Fakultas',
            'Departemen',
        ];
    }
}
