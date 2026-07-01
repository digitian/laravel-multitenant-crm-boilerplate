<div class="card">
    <div class="card-header">
        <h3 class="card-title">Personal Information</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="updateProfileInfo" id="profile-info-form">
            <div class="row g-3">

                {{-- Input: First Name --}}
                <div class="col-md-6">
                    <label class="form-label required" for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" wire:model="form.first_name">
                    <x-input-error :messages="$errors->get('form.first_name')" />
                </div>

                {{-- Input: Last Name --}}
                <div class="col-md-6">
                    <label class="form-label required" for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" wire:model="form.last_name">
                    <x-input-error :messages="$errors->get('form.last_name')" />
                </div>

                {{-- Input: Email --}}
                <div class="col-md-6">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" disabled>
                    <small class="form-hint">E-mail address cannot be changed in profile page. Please contact your
                        manager.</small>
                </div>

                {{-- Input: Phone Number --}}
                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" wire:model="form.phone">
                    <x-input-error :messages="$errors->get('form.phone')" />
                </div>

                {{-- Textarea: Bio (Uses alpine.js based character counter / limiter) --}}
                <div class="col-12" x-data="{
                    character_count: '{{ $form->bio ? Str::length($form->bio) : 0 }}',
                    max_characters: 500
                }">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea name="bio" id="bio" rows="4" class="form-control"
                        placeholder="You can write about yourself here." wire:model="form.bio" x-ref="bio"
                        maxlength="500"
                        @input="if ($refs.bio.value.length > max_characters) { $refs.bio.value = $refs.bio.value.substring(0, max_characters); } character_count = $refs.bio.value.length"></textarea>
                    <small class="form-hint" x-text="character_count + ' / ' + max_characters"></small>
                    <x-input-error :messages="$errors->get('form.phone')" />
                </div>

                {{-- Select: Country (Livewire component) --}}
                <div class="col-md-6">
                    <livewire:input-country-select wire:model="form.country" />
                    <x-input-error :messages="$errors->get('form.country')" />
                </div>

                {{-- Input: City --}}
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" wire:model="form.city" id="city" class="form-control"
                        placeholder="Enter your city.">
                    <x-input-error :messages="$errors->get('form.city')" />
                </div>

                {{-- Textarea: Address --}}
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" wire:model="form.address" id="address" class="form-control"
                        placeholder="Enter your residental address."></input>
                    <x-input-error :messages="$errors->get('form.address')" />
                </div>

                {{-- Input: Zip Code --}}
                <div class="col-md-6">
                    <label for="zip_code" class="form-label">Zip Code</label>
                    <input type="text" wire:model="form.zip_code" id="zip_code" class="form-control"
                        placeholder="Enter your zip code.">
                    <x-input-error :messages="$errors->get('form.zip_code')" />
                </div>

            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" type="submit" form="profile-info-form" wire:loading.attr="disabled">
            <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                <span class="visually-hidden">Saving...</span>
            </div>
            <span wire:loading.remove>Save changes</span>
            <span wire:loading>Saving...</span>
        </button>
    </div>
</div>