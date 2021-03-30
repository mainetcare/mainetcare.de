<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    @include('_layouts._favicons')
    @stack('styles')
{{--    @include('_layouts.brainsum_cookie_consent')--}}
    @include('_layouts.matomo')
</head>
<body class="bg-blue-900 font-sans text-base leading-normal text-gray-900">
<noscript>
    <style type="text/css">
        .pagecontainer {
            display: none;
        }
    </style>
    <div class="flex justify-center my-5">
        <div class="w-1/2 border-2 border-gray-500 rounded text-gray-900 p-2 bg-gray-100">
            Sie haben Javascript für MaiNetCare deaktiviert. Die Website steht daher nur eingeschränkt zur Verfügung.
        </div>
    </div>
</noscript>
<div id="app">

    @hasSection('header')
        @yield('header')
    @else
        @include('_layouts.header.header')
    @endif

    <div id="main" class="h-screen-5/6 flex flex-col">
        <div class="flex-1 {{ $bgbody ?? 'bg-white' }}">
            @isset($template_content)
                {!! $template_content !!}
            @else
                @yield('content')
            @endisset
            @yield('after_content')
        </div>
        <div>
            @include('_layouts.footer.footer')
        </div>
    </div>
    @include('_layouts.toast')
    @include('_layouts.overlay')
    @include('_layouts.pageerrors')
    @include('_layouts._modal_image')
</div>

@livewireScripts
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
