<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\FundRequest;
use App\Models\User;

class FundRequestSupported extends Notification
{
    use Queueable;

    protected $fundRequest;
    protected $supporter;

    public function __construct(FundRequest $fundRequest, User $supporter)
    {
        $this->fundRequest = $fundRequest;
        $this->supporter = $supporter;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'supported_request',
            'fund_request_id' => $this->fundRequest->id,
            'title' => 'Sokongan Diterima',
            'message' => $this->supporter->name . ' telah menyokong permohonan ' . $this->fundRequest->programReport->name_of_program . '. (' . $this->fundRequest->total_member_approvals . '/18)',
            'url' => route('fund-requests.show', $this->fundRequest->id),
        ];
    }
}
