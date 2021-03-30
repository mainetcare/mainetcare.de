@inject('modify', 'Statamic\Modifiers\Modify')
@include('partials._header_image')

<div class="pt-8 sm:pt-20 bg-white">

    <x-container-narrow>
        <h1 class="heading1 text-gold-600">{!! $modify($title)->widont(2) !!}</h1>
        @if(is_object($teaser) && count($teaser->value()) > 0)
            <div class="mt-4">
                @include('partials._teaser')
            </div>
        @endif
    </x-container-narrow>

</div>

@if(is_object($content) && count($content->value()) > 0)
    <x-container-narrow class="my-8">
        @include('partials._content')
    </x-container-narrow>
@endif
