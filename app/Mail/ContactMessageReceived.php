<?php
namespace App\Mail;
use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class ContactMessageReceived extends Mailable { public function __construct(public ContactMessage $contactMessage){} public function envelope():Envelope{return new Envelope(subject:'New '.ucfirst($this->contactMessage->type).' message from '.$this->contactMessage->name);} public function content():Content{return new Content(view:'emails.contact-message');} }
