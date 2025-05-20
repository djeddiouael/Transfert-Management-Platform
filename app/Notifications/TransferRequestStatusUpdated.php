<?php

namespace App\Notifications;

use App\Models\TransferRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferRequestStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $transferRequest;

    public function __construct(TransferRequest $transferRequest)
    {
        $this->transferRequest = $transferRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $status = $this->transferRequest->status_text;
        $details = $this->transferRequest->status_details;

        return (new MailMessage)
            ->subject('Mise à jour de votre demande de transfert')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Le statut de votre demande de transfert a été mis à jour.')
            ->line('Nouveau statut : ' . $status)
            ->line('Détails : ' . $details)
            ->action('Voir les détails', url('/student/transfer-status'))
            ->line('Merci d\'utiliser notre service.');
    }

    public function toArray($notifiable)
    {
        return [
            'transfer_request_id' => $this->transferRequest->id,
            'status' => $this->transferRequest->status,
            'status_text' => $this->transferRequest->status_text,
            'status_details' => $this->transferRequest->status_details
        ];
    }
} 