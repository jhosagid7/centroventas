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
                <div class="card-header">{{ __('List of Roles') }}</div>

                <div class="card-body">
                @can('haveaccess', 'role.create')
                <a href="{{ route('role.create')}}" class="btn btn-primary float-right">
                    {{ __('Create') }}
                </a>
                <br>
                <br>
                @endcan
                @include('custom.message')
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th scope="col">Full-access</th>
                            <th colspan="3"></th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach ($roles as $role)
                            <tr>
                            <th scope="row">{{$role->id}}</th>
                            <td>{{$role->name}}</td>
                            <td>{{$role->slug}}</td>
                            <td>{{$role->description}}</td>
                            <td>{{$role['full-access']}}</td>
                            <td>
                                @can('haveaccess', 'role.show')
                                <a class="btn btn-info" href="{{ route('role.show', $role->id)}}">Show</a>
                                @endcan
                            </td>
                            <td>
                                @can('haveaccess', 'role.edit')
                                <a class="btn btn-success" href="{{ route('role.edit', $role->id)}}">Edit</a>
                                @endcan
                            </td>
                            <td>
                                @can('haveaccess', 'role.destroy')
                                <form action="{{ route('role.destroy', $role->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                                @endcan
                            </td>
                            </tr>
                            @endforeach




                        </tbody>
                      </table>

                      {{ $roles->links() }}
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
