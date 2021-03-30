@extends(app('request')->input('modal') == "1" ? '_layouts.modal' : 'layout')
@section('content')
    @include('_layouts._default_content')
@endsection
