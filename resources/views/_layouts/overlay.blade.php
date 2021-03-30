<div
    x-data="overlay()"
    x-cloak=""
    x-show="open"
    x-on:overlay.window="toggle($event)"
    x-init="listen()"
    class="z-40 fixed inset-0 bg-gold-200 opacity-50 pointer-events-none"
>
</div>
