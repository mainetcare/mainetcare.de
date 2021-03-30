@inject('modify', 'Statamic\Modifiers\Modify')
@include('partials._header_image')

@if(is_object($teaser) && count($teaser->value()) > 0)
    <div class="pt-8 sm:pt-20 bg-gold-100 sm:pb-24 pb-8">

        <x-container-narrow>
            <h1 class="heading1 text-gold-600">{!! $modify($title)->widont(2) !!}</h1>
            <div class="mt-4">
                @include('partials._teaser')
            </div>
        </x-container-narrow>

    </div>
@else
    <div class="pt-8 sm:pt-20 bg-white">
        <x-container-narrow>
            <h1 class="heading1 text-gold-600">{!! $modify($title)->widont(2) !!}</h1>
        </x-container-narrow>
    </div>
@endif

@if(is_object($content) && count($content->value()) > 0)
    <x-container-narrow class="my-16 sm:my-24">
        @include('partials._content')
    </x-container-narrow>
@endif
