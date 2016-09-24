@if(Session::has('info'))
    <div class="alert alert-info" role="alert">
        {{ Session::get('info') }}
    </div>
@elseif(Session::has('alert'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('alert') }}
    </div>
@endif