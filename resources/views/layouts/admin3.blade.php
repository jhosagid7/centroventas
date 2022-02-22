<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Administracion | {{ config('app.name', 'VillaSoft') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" media="print" href="{{asset('bower_components/bootstrap/dist/css/bootstrap_imprimir.css')}}">
  <!-- bootstrap-select.min -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap-select.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('bower_components/select2/dist/css/select2.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTable -->
  <link rel="stylesheet" href="{{asset('Datatables/datatables.min.css')}}">
  {{-- <link rel="stylesheet" href="{{asset('Datatables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css')}}"> --}}
  {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
  {{-- <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{asset('DataTables-1.10.21/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('Buttons-1.6.2/css/buttons.dataTables.min.css')}}"> --}}




  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('bower_components/jvectormap/jquery-jvectormap.css')}}">


<link rel="stylesheet" href="{{asset('css/submit.css')}}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
  /* .dataTables_filter {
     display: none;
} */
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ config('app.name', 'VillaSoft') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          {{-- <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li> --}}
          <!-- Notifications: style can be found in dropdown.less -->
          {{-- <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li> --}}
          <!-- Tasks: style can be found in dropdown.less -->
          {{-- <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li> --}}
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">
                  @isset(Auth::user()->name)
                  {{ Auth::user()->name }}
                  @else
                  {!! 'Invitado' !!}
                  @endisset
                </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                <p>
                    @isset(Auth::user()->name)
                    {{ Auth::user()->name }} - {{ Auth::user()->role }} - {{ Auth::user()->id }}
                    @else
                        {!! 'Invitado' !!}
                    @endisset

                  <small>Miembro since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="{{asset('cajas/caja')}}">Caja</a>
                  </div>
                  @can('haveaccess', 'ventas.create')
                  <div class="col-xs-4 text-center">
                    <a href="{{asset('ventas/venta/create')}}">Ventas</a>
                  </div>
                  @endcan
                  <div class="col-xs-4 text-center">
                    <a href="{{asset('ventas/tasa')}}">Margenes</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     {{ __('Salir') }}
                 </a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </div>
              </li>
            </ul>
          </li>

          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            @isset(Auth::user()->name)
            {{ Auth::user()->name }}
            @else
            {!! 'Invitado' !!}
            @endisset
        </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENÚ DE NAVEGATIÓN</li>
        {{-- <li class="treeview">
          <a href="#">
          <i class="fa fa-hotel"></i> <span>Hotel</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
          <ul class="treeview-menu">
              @can('haveaccess', 'proveedor.index')
              <li><a href="{{asset('compras/proveedor')}}"><i class="fa fa-truck"></i> Proveedor</a></li>
              @endcan
              @can('haveaccess', 'ingreso.index')
              <li><a href="{{asset('compras/ingreso')}}"><i class="fa fa-sign-in"></i> Ingreso</a></li>
              @endcan
          </ul>

      </li> --}}
      @can('haveaccess', 'boton.almacen')
      <li class="treeview">
        <a href="#"><i class="fa fa-database"></i> Almacen
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            @can('haveaccess', 'categoria.index')
            <li><a href="{{asset('almacen/categoria')}}"><i class="fa fa-cube"></i> Categorías</a></li>
            @endcan
            @can('haveaccess', 'articulo.index')
            <li><a href="{{asset('almacen/articulo')}}"><i class="fa fa-cubes"></i> Artículos</a></li>
            @endcan
            @can('haveaccess', 'menu.transactions')
            <li class="treeview">
                <a href="#"><i class="fa fa-exchange"></i> Transacciones
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @can('haveaccess', 'transferencia.index')
                    <li><a href="{{asset('almacen/transferencia')}}"><i class="fa fa-cubes"></i> Transferencias</a></li>
                    @endcan
                    @can('haveaccess', 'cargos.index')
                    <li><a href="{{asset('cargos')}}"><i class="fa fa-truck"></i> Cargos</a></li>
                    @endcan
                    @can('haveaccess', 'descargos.index')
                    <li><a href="{{asset('descargos')}}"><i class="fa fa-sign-in"></i> Descargos</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
        </ul>
      </li>

        @endcan
        @can('haveaccess', 'boton.compras')
        <li class="treeview">
          <a href="#">
          <i class="fa fa-cart-arrow-down"></i> <span>Compras</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
          <ul class="treeview-menu">
              @can('haveaccess', 'proveedore.index')
              <li><a href="{{asset('compras/proveedor')}}"><i class="fa fa-truck"></i> Proveedor</a></li>
              @endcan
              @can('haveaccess', 'ingreso.index')
              <li><a href="{{asset('compras/ingreso')}}"><i class="fa fa-sign-in"></i> Ingreso</a></li>
              @endcan
              @can('haveaccess', 'ingreso.index')
              <li><a href="{{asset('compras/credito')}}"><i class="fa fa-sign-in"></i> Creditos</a></li>
              @endcan
          </ul>

      </li>
      @endcan
        @can('haveaccess', 'boton.venta')
        <li class="treeview">
            <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu">
                @can('haveaccess', 'cliente.index')
                <li><a href="{{asset('ventas/cliente')}}"><i class="fa fa-user-plus"></i> Clientes</a></li>
                @endcan
                @can('haveaccess', 'venta.index')
                <li><a href="{{asset('ventas/venta')}}"><i class="fa fa-desktop"></i> Venta</a></li>
                @endcan
                @can('haveaccess', 'ingreso.index')
              <li><a href="{{asset('ventas/creditos')}}"><i class="fa fa-sign-in"></i> Creditos</a></li>
              @endcan
                @can('haveaccess', 'tasa.index')
                <li><a href="{{asset('ventas/tasa')}}"><i class="fa fa-desktop"></i> Tasa</a></li>
                @endcan
            </ul>
        </li>
        @endcan


        @can('haveaccess', 'boton.reportes')
        <li class="treeview">
            <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu">
                @can('haveaccess', 'reporte.index')
                <li><a href="{{asset('reportes/ventas')}}"><i class="fa fa-user-plus"></i> Articulos Vendidos</a></li>
                @endcan

                <li><a href="{{asset('inventario')}}"><i class="fa fa-desktop"></i> Planilla Inventario</a></li>

                <li><a href="{{asset('precios')}}"><i class="fa fa-desktop"></i> Lista de Precios</a></li>

                @can('haveaccess', 'reporte.index')
                <li><a href="{{asset('reporte-general')}}"><i class="fa fa-desktop"></i> Reporte General</a></li>
                <li><a href="{{asset('reporte-ingreso')}}"><i class="fa fa-desktop"></i> Reporte General Compras</a></li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('haveaccess', 'boton.sistema')
        <li class="treeview">
            <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Sistema</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu">
                @can('haveaccess', 'role.index')
                <li><a href="{{route('role.index')}}"><i class="fa fa-user-plus"></i> Role</a></li>
                @endcan
                @can('haveaccess', 'user.index')
                <li><a href="{{route('user.index')}}"><i class="fa fa-desktop"></i> User</a></li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('haveaccess', 'boton.compras')
        <li class="treeview">
          <a href="#">
          <i class="fa fa-cart-arrow-down"></i> <span>Pagos servicios</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
          <ul class="treeview-menu">
              @can('haveaccess', 'proveedore.index')
              <li><a href="{{asset('pagos/categoria')}}"><i class="fa fa-truck"></i> Categoria</a></li>
              @endcan
              @can('haveaccess', 'ingreso.index')
              <li><a href="{{asset('pagos/tipo')}}"><i class="fa fa-sign-in"></i> Pagos</a></li>
              @endcan
          </ul>

      </li>
      @endcan
        @can('haveaccess', 'boton.sistema')
        <li class="treeview">
            <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Bancos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu">
                @can('haveaccess', 'role.index')
                <li><a href="{{asset('bancos/banco')}}"><i class="fa fa-user-plus"></i> Banco</a></li>
                @endcan
                {{-- @can('haveaccess', 'user.index')
                <li><a href="{{route('user.index')}}"><i class="fa fa-desktop"></i> User</a></li>
                @endcan --}}
            </ul>
        </li>
        </ul>
        @endcan
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

          @yield('contenido')


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer no-print">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0 Beta
    </div>
    <strong>Copyright &copy; 2020 <a href="https://jhosagid7@gmail.com">ING. Jhonny Pirela</a>.</strong> All rights
    reserved.<br>
    <strong>Telefono: <a href="https://jhosagid7@gmail.com">0424-7665227 - 0414-7497092</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- bootstrap-select.min -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap-select.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('Datatables/datatables.min.js')}}"></script>
{{-- <!-- Bootstrap 3.3.7 -->
<script src="{{asset('Datatables/Buttons-1.6.2/js/buttons.bootstrap.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('Datatables/JSZip-2.5.0/jszip.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('Datatables/pdfmake-0.1.36/pdfmake.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('Datatables/Buttons-1.6.2/js/buttons.html5.min.js')}}"></script> --}}
{{-- <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}



{{-- <script type="text/javascript" src="{{asset('JSZip-2.5.0/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('pdfmake-0.1.36/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('pdfmake-0.1.36/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables-1.10.21/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Buttons-1.6.2/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Buttons-1.6.2/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Buttons-1.6.2/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Buttons-1.6.2/js/buttons.print.min.js')}}"></script> --}}
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('js/submit.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
{{-- <script src="{{asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('bower_components/chart.js/Chart.js')}}"></script>
<script src="{{asset('dist/js/pages/dashboard2.js')}}"></script> --}}

{{-- Funtion Main --}}
@stack('sciptsMain')
<script>
    $(document).ready(function() {

        $('form').keypress(function(e){
        if(e == 13){
            return false;
        }
        });

        $('input').keypress(function(e){
        if(e.which == 13){
            return false;
        }
        });





        // Funcion JavaScript para la conversion a mayusculas
        $(function() {
                    $('.mayuscula').on('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                });

        $(function() {
            $('.titulo').on('input', function() {
                this.value = this.value.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1){
                    return $1.toUpperCase();
                });
            });
        });






        $('.titulo').css('textTransform', 'capitalize');
        function imprimir() {
            window.print();
        }
        // jQuery(document).ready(function() {
        // jQuery('#arti').DataTable({
        // rowReorder: {
        // selector: 'td:nth-child(2)'
        // },
        // responsive: true,
        // "language": {
        // "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        // },
        // "paging": true,
        // "processing": true,

        // dom: 'lBfrtip',
        // buttons: [
        // 'excel', 'pdf', 'print',
        // ],
        // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        // } );
        // } );

        var fi = $('#fechaInicio').val();
        var ff = $('#fechaFin').val();
        if (fi == '' || fi == null && ff == '' || ff == null) {

                fi = moment().subtract('days', 29);
                ff = moment();
                $('#fecha2').val(fi.format('YYYY/MM/DD') + ' - ' + ff.format('YYYY/MM/DD'))
                $('#fechaInicio').val(fi.format('DD/MM/YYYY'));
                $('#fechaFin').val(ff.format('DD/MM/YYYY'));
            }

        $(function () {
        //Initialize Select2 Elements
        //   $('.select2').select2()

        //   //Datemask dd/mm/yyyy
        //   $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //   //Datemask2 mm/dd/yyyy
        //   $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //   //Money Euro
        //   $('[data-mask]').inputmask()

        //Date range picker
        //   $('#reservation').daterangepicker()
        //   //Date range picker with time picker
        //   $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
        //Date range as a button





            $('#daterange-btn').daterangepicker(
                {
                    startDate: fi,
                    endDate: ff,
                    locale: {
                    applyLabel: "Aplicar",
                    cancelLabel: "Cancelar",
                    customRangeLabel: 'Rango Personalizado',
                    format: 'DD/MM/YYYY',
                    daysOfWeek: [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    monthNames: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Setiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]},
                    ranges   : {
                        'Hoy'       : [moment(), moment()],
                        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Ultimos 7 Días' : [moment().subtract(6, 'days'), moment()],
                        'Ultimos 30 Días': [moment().subtract(29, 'days'), moment()],
                        'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
                        'Mes Pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    // startDate: moment().subtract(29, 'days'),
                    // endDate  : moment()
                    // startDate = start;
                    // endDate = end;
                },
                function(start, end) {
                console.log("Callback has been called!");
                $('#daterange-btn span').html(start.format('DD MM YYYY') + ' - ' + end.format('DD MM YYYY'));
                $('#fechaInicio').val(start.format('DD MM YYYY'));
                $('#fechaFin').val(end.format('DD MM YYYY'));
                startDate = start;
                endDate = end;
                $('#fecha2').val(startDate.format('YYYY/MM/DD') + ' - ' + endDate.format('YYYY/MM/DD'))

            }
                // function (start, end) {
                //     $('#daterange-btn span').html(start.format('DD MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'))
                // }
            )


            //Date picker
            //   $('#datepicker').datepicker({
            //     autoclose: true
            //   })

            //   //iCheck for checkbox and radio inputs
            //   $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            //     checkboxClass: 'icheckbox_minimal-blue',
            //     radioClass   : 'iradio_minimal-blue'
            //   })
            //   //Red color scheme for iCheck
            //   $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            //     checkboxClass: 'icheckbox_minimal-red',
            //     radioClass   : 'iradio_minimal-red'
            //   })
            //   //Flat red color scheme for iCheck
            //   $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            //     checkboxClass: 'icheckbox_flat-green',
            //     radioClass   : 'iradio_flat-green'
            //   })

            //Colorpicker
            //   $('.my-colorpicker1').colorpicker()
            //   //color picker with addon
            //   $('.my-colorpicker2').colorpicker()

            //Timepicker
            //   $('.timepicker').timepicker({
            //     showInputs: false
            //   })
            })
    });
</script>
</body>
</html>
