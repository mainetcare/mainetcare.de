<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Open+Sans:400,600,700&display=swap" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    @include('partials._favicons')
    @stack('styles')
    @include('_layouts.matomo')
</head>
<body class="{{ $bgbody ?? 'bg-white' }} font-serif leading-normal text-gray-900 text-base">
<noscript>
    <style type="text/css">
        .pagecontainer {
            display: none;
        }
    </style>
    <div class="flex justify-center my-5">
        <div class="w-1/2 border-2 border-error-color rounded text-error-color p-2 bg-red-100">
            Sie haben Javascript für Residenz Kubitzer Bodden deaktiviert.<br>
            Bitte beachten Sie, dass diese Website ohne JavaScript nur eingeschränkt funktioniert!
        </div>
    </div>
</noscript>
<div id="app">

    <div>
        @isset($template_content)
            {!! $template_content !!}
        @else
            @yield('content')
        @endisset

        @yield('after_content')
    </div>

    @include('_layouts.toast')
    @include('_layouts.overlay')
    @include('_layouts.pageerrors')
</div>

@livewireScripts
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
