<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $email;
    public $password;
    public $verificationLink;

    public function __construct($user,$email, $password, $verificationLink)
    {
        //
        $this->user = $user;
        $this->email = $email;
        $this->password = $password;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        if($this->password == ''){
            return $this->subject('Nice Registration Confirmation Email')
                ->view('emails.studentRegistration');
        }else{
            return $this->subject('Nice Registration Verify Your Email')
                ->view('emails.studentVerification');
        }

    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    /*public function envelope()
    {
        return new Envelope(
            subject: 'Custom Verification Email',
        );
    }*/

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    /*public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    /*public function attachments()
    {
        return [];
    }*/
}
