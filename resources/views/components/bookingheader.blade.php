@if(! empty($slot->toHtml()))
    <div>
        {{ $slot }}
    </div>
    <div class="sm:mt-16"></div>
@endif
<div class="hidden sm:block px-5">
    <x-bookingprogress step="{{ $step }}"/>
</div>
@isset($title)
    <h1 class="mt-6 sm:mt-16 heading1 text-gold-500">{{ $title }}</h1>
@endif
