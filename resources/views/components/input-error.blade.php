@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <span {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>{{ $message }}</span>
    @endforeach
@endif
