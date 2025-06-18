<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'licenses';

    protected $fillable = ['name', 'short_name','description', 'url'];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
