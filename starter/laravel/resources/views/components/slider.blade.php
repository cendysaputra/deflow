{{-- Slider --}}
@props(['label' => null, 'perView' => [3, 2, 1]])

<div {{ $attributes->class(['slider']) }} data-slider data-per-view="{{ implode(',', array_map('intval', (array) $perView)) }}">
	<div class="swiper" @if ($label) aria-label="{{ $label }}" @endif>
		<ul class="swiper-wrapper">
			{{ $slot }}
		</ul>
	</div>
	<div class="slider-controls mt-8 flex items-center gap-4">
		<button class="slider-arrow inline-flex size-touch shrink-0 cursor-pointer items-center justify-center rounded-full border border-border text-heading transition-colors hover:border-primary hover:text-primary" type="button" aria-label="{{ __('Slide sebelumnya') }}" data-slider-prev>
			<span class="size-2 -rotate-135 border-t-2 border-r-2 border-current" aria-hidden="true"></span>
		</button>
		<div class="slider-progress relative h-0.5 flex-1 overflow-hidden bg-border" data-slider-progress></div>
		<button class="slider-arrow inline-flex size-touch shrink-0 cursor-pointer items-center justify-center rounded-full border border-border text-heading transition-colors hover:border-primary hover:text-primary" type="button" aria-label="{{ __('Slide berikutnya') }}" data-slider-next>
			<span class="size-2 rotate-45 border-t-2 border-r-2 border-current" aria-hidden="true"></span>
		</button>
	</div>
</div>
