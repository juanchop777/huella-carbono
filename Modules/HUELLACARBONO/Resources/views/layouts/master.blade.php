<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
@include('huellacarbono::layouts.partials.head')

@section('stylesheet')
@show

<body class="bg-gray-50 antialiased">
  <div class="min-h-screen">
    <!-- Navbar -->
    @include('huellacarbono::layouts.partials.navbar')
    
    <!-- Main Content -->
    <main class="pt-20">
      @section('content')
      @show
    </main>
    
    <!-- Footer -->
    @include('huellacarbono::layouts.partials.footer')
  </div>
  
  <!-- Scripts -->
  @include('huellacarbono::layouts.partials.scripts')
  
  @section('script')
  @show
</body>
</html>

