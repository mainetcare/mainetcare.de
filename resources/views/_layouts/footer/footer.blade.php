<footer class="bg-gold-900 island-p lg:text-sm">
    <div class="container sm:grid lg:grid-cols-12 sm:grid-cols-3 gap-3 text-gold-500">
        <div class="col-start-1 col-end-4 flex">
            <div class="flex align-top items-start flex-col">
                <div class="flex-grow">
                    <img src="/assets/layout/logo.svg" alt="Logo MaiNetcare" style="width:200px;">
                </div>
                <div class="mt-2 lg:mt-0 flex text-sm">
                    &copy; {{ date('Y') }} MaiNetCare GmbH
                </div>
            </div>
        </div>
        <div class="mt-10 lg:mt-0 lg:col-start-5 lg:col-span-2">
            @include('_layouts.footer.nav_ueber_uns', ['handle' => 'footer_ueber_uns'])
        </div>
        <div class="mt-10 lg:mt-0 lg:col-span-2">
            @include('_layouts.footer.nav_infos')
        </div>
        <div class="mt-10 lg:mt-0 lg:col-span-2">
            @include('_layouts.footer.nav_rechtliches')
        </div>
        <div class="mt-10 lg:mt-0 lg:col-span-2">
            <p class="font-sans font-medium uppercase tracking-wider">Social Media</p>
            <nav class="mt-4">
                @if($insta = \Statamic\Globals\GlobalSet::findByHandle( 'company' )->inCurrentSite()->get( 'instagram' ))
                    <a class="spinsvg block flex items-center lg:mt-4 mt-2 hover:underline" href="{{ $insta }}">
                        <svg class="w-4 h-4 fill-current text-gold-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                            <path
                                d="M67.84,22.82a23.39,23.39,0,0,0-1.49-7.77A16.4,16.4,0,0,0,57,5.69,23.32,23.32,0,0,0,49.22,4.2C45.79,4,44.7,4,36,4s-9.78,0-13.19.19a23.39,23.39,0,0,0-7.77,1.49,15.53,15.53,0,0,0-5.67,3.7A15.64,15.64,0,0,0,5.69,15,23.38,23.38,0,0,0,4.2,22.8C4,26.23,4,27.32,4,36s0,9.77.19,13.19A23.32,23.32,0,0,0,5.68,57a15.7,15.7,0,0,0,3.7,5.68A15.83,15.83,0,0,0,15,66.32a23.44,23.44,0,0,0,7.77,1.49C26.22,68,27.31,68,36,68s9.78,0,13.19-.19A23.39,23.39,0,0,0,57,66.32,16.34,16.34,0,0,0,66.32,57a23.38,23.38,0,0,0,1.49-7.76C68,45.78,68,44.7,68,36S68,26.23,67.84,22.82ZM62.07,49A17.36,17.36,0,0,1,61,54.89,10.6,10.6,0,0,1,54.89,61,17.55,17.55,0,0,1,49,62.06c-3.37.15-4.38.19-12.92.19s-9.57,0-12.94-.19A17.48,17.48,0,0,1,17.16,61a9.69,9.69,0,0,1-3.68-2.39,9.85,9.85,0,0,1-2.39-3.67A17.67,17.67,0,0,1,10,49C9.84,45.58,9.8,44.57,9.8,36s0-9.56.19-12.93a17.48,17.48,0,0,1,1.1-5.93,9.71,9.71,0,0,1,2.4-3.68,10,10,0,0,1,3.68-2.39A17.55,17.55,0,0,1,23.11,10c3.37-.15,4.39-.19,12.93-.19S45.6,9.85,49,10a17.61,17.61,0,0,1,5.94,1.1,9.77,9.77,0,0,1,3.67,2.39A9.84,9.84,0,0,1,61,17.17a17.28,17.28,0,0,1,1.1,5.93c.15,3.38.19,4.39.19,12.93S62.22,45.57,62.07,49Z"/>
                            <path d="M36,19.57A16.44,16.44,0,1,0,52.46,36,16.44,16.44,0,0,0,36,19.57Zm0,27.1A10.67,10.67,0,1,1,46.68,36,10.66,10.66,0,0,1,36,46.67Z"/>
                            <path d="M57,18.92a3.84,3.84,0,1,1-3.84-3.84A3.83,3.83,0,0,1,57,18.92Z"/>
                        </svg>
                        <span class="ml-2">Instagram</span>
                    </a>
                @endif
                @if($facebook = \Statamic\Globals\GlobalSet::findByHandle( 'company' )->inCurrentSite()->get( 'facebook' ))
                    <a class="spinsvg block flex items-center lg:mt-4 mt-2 hover:underline mt-2 hover:underline" href="{{ $facebook }}">
                        <svg class="w-4 h-4 fill-current text-gold-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                            <path
                                d="M36,4a32.16,32.16,0,0,0-4.78,63.93V44.69H23.3V36.23h7.92V30.61c0-9.32,4.51-13.4,12.21-13.4a43.55,43.55,0,0,1,6.56.4V25H44.74c-3.27,0-4.41,3.12-4.41,6.63v4.62h9.58l-1.3,8.46H40.33V68A32.16,32.16,0,0,0,36,4Z"/>
                        </svg>
                        <span class="ml-2">Facebook</span>
                    </a>
                @endif
                @if($twitter = \Statamic\Globals\GlobalSet::findByHandle( 'company' )->inCurrentSite()->get( 'twitter' ))
                    <a class="spinsvg block flex items-center lg:mt-4 mt-2 hover:underline mt-2 hover:underline" href="{{ $twitter }}">
                        <svg class="w-4 h-4 fill-current text-gold-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                            <path
                                d="M39,14.5a12.27,12.27,0,0,0-3.86,9.07,10.12,10.12,0,0,0,.43,2.86A38.06,38.06,0,0,1,20.43,22.5a37.68,37.68,0,0,1-12-9.36,12,12,0,0,0-1.72,6.29,12.16,12.16,0,0,0,5.86,10.71,14,14,0,0,1-6-1.57v.14a12.07,12.07,0,0,0,3,8.08,12.81,12.81,0,0,0,7.57,4.35,14.43,14.43,0,0,1-3.57.43,23.47,23.47,0,0,1-2.43-.14,12.43,12.43,0,0,0,4.65,6.28,13.51,13.51,0,0,0,7.64,2.58A26.25,26.25,0,0,1,7.14,55.71c-1,0-2.09,0-3.14-.14a37.27,37.27,0,0,0,20.14,5.72,38.45,38.45,0,0,0,16-3.29,33,33,0,0,0,11.79-8.57,41.26,41.26,0,0,0,7-11.64A34.64,34.64,0,0,0,61.43,25V23.29A26.84,26.84,0,0,0,68,16.71a25.12,25.12,0,0,1-7.57,2,12.45,12.45,0,0,0,5.86-7,31.08,31.08,0,0,1-8.43,3.15,12.56,12.56,0,0,0-9.57-4.15A12.8,12.8,0,0,0,39,14.5Z"/>
                        </svg>
                        <span class="ml-2">Twitter</span>
                    </a>
                @endif
            </nav>
        </div>
    </div>
</footer>
