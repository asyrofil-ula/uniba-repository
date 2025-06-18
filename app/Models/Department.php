<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = ['name',  'faculty_id'];
    

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }


    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
