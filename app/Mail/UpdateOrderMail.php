<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;
    public $etat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info,$etat)
    {
        $this->info = $info;
        $this->etat=$etat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->etat)->view('admin.mail.UpdateOrderMail');
    }
}
