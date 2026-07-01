<?php

use App\Actions\UpdateProfileInfo;
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
        $this->form->address = Auth::user()->address;
        $this->form->city = Auth::user()->city;
        $this->form->zip_code = Auth::user()->zip_code;
    }

    public function updateProfileInfo(UpdateProfileInfo $action)
    {
        $this->form->validate();

        $action->execute(Auth::user(), $this->form->toDto());

        flash()->success('Profile updated successfully');

        return $this->js("setTimeout(() => { window.location.href = '".route('profile.settings')."'; }, 1000);");
    }
};
