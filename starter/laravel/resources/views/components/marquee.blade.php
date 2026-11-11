{{-- Marquee --}}
@props(['items' => [], 'label' => null, 'speed' => 5000])

@php
	$items = collect($items)->filter(fn ($item) => filled($item['src'] ?? null));
@endphp

@if ($items->isNotEmpty())
	<div {{ $attributes->class(['marquee', 'relative']) }} data-marquee data-speed="{{ (int) $speed }}">
		<button class="sr-only focus:not-sr-only focus:absolute focus:z-10 focus:bg-surface focus:px-4 focus:py-2" type="button" aria-pressed="false" data-marquee-toggle hidden>{{ __('Jeda animasi') }}</button>
		<div class="swiper" @if ($label) aria-label="{{ $label }}" @endif>
			<ul class="swiper-wrapper">
				@foreach ($items as $item)
					<li class="swiper-slide">
						@if (filled($item['link']['url'] ?? null))
							<a href="{{ $item['link']['url'] }}"><img class="h-logo w-auto object-contain" src="{{ $item['src'] }}" alt="{{ $item['alt'] ?? '' }}" width="{{ $item['width'] ?? '' }}" height="{{ $item['height'] ?? '' }}" loading="lazy"></a>
						@else
							<img class="h-logo w-auto object-contain" src="{{ $item['src'] }}" alt="{{ $item['alt'] ?? '' }}" width="{{ $item['width'] ?? '' }}" height="{{ $item['height'] ?? '' }}" loading="lazy">
						@endif
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
