<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([]);
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
