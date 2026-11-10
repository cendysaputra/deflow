{{-- Button --}}
@props(['link' => null, 'variant' => null])

@if (filled($link['url'] ?? null) && filled($link['label'] ?? null))
	<a {{ $attributes->class(['btn', 'btn-outline' => $variant === 'outline']) }} href="{{ $link['url'] }}" @if ($link['new_tab'] ?? false) target="_blank" rel="noopener" @endif>{{ $link['label'] }}</a>
@endif
