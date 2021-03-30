@extends(app('request')->input('modal') == "1" ? '_layouts.modal' : 'layout')
@section('content')


    <div class="my-32 container">


        <div class="flex items-stretch justify-between bg-white border border-gray-100 rounded">

            <div class="bg-blue-200 flex-1 grid grid-cols-3">
                <div class="border-r border-gray-200 flex items-center justify-center">
                    <div class="py-4 px-2">Hallo</div>
                </div>
                <div class="border-r border-gray-200 flex items-center justify-center">
                    <div class="py-4 px-2">Hallo asdfk</div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="py-4 px-2">Hallo jkdsfks fkjhfk asdfk</div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-red-300">
                <div class="px-2 py-4">
                    <button class="btn btn-flat">Irgendein Text</button>
                </div>
            </div>

        </div>

    </div>



    <div class="h-full flex flex-col items-center justify-center">
        <x-dropdown.modal
            class="label underline"
            label="open me"
        >
            <p>Hello I'm Open</p>
        </x-dropdown.modal>
    </div>

@endsection
