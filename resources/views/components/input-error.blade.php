@props(['messages'])
<small {{ $attributes->merge(['class' => 'text-danger mt-1']) }}>
    @foreach ($messages as $message)
        <p class="m-0">{{ $message }}</p>
    @endforeach
</small>