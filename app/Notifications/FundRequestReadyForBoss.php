<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\FundRequest;

class FundRequestReadyForBoss extends Notification
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
            'type' => 'ready_for_boss',
            'fund_request_id' => $this->fundRequest->id,
            'title' => 'Permohonan Sedia Untuk Kelulusan',
            'message' => 'Permohonan untuk ' . $this->fundRequest->programReport->name_of_program . ' telah menerima 18 sokongan dan menunggu kelulusan anda.',
            'url' => route('fund-requests.show', $this->fundRequest->id),
        ];
    }
}
