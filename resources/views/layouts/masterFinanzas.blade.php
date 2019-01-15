<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Novasys 2.0</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
  <!-- BootstrapToggle -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-toggle.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins Modificada Novasys-->
  <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.css')}}">
  <!-- bootstrap-select 1.12.2 CSS -->
  <link rel="stylesheet" href="{{asset('bootstrap-select/css/bootstrap-select.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('datatables/css/datatable.min.css')}}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

{{-- Se requiere importar jQuery en HEAD para su funcionamiento --}}
  <!-- jQuery 3.2.1 -->
  <script src="{{asset('plugins/jQuery/jquery-3.2.1.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{asset('datatables/js/datatable.min.js')}}"></script>
  <!-- DataTables bootstrap-->
  <script src="{{asset('datatables/js/bootstrap-datatable.min.js')}}"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    @include('layouts.brandbar')

    <!-- Header Navbar -->
    @include('layouts.navbar')

  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar -->
    @include('layouts.sidebarfinanzas')

  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
	  @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  {{-- @include('layouts.controlsidebar') --}}

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- Bootstrap 3.3.6 -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Bootstrap-select 1.12.2 JS -->
<script src="{{asset('bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<!-- Bootstrap-select 1.12.2 Español JS-->
<script src="{{asset('bootstrap-select/js/i18n/defaults-es_ES.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}"></script>
<!-- BootstrapToggle -->
<script src="{{asset('bootstrap/js/bootstrap-toggle.min.js')}}"></script>
<!-- Axios -->
<script src="{{asset('axios/axios.min.js')}}"></script>

@yield('scripts')

</body>
</html>
