<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faculty_id',
        'department_id',
        'document_type_id',
        'title',
        'abstract_id',
        'abstract_en',
        'publication_year',
        'language',
        'file_path',
        'file_name',
        'file_size',
        'file_mime_type',
        'license_id',
        'doi',
        'status',
        'rejection_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
      public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function authors()
    {
        return $this->belongsToMany(User::class, 'authors')
            ->withPivot('author_order', 'is_corresponding')
            ->orderBy('pivot_author_order');
    }

    public function keywords()
{
    return $this->hasMany(Keyword::class);
}


    public function citations()
    {
        return $this->belongsToMany(Document::class, 'citations', 'citing_document_id', 'cited_document_id')
                    ->withTimestamps();
    }

    public function citedBy()
    {
        return $this->belongsToMany(Document::class, 'citations', 'cited_document_id', 'citing_document_id')
                    ->withTimestamps();
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }



}
