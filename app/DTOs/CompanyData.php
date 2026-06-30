<?php

namespace App\DTOs;

class CompanyData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $country,
        public string $city,
        public ?string $slug = null,
        public ?int $created_by = null,
        public ?string $address = null,
        public ?string $tax_number = null,
        public ?string $vat_number = null,
        public ?string $website = null,
        public ?string $status = null,
    ) {}
}
