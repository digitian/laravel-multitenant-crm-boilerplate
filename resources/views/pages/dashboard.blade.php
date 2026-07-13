@extends('layouts.authenticated.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page header -->
<x-page-header title="Dashboard" pretitle="Welcome back, mösyö">
    <div class="btn-list">
        <span class="d-none d-sm-inline">
            <a href="#" class="btn btn-dark">
                New view
            </a>
        </span>
        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-report">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Create new report
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report"
            aria-label="Create new report">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
        </a>
    </div>
</x-page-header>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        {{-- Section: General Stats Cards --}}
        <div class="row row-deck row-cards">

            {{-- Card: Customers --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Customers</div>
                        </div>
                        <div class="h1 mb-2">7</div>
                        <div>
                            <span class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21h9" />
                                    <path d="M9 8h1" />
                                    <path d="M9 12h1" />
                                    <path d="M9 16h1" />
                                    <path d="M14 8h1" />
                                    <path d="M14 12h1" />
                                    <path
                                        d="M5 21v-16c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h10c.53 0 1.039 .211 1.414 .586c.375 .375 .586 .884 .586 1.414v7" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                </svg>
                            </span>
                            <span class="fw-semibold">2</span>
                            <span class="text-muted">created this week</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Products --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Products</div>
                        </div>
                        <div class="d-flex align-items-baseline mb-2">
                            <div class="h1 mb-0 me-2">212</div>
                            <div class="me-auto">
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    8%
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 17l6 -6l4 4l8 -8" />
                                        <path d="M14 7l7 0l0 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                    <path d="M15 19l2 2l4 -4" />
                                </svg>
                            </span>
                            <span class="fw-semibold">5</span>
                            <span class="text-muted">created this week</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Active Orders --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Active Orders</div>
                        </div>
                        <div class="d-flex align-items-baseline mb-2">
                            <div class="h1 mb-0 me-2">8</div>
                            <div class="me-auto">
                                <span class="text-yellow d-inline-flex align-items-center lh-1">
                                    0%
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                            </span>
                            <span class="fw-semibold">4</span>
                            <span class="text-muted">created this week</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Completed Orders --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Completed Orders</div>
                        </div>
                        <div class="d-flex align-items-baseline mb-2">
                            <div class="h1 mb-0 me-2">8</div>
                            <div class="me-auto">
                                <span class="text-yellow d-inline-flex align-items-center lh-1">
                                    0%
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                            </span>
                            <span class="fw-semibold">4</span>
                            <span class="text-muted">created this week</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection