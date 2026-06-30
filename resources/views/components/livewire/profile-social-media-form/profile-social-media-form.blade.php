<div class="card">

    {{-- Card Header --}}
    <div class="card-header">
        <h3 class="card-title">Social Media</h3>
    </div>

    {{-- Card Body --}}
    <div class="card-body">

        <form wire:submit.prevent="updateSocialMedia" id="social-media-form">

            {{-- Input: Linkedin --}}
            <div class="mb-3">
                <label for="linkedin_url" class="form-label">Linkedin</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-linkedin">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 11v5" />
                            <path d="M8 8v.01" />
                            <path d="M12 16v-5" />
                            <path d="M16 16v-3a2 2 0 1 0 -4 0" />
                            <path
                                d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10" />
                        </svg>
                    </span>
                    <input type="url" id="linkedin_url" class="form-control" wire:model="form.linkedin_url"
                        placeholder="Enter your linkedin url.">
                </div>
            </div>

            {{-- Input: Facebook --}}
            <div class="mb-3">
                <label for="facebook_url" class="form-label">Facebook</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                        </svg>
                    </span>
                    <input type="url" id="facebook_url" class="form-control" wire:model="form.facebook_url"
                        placeholder="Enter your facebook url.">
                </div>
            </div>

            {{-- Input: Instagram --}}
            <div class="mb-3">
                <label for="instagram_url" class="form-label">Instagram</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4l0 -8" />
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                            <path d="M16.5 7.5v.01" />
                        </svg>
                    </span>
                    <input type="url" id="instagram_url" class="form-control" wire:model="form.instagram_url"
                        placeholder="Enter your instagram url.">
                </div>
            </div>

            {{-- Input: X --}}
            <div class="mb-3">
                <label for="x_url" class="form-label">X</label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 4l11.733 16h4.267l-11.733 -16l-4.267 0" />
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                        </svg>
                    </span>
                    <input type="url" id="x_url" class="form-control" wire:model="form.x_url"
                        placeholder="Enter your x url.">
                </div>
            </div>

    </div>

    {{-- Card Footer --}}
    <div class="card-footer">
        <button class="btn btn-primary" type="submit" form="social-media-form">Save changes</button>
    </div>

</div>