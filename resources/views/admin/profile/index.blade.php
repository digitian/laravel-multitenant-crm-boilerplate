@extends('layouts.admin.app')

@section('content')
{{-- Page Header --}}
<x-page-header title="Profile" pretitle="You can view and edit your personal informations here" />

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
                                <button class="btn btn-outline-info w-100 mb-2">Upload a photo</button>
                                <button class="btn btn-danger w-100">Delete profile picture</button>
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

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection