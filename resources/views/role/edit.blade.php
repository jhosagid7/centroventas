@extends('layouts.admin3')

@section('contenido')

<!-- Default box -->
<!-- Content Header (Page header) -->
    {{-- <section class="content-header">
      <h1>
        <!--Blank page-->
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section> --}}

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
                <div class="card-header">{{ __('Edit Role') }}</div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{ route('role.update', $role->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="container">
                    <h3>{{__('Require Data')}}</h3>

                    <div class="form-group">
                        <label for="name">{{__('Name')}}</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ old('name', $role->name)}}" placeholder="{{__('Name')}}...">
                    </div>

                    <div class="form-group">
                        <label for="slug">{{__('Slug')}}</label>
                        <input name="slug" type="text" class="form-control" id="slug" value="{{ old('slug', $role->slug)}}" placeholder="{{__('slug')}}...">
                    </div>

                    <div class="form-group">
                        <label for="description">{{__('Description')}}</label>
                        <textarea class="form-control" name="description" id="description" placeholder="{{__('Description')}}..." rows="3">{{ old('description', $role->description)}}</textarea>
                      </div>
                    </div>

                    <hr>
                    <h3>{{__('Full Access')}}</h3>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" value="yes"
                        @if ($role['full-access']=="yes")
                            checked
                        @elseif (old('full-access')=="yes")
                            checked
                        @endif>
                    <label class="custom-control-label" for="fullaccessyes">{{__('Yes')}}</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" value="no"
                        @if ($role['full-access']=="no")
                            checked
                        @elseif (old('full-access')=="no")
                            checked
                        @endif>
                        <label class="custom-control-label" for="fullaccessno">{{__('No')}}</label>
                      </div>

                    <hr>

                    <h3>{{__('Permission List')}}</h3>
                    @foreach ($permissions as $permission)

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                         class="custom-control-input"
                         id="permission_{{$permission->id}}"
                         value="{{$permission->id}}"
                         name="permission[]"
                         @if( is_array(old('permission')) && in_array("$permission->id", old('permission')))
                         checked
                         @elseif( is_array($permission_role) && in_array("$permission->id", $permission_role))
                         checked
                         @endif

                         >
                    <label class="custom-control-label"
                        for="permission_{{$permission->id}}">
                        {{$permission->id}}
                        -
                        {{__($permission->name)}}
                        <em>({{__($permission->description)}})</em>
                    </label>
                      </div>
                      @endforeach

                      <hr>

                      <input class="btn btn-primary" type="submit" value="{{__('Save')}}">
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
