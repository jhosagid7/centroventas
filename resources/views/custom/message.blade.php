@if (session('status_success'))
<div class="alert alert-success" role="alert">
    {{ session('status_success') }}
</div>
@endif
@if (session('status_danger'))
<div class="alert alert-danger" role="alert">
    {{ session('status_danger') }}
</div>
@endif

@if (session('status_warning'))
<div class="alert alert-warning" role="alert">
    {{ session('status_warning') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
    <li>{{__($error)}}</li>
        @endforeach
    </ul>
</div>
@endif
