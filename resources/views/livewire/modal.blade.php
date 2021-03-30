<x-dropdown.modal xdata="{...dropdown(), ...modalwire()}"
                  class="label underline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                  label="{{ $label }}"
                  innerstyle="{{ $innerstyle }}"
>
    @if($url)
        <iframe src="{{ $url }}?modal=1" width="100%" style="@if($agent->isMobile()) height:90vh @else height:600px; @endif"></iframe>
    @endif

</x-dropdown.modal>

@once
    @push('scripts')
        <script>
            window.modalwire = function () {
                return {
                    open() {
                        this.showpicker = true
                        this.$wire.load();
                    },
                }
            }
        </script>
    @endpush
@endonce

