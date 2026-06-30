<?php

use App\Actions\UpdateUserSocialMedia;
use App\Livewire\Forms\Profile\SocialMediaForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public SocialMediaForm $form;

    public function mount()
    {
        $this->form->facebook_url = Auth::user()->facebook_url;
        $this->form->x_url = Auth::user()->x_url;
        $this->form->linkedin_url = Auth::user()->linkedin_url;
        $this->form->instagram_url = Auth::user()->instagram_url;
    }

    public function updateSocialMedia(UpdateUserSocialMedia $action)
    {
        $this->form->validate();

        $action->execute(Auth::user(), $this->form->toDto());

        flash()->success('Social media information updated successfully.');
    }
};
