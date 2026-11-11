{{-- Gallery --}}
@props(['images' => [], 'group' => null, 'columns' => 3])

@php
	$images = collect($images)->filter(fn ($image) => filled($image['src'] ?? null) && filled($image['full'] ?? null));
	$group ??= 'gallery-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
	$grid = [2 => 'grid-cols-2', 3 => 'grid-cols-3 max-tablet:grid-cols-2', 4 => 'grid-cols-4 max-tablet:grid-cols-2'][(int) $columns] ?? 'grid-cols-3 max-tablet:grid-cols-2';
@endphp

@if ($images->isNotEmpty())
	<ul {{ $attributes->class(['grid gap-6 max-mobile:grid-cols-1', $grid]) }}>
		@foreach ($images as $image)
			<li>
				<figure>
					<a class="block" href="{{ $image['full'] }}" data-lightbox data-gallery="{{ $group }}" @if (filled($image['caption'] ?? null)) data-description="{{ $image['caption'] }}" @endif>
						<img class="block h-auto w-full rounded-md" src="{{ $image['src'] }}" @if (filled($image['srcset'] ?? null)) srcset="{{ $image['srcset'] }}" sizes="(max-width: 544px) 100vw, (max-width: 921px) 50vw, {{ round(1200 / max(2, (int) $columns)) }}px" @endif alt="{{ $image['alt'] ?? '' }}" loading="lazy">
					</a>
					@if (filled($image['caption'] ?? null))
						<figcaption class="mt-2 text-sm">{{ $image['caption'] }}</figcaption>
					@endif
				</figure>
			</li>
		@endforeach
	</ul>
@endif
