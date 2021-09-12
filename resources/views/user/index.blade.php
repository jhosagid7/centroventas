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
                <div class="card-header">{{ __('List of Users') }}</div>

                <div class="card-body">

                {{-- <a href="{{ route('user.create')}}" class="btn btn-primary float-right">
                    {{ __('Create') }}
                </a> --}}
                <br>
                <br>
                @include('custom.message')
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role(s)</th>
                            <th colspan="3"></th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                            <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @isset($user->roles[0]->name)
                                {{$user->roles[0]->name}}
                                @endisset
                            </td>
                            <td>{{$user['full-access']}}</td>
                            <td>
                                @can('view', [$user, ['user.show', 'userown.show']])
                                <a class="btn btn-info" href="{{ route('user.show', $user->id)}}">Show</a>
                                @endcan
                            </td>
                            <td>
                                @can('update', [$user, ['user.edit', 'userown.edit']])
                                <a class="btn btn-success" href="{{ route('user.edit', $user->id)}}">Edit</a>
                                @endcan
                            </td>
                            <td>
                                @can('haveaccess', 'user.destroy')
                                <form action="{{ route('user.destroy', $user->id)}}" method="POST">
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

                      {{ $users->links() }}
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
