<?php

namespace App\Livewire\Forms\Profile;

use App\DTOs\UserSocialMediaData;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SocialMediaForm extends Form
{
    #[Validate(['nullable', 'url', 'max: 255'])]
    public ?string $linkedin_url;

    #[Validate(['nullable', 'url', 'max: 255'])]
    public ?string $facebook_url;

    #[Validate(['nullable', 'url', 'max: 255'])]
    public ?string $x_url;

    #[Validate(['nullable', 'url', 'max: 255'])]
    public ?string $instagram_url;

    public function toDto(): UserSocialMediaData
    {
        return new UserSocialMediaData(
            linkedin_url: $this->linkedin_url,
            facebook_url: $this->facebook_url,
            x_url: $this->x_url,
            instagram_url: $this->instagram_url
        );
    }
}
