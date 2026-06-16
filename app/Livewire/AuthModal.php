<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthModal extends Component
{
    public $isOpen = false;
    public $isRegister = false;

    // Login fields
    public $login_email = '';
    public $login_password = '';

    // Register fields
    public $reg_name = '';
    public $reg_email = '';
    public $reg_password = '';
    public $reg_password_confirmation = '';

    protected $listeners = ['triggerAuthGate' => 'openModal', 'closeAuthGate' => 'closeModal'];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function toggleState()
    {
        $this->isRegister = !$this->isRegister;
        $this->resetErrorBag();
    }

    public function login()
    {
        $this->validate([
            'login_email' => 'required|email',
            'login_password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->login_email, 'password' => $this->login_password])) {
            session()->regenerate();
            $this->isOpen = false;
            $this->dispatch('userAuthenticated');
            
            // Redirect admin to admin panel if the admin logging in
            if ($this->login_email === 'test@example.com') {
                return redirect()->intended('/admin');
            }

            return redirect()->route('catalog');
        }

        $this->addError('login_email', 'Kredensial yang diberikan tidak cocok dengan catatan kami.');
    }

    public function register()
    {
        $this->validate([
            'reg_name' => 'required|string|max:255',
            'reg_email' => 'required|string|email|max:255|unique:users,email',
            'reg_password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $this->reg_name,
            'email' => $this->reg_email,
            'password' => bcrypt($this->reg_password),
        ]);

        // Post-Register Synchronization requirement:
        // Clear fields and slide back to a clean Login form state, forcing manual login
        $this->reg_name = '';
        $this->reg_email = '';
        $this->reg_password = '';
        $this->reg_password_confirmation = '';
        $this->isRegister = false; // Slide back to login
        
        session()->flash('success_register', 'Pendaftaran berhasil! Silakan masuk menggunakan akun baru Anda.');
    }

    public function render()
    {
        return view('livewire.auth-modal');
    }
}
