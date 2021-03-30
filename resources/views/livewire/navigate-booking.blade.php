@if($is_mobile)
    <div class="w-full">
        <div class="grid grid-cols-2 w-full items-center">
            <a class="block text-center btn btn-out rounded-none @if(!$prev) btn-disabled @endif" href="{{ $prev ?? '#!'}}" >Zurück</a>
            <a class="block text-center btn rounded-none @if(!$next) btn-disabled @endif" href="{{ $next ?? '#!'}}" >Weiter</a>
        </div>
    </div>
@else
    <div>
        <div class="flex sm:block items-center justify-between mt-6 text-center">
            @if($next)
                <a href="{{ $next }}" class="block btn">Nächster Schritt</a>
            @endif
            @if($prev)
                <a href="{{ $prev }}" class="block mt-6 btn-out">Zurück</a>
            @endif
        </div>
    </div>
@endif
