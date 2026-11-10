{{-- Accordion --}}
@props(['items' => [], 'name' => null, 'level' => 3])

@php
	$items = collect($items)->filter(fn ($item) => filled($item['title'] ?? null));
	$tag = 'h'.min(6, max(2, (int) $level));
@endphp

@if ($items->isNotEmpty())
	<div {{ $attributes }}>
		@foreach ($items as $item)
			<details class="group border-b border-border" @if ($name) name="{{ $name }}" @endif>
				<summary class="flex min-h-touch cursor-pointer list-none items-center justify-between gap-4 py-4">
					<{{ $tag }} class="text-lg">{{ $item['title'] }}</{{ $tag }}>
					<span class="size-2 shrink-0 rotate-45 border-r-2 border-b-2 border-current group-open:-rotate-135" aria-hidden="true"></span>
				</summary>
				@if (filled($item['content'] ?? null))
					<div class="pb-4">{!! $item['content'] !!}</div>
				@endif
			</details>
		@endforeach
	</div>
@endif
