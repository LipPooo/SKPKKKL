<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'employee_id',
        'ic_number',
        'password',
        'role',
        'is_approved',
        'profile_photo_path',
    ];

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=E11D48&background=FFE4E6';
    }

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
            'is_approved' => 'boolean',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApproved()
    {
        return $this->is_approved;
    }

    public function programReports()
    {
        return $this->hasMany(ProgramReport::class);
    }

    public function fundRequests()
    {
        return $this->hasMany(FundRequest::class, 'requester_id');
    }

    public function approvals()
    {
        return $this->hasMany(FundRequestApproval::class, 'member_id');
    }
}
