<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'lecturer_id',
        'phone',
        'faculty_id',
        'department_id',
        'bio',
        'orcid_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function departments()
    {
        return $this->belongsTo(Department::class);
    }


    public function documents()
    {
        return $this->hasMany(Document::class);
    }

        public function authoredDocuments()
    {
        return $this->belongsToMany(Document::class, 'authors')
                    ->withPivot('author_order', 'is_corresponding')
                    ->orderBy('author_order');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function authors()
    {
        return $this->belongsToMany(User::class, 'authors')
                    ->withPivot('author_order', 'is_corresponding')
                    ->orderBy('author_order');
    }

}
