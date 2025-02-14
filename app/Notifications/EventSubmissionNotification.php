<?php
namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EventSubmissionNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'    => 'Pengajuan Event Baru',
            'message'  => 'Event "' . $this->event->title . '" telah diajukan.',
            'event_id' => $this->event->id,
            'status'   => $this->event->status,
        ];
    }   
}
