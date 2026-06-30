<?php

namespace App\DTOs;

class UserSocialMediaData
{
    public function __construct(
        public ?string $linkedin_url = null,
        public ?string $facebook_url = null,
        public ?string $instagram_url = null,
        public ?string $x_url = null
    ) {}
}
