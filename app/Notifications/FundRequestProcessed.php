<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\FundRequest;

class FundRequestProcessed extends Notification
{
    use Queueable;

    protected $fundRequest;
    protected $status;

    public function __construct(FundRequest $fundRequest, $status)
    {
        $this->fundRequest = $fundRequest;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $statusText = $this->status === 'approved_by_boss' ? 'DILULUSKAN' : 'DITOLAK';
        
        return [
            'type' => 'processed',
            'fund_request_id' => $this->fundRequest->id,
            'title' => 'Status Permohonan Dana: ' . $statusText,
            'message' => 'Permohonan anda untuk ' . $this->fundRequest->programReport->name_of_program . ' telah ' . strtolower($statusText) . ' oleh Pengerusi.',
            'url' => route('fund-requests.show', $this->fundRequest->id),
        ];
    }
}
