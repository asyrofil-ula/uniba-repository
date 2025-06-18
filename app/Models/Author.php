<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = [
        'document_id',
        'user_id',
        'author_order',
        'is_corresponding'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
