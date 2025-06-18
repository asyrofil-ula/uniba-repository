<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keywords';
    protected $fillable = ['keyword'];

   public function document()
{
    return $this->belongsTo(Document::class);
}

}
