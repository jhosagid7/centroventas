@extends('layouts.admin3')

@section('contenido')



    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
          <h3 class="box-title">@isset($title)
              {{$title}}
              @else
              {!!"Sistema"!!}
          @endisset</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
        {{-- cabecera de box --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{ route('user.update', $user->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container">
                        <h3>{{__('Require Data')}}</h3>

                    <div class="form-group">
                        <label for="name">{{__('Name')}}</label>
                    <input disabled name="name" type="text" class="form-control" id="name" value="{{ old('name', $user->name)}}" placeholder="{{__('Name')}}...">
                    </div>

                    <div class="form-group">
                        <label for="email">{{__('email')}}</label>
                        <input disabled name="email" type="text" class="form-control" id="email" value="{{ old('email', $user->email)}}" placeholder="{{__('email')}}...">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="roles">Roles</label>
                        </div>
                        <select disabled name="roles" class="custom-select" id="roles">
                          {{-- <option selected>Choose...</option> --}}
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    @isset($user->roles[0]->name)
                                        @if ($role->name == $user->roles[0]->name)
                                        selected
                                        @endif
                                    @endisset>{{ $role->name }}</option>
                            @endforeach
                        </select>
                      </div>



                      <hr>
                    </div>
                    <a class="btn btn-success" href="{{route('user.edit',$user->id)}}">{{__('Edit')}}</a>
                    <a class="btn btn-danger" href="{{route('user.index')}}">{{__('Back')}}</a>
                    </form>

                    {{-- {!! dd(old())!!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- fin de la cabecera de box --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
  {{-- Footer --}}
</div>
<!-- /.box-footer-->
</div>
<!-- /.box -->
@endsection
