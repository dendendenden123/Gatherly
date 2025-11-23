<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;
    public $isMinister;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string  $status
     * @param  bool  $isMinister
     * @return void
     */
    public function __construct($user, $status, $isMinister = false)
    {
        $this->user = $user;
        $this->status = $status;
        $this->isMinister = $isMinister;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->isMinister 
            ? "Member Status Update: {$this->user->first_name} {$this->user->last_name} is {$this->status}"
            : "Your Member Status Update: {$this->status}";

        return $this->subject($subject)
                    ->view('emails.member-status')
                    ->with([
                        'user' => $this->user,
                        'status' => $this->status,
                        'isMinister' => $this->isMinister
                    ]);
    }
}
