<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $msg;
    
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct(protected $otp, $msg = null, $name)
    {
        $this->msg = $msg;
        
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->msg ? $this-> name.' has tried to access Listing Portal From Non Registered PC' : 'OTP For Login Listing Portal',
        );
    }

    /**
     * OTP
     *
     * @return void
     */
    public function build()
    {
        return $this->view('emails.otp')->with('otp', $this->otp);
    }
}
