<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Setting;

class FileUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    var $file;
    var $url;
    var $message;
    var $user;
    var $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($f, $message, $user, $type = "FOLLOWING")
    {
        $this->file = $f;
        $this->user = $user;
        $this->type = $type;
        $this->message = $message;
        $this->url  = route('dashboard')."?file_id=".$this->file->id."&message=".$message;

        $host = Setting::where('key', 'mail_host')->first()->value;
        $username = Setting::where('key', 'mail_username')->first()->value;
        $password = Setting::where('key', 'mail_password')->first()->value;
        $port = Setting::where('key', 'mail_port')->first()->value;
        $encryption = Setting::where('key', 'mail_encryption')->first()->value;
        $sender = Setting::where('key', 'mail_sender')->first()->value;
        $name = Setting::where('key', 'name')->first()->value;

        // dump(config('mail.username'));
        // dump(config('mail.host'));

        config(['mail.host' => $host]);
        config(['mail.username' => $username]);
        config(['mail.password' => $password]);
        config(['mail.port' => $port]);
        config(['mail.encryption' => $encryption]);
        config(['mail.from' => [
                        'address' => $sender,
                        'name' => $name]
                    ]);

        // dd(config('mail.username'));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $send_email = Setting::where('key', 'send_email')->first()->value;
        if($send_email == 'Yes')
            return ['mail', 'database'];
        else
            return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        

        // switch ($type) {
        //     case 'FOLLOWING':
        //         $line = 'You are getting this message because you are following this file.';
        //         break;
            
        //     case 'STATE_NOTIFICATION':
        //         $line = 'You are getting this message because you are selected to be notified when a file enters this state on the workflow.';
        //         break;
            
        //     case 'STATE_ASSIGNEE':
        //         $line = 'You are getting this message because files are assigned to you once they enter this state on the workflow.';
        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }


        return (new MailMessage)
                    ->subject('Beamco Forms: File notification for '.$this->file->name)
                    ->greeting('Hello '.$this->user->first_name.',')
                    ->line($this->message)
                    ->action('View File Details', $this->url);
                    // ->line($line);
                    

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
            'file_id'   => $this->file->id,
            'url'       => $this->url,
            'message'   => $this->message
        ];
    }
}
