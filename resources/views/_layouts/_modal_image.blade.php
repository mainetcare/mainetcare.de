<div x-data="{ imgModal : false, imgModalSrc : '', imgModalDesc : '' }">
    <template @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;"
              x-if="imgModal"
    >
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             x-on:click.away="imgModal = ''"
             @keydown.window.escape="imgModal = ''"
             class="p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
            <div @click.away="imgModal = ''"
                 @keydown.window.escape="imgModal = ''"
                 class="flex flex-col max-h-full overflow-auto"
            >
                <div class="z-50">
                    <button @click="imgModal = ''" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                        <svg class="h-5 w-5 stroke-current text-gold-100" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="">
                            <path d="M2 2L20.5 20.5M20.5 2L2 20.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="p-2">
                    <img :alt="imgModalSrc" class="object-contain h-screen-3/4" :src="imgModalSrc">
                    <p x-text="imgModalDesc" class="text-center text-white"></p>
                </div>
            </div>
        </div>
    </template>
</div>
