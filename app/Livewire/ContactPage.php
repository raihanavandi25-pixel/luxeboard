<?php

namespace App\Livewire;

use Livewire\Component;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $category = '';
    public $message = '';
    public $isSending = false;

    public function send()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'category' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        // In a real app this would send an email / store a ticket.
        // For now we just flash success.
        session()->flash('contact_success', 'Pesan Anda berhasil dikirim! Tim kami akan merespons dalam 1×24 jam.');

        $this->reset(['name', 'email', 'phone', 'category', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}
