@if(session($session_key))
    <div class="alert alert-{{ $state }} my-3">
        {{ session($session_key) }}
    </div>
@endif