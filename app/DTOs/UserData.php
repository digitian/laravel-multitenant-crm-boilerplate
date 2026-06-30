<?php

namespace App\DTOs;

class UserData
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,
        public ?string $title = null,
        public ?string $phone = null,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $zip_code = null,
        public ?int $company_id = null,
        public ?array $roles = null
    ) {}
}
