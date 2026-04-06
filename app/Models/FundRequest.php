<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    protected $fillable = [
        'program_report_id',
        'requester_id',
        'total_member_approvals',
        'status',
        'rejection_reason',
        'approval_reason'
    ];

    public function programReport()
    {
        return $this->belongsTo(ProgramReport::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function approvals()
    {
        return $this->hasMany(FundRequestApproval::class);
    }
}
