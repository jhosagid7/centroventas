@extends ('layouts.admin3')
@section('contenido')
<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-yellow"></i> {{__('Oops!')}} {{__('Page not found.')}}</h3>

      <p>
        {{__('We could not find the page you were looking for. Meanwhile, you may')}} <a href="#">{{__('return to dashboard.!')}}</a>
      </p>


    </div>
    <!-- /.error-content -->
  </div>
  @endsection
