{{-- Tabs --}}
@props(['items' => [], 'label' => null])

@php
	$items = collect($items)->filter(fn ($item) => filled($item['label'] ?? null))->values();
	$id = $attributes->get('id') ?? 'tabs-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
@endphp

@if ($items->isNotEmpty())
	<div {{ $attributes->except('id') }} data-tabs>
		<div class="flex gap-2 overflow-x-auto border-b border-border" role="tablist" @if ($label) aria-label="{{ $label }}" @endif hidden>
			@foreach ($items as $i => $item)
				<button class="min-h-touch shrink-0 cursor-pointer border-b-2 border-transparent px-4 py-2 aria-selected:border-primary aria-selected:text-primary" type="button" role="tab" id="{{ $id }}-tab-{{ $i }}" aria-controls="{{ $id }}-panel-{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">{{ $item['label'] }}</button>
			@endforeach
		</div>
		@foreach ($items as $i => $item)
			<div class="pt-6" role="tabpanel" id="{{ $id }}-panel-{{ $i }}" aria-labelledby="{{ $id }}-tab-{{ $i }}" tabindex="0">{!! $item['content'] ?? '' !!}</div>
		@endforeach
	</div>
@endif
