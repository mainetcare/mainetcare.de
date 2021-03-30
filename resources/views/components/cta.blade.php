@if(isset($pos) && $pos == 'right')
   Right
@else
    <div class="sm:flex sm:items-center sm:justify-center">
        <h3 class="leading-tight sm:hidden text-blue-500 lg:text-4xl text-2xl font-medium">{!! $title !!}</h3>
        {!! $image !!}
    </div>
    <div class="md:self-center">
        <h3 class="hidden sm:block leading-tight text-blue-500 lg:text-4xl text-2xl font-medium">{!! $title !!}</h3>
        <div class="mt-4 lg:leading-relaxed lg:text-xlg">{{ $slot }}</div>
        <a href="{{ $url }}" class="mt-8 md:mt-10 inline-block btn btn-out text-xs sm:text-sm">{{ $label ?? 'Mehr erfahren' }}</a>
    </div>
@endif
