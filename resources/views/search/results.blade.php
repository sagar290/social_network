@extends('templates.default')


@section('content')
    <h3>your search for "{{ Request::input('query') }}"</h3>
    
    @if(!$users->count())
        <p>NO RESULTS FOUND</p>
    @else
        <div class="col-lg-12">
        @foreach($users as $user)
            @include('user/partials/userblock')
        @endforeach
        </div>
    @endif
@stop