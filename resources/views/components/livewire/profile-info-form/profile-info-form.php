<?php

use App\Livewire\Forms\Profile\ProfileInfoForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public ProfileInfoForm $form;

    public function mount()
    {
        $this->form->first_name = Auth::user()->first_name;
        $this->form->last_name = Auth::user()->last_name;
        $this->form->phone = Auth::user()->phone;
        $this->form->country = Auth::user()->country;
        $this->form->bio = Auth::user()->bio;
    }

    public function updateProfileInfo() {}
};
