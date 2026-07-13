<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title', 'Admin Dashboard') - Emecisoft Multitenant CRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <div class="page">

      {{-- Navbar --}}
      @include('layouts.admin.navbar')

      <div class="page-wrapper">
        
        {{-- Content --}}
        @yield('content')

        {{-- Footer --}}
        @include('layouts.admin.footer')

      </div>
    </div>

    @yield('modals')

    @yield('body_scripts')

    {{-- Global: Reset Livewire forms when Bootstrap modals are closed --}}
    <script>
        document.addEventListener('hidden.bs.modal', function (event) {
            const modal = event.target;
            const livewireEl = modal.closest('[wire\\:id]') || modal.querySelector('[wire\\:id]');

            if (livewireEl) {
                const wireId = livewireEl.getAttribute('wire:id');
                const component = window.Livewire?.find(wireId);

                if (component) {
                    component.call('resetForm');
                }
            }
        });
    </script>

  </body>
</html>