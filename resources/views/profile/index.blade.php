@extends(auth()->user()->hasRole('admin') ? 'layouts.admin.app' : 'layouts.authenticated.app')

@section('content')
{{-- Page Header --}}
<x-page-header title="Profile" pretitle="View your public profile here" />

{{-- Page Body --}}
<div class="page-body">
    <div class="container-xl">
        <div class="row g-3">
            <div class="col-12">
                <div class="card card-body">
                    <div class="row g-3 g-md-5">

                        {{-- Left column: Profile picture --}}
                        <div class="col-md-auto d-flex justify-content-center">
                            @if (auth()->user()->profile_picture_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture_path) }}" alt=""
                                class="w-100 ratio ratio-1x1 rounded object-fit-cover" style="max-width: 150px;">
                            @else
                            <div class="bg-muted-lt rounded d-flex align-items-center justify-content-center"
                                style="height: 150px; min-width: 150px;">
                                <span class="fs-1">{{
                                    auth()->user()->first_name[0]
                                    }}{{
                                    auth()->user()->last_name[0]
                                    }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Right column: Brief info --}}
                        <div class="col">

                            {{-- Display name and role --}}
                            <div>
                                <h1 class="m-0 fs-2">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                </h1>
                                <p class="text-muted m-0">{{ auth()->user()->title ?? auth()->user()->activeRoleName()
                                    }}</p>
                            </div>

                            <hr class="hr mt-2 mb-3">

                            <div class="row gx-3 gy-1 mb-1">

                                {{-- Email address --}}
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    {{-- Mail icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                    <span>{{ auth()->user()->email }}</span>
                                </div>

                                {{-- Phone number --}}
                                @if (auth()->user()->phone)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    {{-- Phone icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                    </svg>
                                    <span>{{ auth()->user()->phone }}</span>
                                </div>
                                @endif

                                {{-- Linkedin --}}
                                @if (auth()->user()->linkedin_url)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 11v5" />
                                        <path d="M8 8v.01" />
                                        <path d="M12 16v-5" />
                                        <path d="M16 16v-3a2 2 0 1 0 -4 0" />
                                        <path
                                            d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10" />
                                    </svg>
                                    <a href="{{ auth()->user()->linkedin_url }}" target="_blank">Linkedin</a>
                                </div>
                                @endif

                                {{-- Facebook --}}
                                @if (auth()->user()->facebook_url)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                                    </svg>
                                    <a href="{{ auth()->user()->facebook_url }}" target="_blank">Facebook</a>
                                </div>
                                @endif

                                {{-- Instagram --}}
                                @if (auth()->user()->instagram_url)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4l0 -8" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        <path d="M16.5 7.5v.01" />
                                    </svg>
                                    <a href="{{ auth()->user()->instagram_url }}" target="_blank">Instagram</a>
                                </div>
                                @endif

                                {{-- X --}}
                                @if (auth()->user()->x_url)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4l11.733 16h4.267l-11.733 -16l-4.267 0" />
                                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                    </svg>
                                    <a href="{{ auth()->user()->x_url }}" target="_blank">X</a>
                                </div>
                                @endif

                            </div>

                            <div class="row gx-3 gy-1">

                                {{-- Country --}}
                                @if (auth()->user()->country)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <span class="flag flag-xxs flag-country-{{ auth()->user()->country }}"></span>
                                    <span>{{ __('countries.'.auth()->user()->country) }}</span>
                                </div>
                                @endif

                                {{-- City --}}
                                @if (auth()->user()->city)
                                <div class="col-md-auto d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        <path
                                            d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
                                    </svg>
                                    <span>{{ auth()->user()->city }}</span>
                                </div>
                                @endif

                                @if (auth()->user()->address)
                                <div class="col-12 d-flex align-items-center gap-1 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2" />
                                        <path d="M10 16h6" />
                                        <path d="M11 11a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M4 8h3" />
                                        <path d="M4 12h3" />
                                        <path d="M4 16h3" />
                                    </svg>
                                    <span>{{ auth()->user()->address }}</span>
                                </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-body mb-3">
                    <h3 class="card-title">Bio</h3>
                    <div class="text-muted">{{ auth()->user()->bio ?? 'No bio' }}</div>
                </div>
                <div class="card">
                    <div class="card-body">

                        {{-- Field: Companies --}}
                        <div class="mb-3">
                            <div class="form-label">Company</div>
                            @forelse(auth()->user()->companies as $company)
                            <span class="d-inline-block mb-1">{{ $company->name }}</span>
                            @empty
                            <span class="text-muted">No companies</span>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>

            {{-- Latest activities timeline --}}
            <div class="col-lg-8">
                <ul class="timeline">
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-twitter-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l18 0" />
                                <path d="M9 8l1 0" />
                                <path d="M9 12l1 0" />
                                <path d="M9 16l1 0" />
                                <path d="M14 8l1 0" />
                                <path d="M14 12l1 0" />
                                <path d="M14 16l1 0" />
                                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <span class="float-end text-muted small">4h</span>
                                <div class="text-muted">Created <b>Boston Dynamics</b> company.</div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <span class="float-end text-muted small">5h</span>
                                <div class="text-muted">Created user <b>James Hetfield</b> with <i>Sales Manager</i>
                                    title and <i>User</i> role for <b>Metro Software</b>.
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-device-ipad-check">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v8" />
                                <path d="M9 18h2" />
                                <path d="M15 19l2 2l4 -4" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <span class="float-end text-muted small">8h</span>
                                <div class="text-muted">Resolved the support request <b>#92897284</b>.
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-twitter-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l18 0" />
                                <path d="M9 8l1 0" />
                                <path d="M9 12l1 0" />
                                <path d="M9 16l1 0" />
                                <path d="M14 8l1 0" />
                                <path d="M14 12l1 0" />
                                <path d="M14 16l1 0" />
                                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <span class="float-end text-muted small">1d</span>
                                <div class="text-muted">Modified <b>Metro Software</b> company.</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('body_scripts')
@vite(['resources/css/tabler/tabler-flags.min.css'])
@endsection