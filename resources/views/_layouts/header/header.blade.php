@if($agent->isDesktop())
    <header id="header" class="hidden lg:block w-full bg-blue-500 top-0 z-30">
            @include('_layouts.header.desktop')
    </header>
@elseif($agent->isTablet())
    {{--  Header Tablet --}}
    <header id="header" class="bg-white hidden md:block xl:hidden container relative" x-data="{ show_canvas: false }">
        @include('_layouts.header.ipad')
    </header>
@else
    {{--  Header Mobile  --}}
    <header id="header" class="w-full top-0 z-30">
        <x-teaser-rabatt/>
        <div class="w-full flex bg-white container items-center"
             x-data="{ show_canvas: false }"
             :class="{ 'bg-gold-100' : show_canvas}"
        >


            @include('_layouts.header.mobile')

        </div>
    </header>
@endif
<div id="headerspacer"></div>



