<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomDbChannel;
use App\User;

class HeaderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'url' => $this->notification['url'],
            'message' => $this->notification['message'],
            'type' => $this->notification['type'],
            'type_id' => $this->notification['type_id'],
        ];
    }

    // タイプとタイプIDから通知を削除する
    public static function delete($userId, $type, $typeId){
        $user = User::find($userId);
        $notifications = $user->notifications->where('notifier_id', Auth::id());
        foreach($notifications as $notification){
            if($notification->data['type'] == $type && $notification->data['type_id'] == $typeId){
                $notification->delete();
                break;
            }
        }
    }
}
