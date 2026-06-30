@props(['title' => 'Page Title', 'pretitle' => 'Page pre-title'])
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    {{ $title }}
                </h2>
                <div class="page-pretitle">
                    {{ $pretitle }}
                </div>
            </div>
            <!-- Page title actions -->
            @php
                $slotContent = trim($slot->toHtml());
                $hasSlotContent = !empty($slotContent);
            @endphp
            @if ($hasSlotContent)
            <div class="col-auto ms-auto d-print-none">
                {{ $slot }}
            </div>
            @endif
        </div>
    </div>
</div>
