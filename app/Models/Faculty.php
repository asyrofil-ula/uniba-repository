<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $fillable = [
        'name',
        'code',

        'icon',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
