<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundRequestApproval extends Model
{
    protected $fillable = [
        'fund_request_id',
        'member_id',
        'status',
        'reason'
    ];

    public function fundRequest()
    {
        return $this->belongsTo(FundRequest::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
