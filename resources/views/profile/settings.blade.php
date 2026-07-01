@extends('layouts.admin.app')

@section('content')
{{-- Page Header --}}
<x-page-header title="Settings" pretitle="You can view and edit your credentials here" />

{{-- Page Body --}}
<div class="page-body">
    <div class="container-xl">

        <div class="row row-cards">

            {{-- Card: Personal Information --}}
            <div class="col-lg-8">
                <livewire:livewire.profile-info-form />
            </div>

            <div class="col-lg-4">

                {{-- Card: Profile Picture --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Profile Picture</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Col 1: Profile picture --}}
                            <div class="col-md-6">
                                @if (auth()->user()->profile_picture_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture_path) }}" alt=""
                                    class="w-100 ratio ratio-1x1 rounded object-fit-cover">
                                @else
                                <div class="bg-muted-lt rounded w-100 d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <span class="fs-1">{{
                                        auth()->user()->first_name[0]
                                        }}{{
                                        auth()->user()->last_name[0]
                                        }}</span>
                                </div>
                                @endif
                            </div>

                            {{-- Col 2: Upload profile picture --}}
                            <div class="col-md-6">
                                <form action="{{ route('profile.photo-upload') }}" method="POST"
                                    enctype="multipart/form-data" class="mb-2">
                                    @method('put')
                                    @csrf
                                    <input type="file" name="profile_picture_path" class="form-control"
                                        id="profile_picture_path" accept="image/*" onchange="this.form.submit()" hidden>
                                    <label class="btn btn-outline-info w-100" for="profile_picture_path">Upload a
                                        photo</label>
                                    <x-input-error :messages="$errors->get('profile_picture_path')" class="mt-2" />
                                </form>
                                @if (auth()->user()->profile_picture_path)
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-photo">Delete profile
                                    picture</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Social Media --}}
                <livewire:livewire.profile-social-media-form />
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<div class="modal modal-blur fade" id="modal-delete-photo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h3>Are you sure?</h3>
                <div class="text-secondary">Do you really want to delete your profile picture? This action cannot be
                    undone.
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Cancel
                            </a></div>
                        <div class="col">
                            <form action="{{ route('profile.delete-photo') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    Yes, delete it
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection