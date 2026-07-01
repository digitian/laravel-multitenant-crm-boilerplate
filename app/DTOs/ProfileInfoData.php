<?php

namespace App\DTOs;

class ProfileInfoData
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public ?string $phone = null,
        public ?string $country = null,
        public ?string $bio = null,
        public ?string $city = null,
        public ?string $address = null,
        public ?string $zip_code = null
    ) {}
}
