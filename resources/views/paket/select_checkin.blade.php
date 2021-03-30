<div class="mt-8 flex justify-center">
    <form class="bg-white w-2/3" method="GET" action="{{ route('paket-select.index') }}">
        <div class="flex justify-between">
            <div class="">
                <div class="p-3 pl-6 justify-start cursor-pointer bg-gold-100 border-2 border-gray-300 sm:bg-white sm:border-0 mt-3 sm:mt-0">

                    <div class="flex justify-start items-center">
                        <x-svg url="assets/svg/calendar.svg" class="hidden lg:block h-10 w-10 text-gray-900"></x-svg>
                        <div class="lg:ml-3">
                            <h5 class="text-xs block font-semibold uppercase tracking-widest whitespace-no-wrap">Check-In</h5>
                            <input id="checkin" name="checkin" class="w-full focus:outline-none focus:border-gold-400 text-base"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="p-3 flex items-center justify-end mt-3 sm:mt-0">
                <button class="btn lg:px-16">Suchen</button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        let el = document.getElementById('checkin');
        if (el) {
            let picker = new Litepicker({
                element: document.getElementById('checkin'),
                minDate: new Date(),
                minDays:2,
                singleMode: true,
                lang: 'de-DE',
                format: 'DD.MM.YYYY',
                startDate : '{{ $checkin }}',
                mobileFriendly: true,
                numberOfMonths: 1,
                numberOfColumns: 1
            });
        }
    </script>
@endpush
