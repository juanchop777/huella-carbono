<!DOCTYPE html>
<html lang="en">
@include('seq::layouts.partials.head')

@section('stylesheet')
@show

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
  <!-- Navbar -->
    @include('seq::layouts.partials.navbar')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
    @include('seq::layouts.partials.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('seq::layouts.partials.breadcrumb')
    <!-- /.content-header -->
    <!-- Main content -->
    @section('content')
    @show
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
    @include('seq::layouts.partials.footer')
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('seq::layouts.partials.scripts')

@section('script')
@show

</body>
</html>
