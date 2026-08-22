<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class PriorityQueueOverdueNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $daysWaiting;

    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     * @param int $daysWaiting
     */
    public function __construct(Ticket $ticket, int $daysWaiting)
    {
        $this->ticket = $ticket;
        $this->daysWaiting = $daysWaiting;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $namaInstansi = $this->ticket->pelapor->instansi->nama_instansi ?? 'Koperasi';
        
        return [
            'title' => 'Tiket Prioritas Menunggu (≥ 5 Hari)',
            'message' => "Tiket {$this->ticket->ticket_id} ({$namaInstansi}) sudah menunggu {$this->daysWaiting} hari dan memerlukan penanganan segera.",
            'ticket_id' => $this->ticket->ticket_id,
            'days_waiting' => $this->daysWaiting,
            'url' => route('support.prioritas', ['search' => $this->ticket->ticket_id]),
        ];
    }
}
