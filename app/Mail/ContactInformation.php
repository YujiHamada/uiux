<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactInformation extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $url;
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $url, $contact) {
      $this->name = $name;
      $this->email = $email;
      $this->url = $url;
      $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
      return $this->view('emails.contact-information')
                  ->with([
                    'name' => $this->name,
                    'email' => $this->email,
                    'url' => $this->url,
                    'contact' => $this->contact,
                  ]);
    }
}
