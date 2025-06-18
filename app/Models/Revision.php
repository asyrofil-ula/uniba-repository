<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revisions';

    protected $fillable = [
        'document_id',
        'user_id',
        'revision_note',
        'file_path',
        'file_name',
        'file_size',
        'file_mime_type',
    ];
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
