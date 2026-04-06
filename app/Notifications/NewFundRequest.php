<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\FundRequest;

class NewFundRequest extends Notification
{
    use Queueable;

    protected $fundRequest;

    public function __construct(FundRequest $fundRequest)
    {
        $this->fundRequest = $fundRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_request',
            'fund_request_id' => $this->fundRequest->id,
            'title' => 'Permohonan Dana Baru',
            'message' => $this->fundRequest->requester->name . ' telah menghantar permohonan baru untuk ' . $this->fundRequest->programReport->name_of_program,
            'url' => route('fund-requests.show', $this->fundRequest->id),
        ];
    }
}
