<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramReport extends Model
{
    protected $fillable = [
        'user_id',
        'name_of_program',
        'date',
        'type',
        'location',
        'total_members_involved',
        'total_non_members',
        'vip_details',
        'total_participation',
        'collaboration',
        'organizer',
        'budget',
        'payment_details',
        'pic_user_id',
        'recognition',
        'image_proof_path'
    ];

    protected $casts = [
        'date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function fundRequest()
    {
        return $this->hasOne(FundRequest::class);
    }
}
