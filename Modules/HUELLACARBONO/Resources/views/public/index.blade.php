@extends('huellacarbono::layouts.master')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <!-- Imagen de fondo -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.pexels.com/photos/268533/pexels-photo-268533.jpeg?auto=compress&cs=tinysrgb&w=1600" 
             alt="Naturaleza verde hermosa" 
             class="w-full h-full object-cover"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-emerald-900/80"></div>
    </div>
    
    <!-- Contenido -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center text-white">
            <i class="fas fa-leaf text-8xl mb-6 animate-bounce drop-shadow-lg"></i>
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">
                Huella de Carbono
            </h1>
            <p class="text-xl md:text-2xl mb-2 font-light drop-shadow-md">
                Centro de Formación Agroindustrial "La Angostura"
            </p>
            <p class="text-lg opacity-90 drop-shadow-md">
                Medición y gestión de emisiones de gases de efecto invernadero
            </p>
        </div>
    </div>
</div>

<!-- ¿Qué es la Huella de Carbono? - Con Imagen -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Imagen -->
            <div class="relative h-64 lg:h-auto">
                <img src="https://images.pexels.com/photos/957024/forest-trees-perspective-bright-957024.jpeg?auto=compress&cs=tinysrgb&w=800" 
                     alt="Bosque verde - Naturaleza" 
                     class="w-full h-full object-cover"
                     loading="lazy"
                     onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>
            
            <!-- Contenido -->
            <div class="p-8 lg:p-12">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 w-16 h-16 rounded-2xl flex items-center justify-center mr-4">
                        <i class="fas fa-leaf text-3xl text-green-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">¿Qué es la Huella de Carbono?</h2>
                </div>
                
                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                    La <strong class="text-green-600">huella de carbono</strong> es un indicador ambiental que mide el total de 
                    <strong>gases de efecto invernadero (GEI)</strong> generados por nuestras actividades diarias.
                </p>
                
                <p class="text-gray-600 mb-6">
                    Se expresa en unidades equivalentes de <strong>dióxido de carbono (CO₂e)</strong> y nos ayuda a entender 
                    nuestro impacto en el planeta.
                </p>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-xl">
                        <i class="fas fa-industry text-3xl text-blue-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-900">Actividades</h4>
                        <p class="text-sm text-gray-600">Industriales y domésticas</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl">
                        <i class="fas fa-smog text-3xl text-green-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-900">Emisiones</h4>
                        <p class="text-sm text-gray-600">CO₂ y otros GEI</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ¿Cómo se Calcula? - Con Imagen -->
<div class="bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Contenido -->
                <div class="p-8 lg:p-12 order-2 lg:order-1">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-calculator text-3xl text-blue-600"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">¿Cómo se Calcula?</h2>
                    </div>
                    
                    <p class="text-lg text-gray-700 mb-6">
                        El cálculo de la huella de carbono utiliza una fórmula simple pero poderosa:
                    </p>
                    
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-2xl text-white mb-6">
                        <h3 class="text-2xl font-bold text-center mb-2">
                            Huella de Carbono = Actividad × Factor de Emisión
                        </h3>
                        <p class="text-center text-sm opacity-90">Fórmula básica de cálculo</p>
                    </div>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex items-start">
                            <div class="bg-purple-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-bolt text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Actividad</h4>
                                <p class="text-sm text-gray-600">Cantidad consumida (litros, kWh, galones, kg...)</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-orange-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-flask text-orange-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Factor de Emisión</h4>
                                <p class="text-sm text-gray-600">Coeficiente que convierte a kg de CO₂</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ejemplo Rápido -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <p class="font-semibold text-gray-900 mb-2">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Ejemplo:
                        </p>
                        <p class="text-sm text-gray-700">
                            <strong>100 kWh</strong> de electricidad × <strong>0.18</strong> (factor) = 
                            <strong class="text-green-600 text-lg">18 kg de CO₂</strong>
                        </p>
                    </div>
                </div>
                
                <!-- Imagen -->
                <div class="relative h-64 lg:h-auto order-1 lg:order-2">
                    <img src="https://images.pexels.com/photos/1072179/pexels-photo-1072179.jpeg?auto=compress&cs=tinysrgb&w=800" 
                         alt="Naturaleza verde exuberante" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ¿Por qué es Importante? - Con Imagen de Fondo -->
<div class="relative py-20 overflow-hidden">
    <!-- Imagen de fondo con overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.pexels.com/photos/1179229/pexels-photo-1179229.jpeg?auto=compress&cs=tinysrgb&w=1600" 
             alt="Bosque verde hermoso con rayos de sol" 
             class="w-full h-full object-cover"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-emerald-900/90"></div>
    </div>
    
    <!-- Contenido -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-4">
                <i class="fas fa-heart text-red-400 mr-3"></i>
                ¿Por qué es Importante Medirla?
            </h2>
            <p class="text-xl text-white/90">
                Medir nuestra huella nos permite tomar acción y proteger nuestro planeta
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center transform hover:scale-105 transition">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-temperature-high text-3xl text-red-600"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Cambio Climático</h4>
                <p class="text-sm text-gray-600">Reduce el calentamiento global</p>
            </div>
            
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center transform hover:scale-105 transition">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-water text-3xl text-blue-600"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Recursos</h4>
                <p class="text-sm text-gray-600">Conserva agua y energía</p>
            </div>
            
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center transform hover:scale-105 transition">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-3xl text-green-600"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Biodiversidad</h4>
                <p class="text-sm text-gray-600">Protege ecosistemas</p>
            </div>
            
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center transform hover:scale-105 transition">
                <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-3xl text-pink-600"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Salud</h4>
                <p class="text-sm text-gray-600">Mejora el aire que respiramos</p>
            </div>
        </div>
    </div>
</div>

<!-- Herramientas Interactivas -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">
            Herramientas Interactivas
        </h2>
        <p class="text-xl text-gray-600">
            Explora nuestras herramientas para medir y entender la huella de carbono
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Calculadora Personal -->
        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
            <div class="p-8 text-white">
                <div class="bg-white/20 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-calculator text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Calculadora Personal</h3>
                <p class="mb-6 opacity-90">
                    Calcula tu huella de carbono personal y descubre tu impacto ambiental.
                </p>
                <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-arrow-right mr-2"></i> Calcular Ahora
                </a>
            </div>
        </div>

        <!-- Estadísticas del Centro -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
            <div class="p-8 text-white">
                <div class="bg-white/20 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-chart-line text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Estadísticas</h3>
                <p class="mb-6 opacity-90">
                    Consulta las emisiones del centro de formación en tiempo real.
                </p>
                <a href="{{ route('cefa.huellacarbono.public_statistics') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-chart-bar mr-2"></i> Ver Estadísticas
                </a>
            </div>
        </div>
        
        <!-- Más Información -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
            <div class="p-8 text-white">
                <div class="bg-white/20 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-book-open text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Información Detallada</h3>
                <p class="mb-6 opacity-90">
                    Aprende más sobre factores de emisión y métodos de cálculo.
                </p>
                <a href="{{ route('cefa.huellacarbono.information') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-book mr-2"></i> Leer Más
                </a>
            </div>
        </div>
    </div>
</div>

@auth
<!-- Acceso para Usuarios Autenticados -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-8 text-white">
            <h3 class="text-3xl font-bold mb-8 text-center">
                <i class="fas fa-user-check mr-2"></i> Acceso para Usuarios Registrados
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if(checkRol('huellacarbono.superadmin'))
                <a href="{{ route('cefa.huellacarbono.superadmin.dashboard') }}" 
                   class="bg-white hover:bg-gray-50 text-gray-900 rounded-2xl p-6 text-center transform hover:scale-105 transition-all shadow-lg">
                    <i class="fas fa-user-shield text-5xl text-red-600 mb-4"></i>
                    <h4 class="text-xl font-bold">Panel SuperAdmin</h4>
                    <p class="text-sm text-gray-600 mt-2">Gestión completa del sistema</p>
                </a>
                @endif
                
                @if(checkRol('huellacarbono.admin'))
                <a href="{{ route('cefa.huellacarbono.admin.dashboard') }}" 
                   class="bg-white hover:bg-gray-50 text-gray-900 rounded-2xl p-6 text-center transform hover:scale-105 transition-all shadow-lg">
                    <i class="fas fa-user-tie text-5xl text-blue-600 mb-4"></i>
                    <h4 class="text-xl font-bold">Panel Admin</h4>
                    <p class="text-sm text-gray-600 mt-2">Visualización y reportes</p>
                </a>
                @endif
                
                @if(checkRol('huellacarbono.leader'))
                <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" 
                   class="bg-white hover:bg-gray-50 text-gray-900 rounded-2xl p-6 text-center transform hover:scale-105 transition-all shadow-lg">
                    <i class="fas fa-user-cog text-5xl text-green-600 mb-4"></i>
                    <h4 class="text-xl font-bold">Panel Líder</h4>
                    <p class="text-sm text-gray-600 mt-2">Registro de consumos</p>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endauth

<!-- Sección de Recomendaciones -->
<section class="py-20 bg-gradient-to-b from-white to-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <i class="fas fa-lightbulb text-6xl text-yellow-500 mb-4"></i>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                 ¿Cómo Reducir tu Huella de Carbono?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Pequeñas acciones diarias pueden generar un gran impacto. Aquí te damos consejos prácticos y didácticos.
            </p>
        </div>

        <!-- Grid de Recomendaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Energía -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bolt text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Ahorra Energía</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Apaga las luces al salir de una habitación</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Desconecta aparatos que no uses</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Usa bombillas LED de bajo consumo</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Aprovecha la luz natural durante el día</span>
                    </li>
                </ul>
            </div>

            <!-- Agua -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tint text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Cuida el Agua</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Cierra el grifo mientras te cepillas</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Repara fugas inmediatamente</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Toma duchas cortas (5 minutos)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Reutiliza agua para regar plantas</span>
                    </li>
                </ul>
            </div>

            <!-- Transporte -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bicycle text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Movilízate Verde</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Usa bicicleta para trayectos cortos</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Comparte vehículo con compañeros</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Camina cuando sea posible</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Mantén tu vehículo en buen estado</span>
                    </li>
                </ul>
            </div>

            <!-- Residuos -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-recycle text-3xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Reduce Residuos</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Separa residuos correctamente</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Lleva tu recipiente reutilizable</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Evita productos de un solo uso</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Haz compostaje con orgánicos</span>
                    </li>
                </ul>
            </div>

            <!-- Consumo -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-bag text-3xl text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Consume Responsable</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Compra productos locales</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Reduce consumo de carne</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Evita desperdiciar alimentos</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Reutiliza y repara antes de comprar</span>
                    </li>
                </ul>
            </div>

            <!-- Naturaleza -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-seedling text-3xl text-green-700"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center"> Planta y Cuida</h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Planta árboles nativos</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Cuida los espacios verdes</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Crea un huerto en el CEFA</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1 flex-shrink-0"></i>
                        <span>Participa en reforestación</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Dato Impactante -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl shadow-2xl p-10 text-white text-center">
            <div class="flex items-center justify-center mb-6">
                <i class="fas fa-exclamation-circle text-6xl opacity-80"></i>
            </div>
            <h3 class="text-3xl font-bold mb-4">¿Sabías que...?</h3>
            <p class="text-xl mb-4 leading-relaxed">
                Si cada persona del CEFA reduce su huella en solo <strong>1 kg CO₂ por día</strong>,
            </p>
            <p class="text-2xl font-bold mb-6">
                 Equivaldría a plantar <strong>~17 árboles al año</strong> 
            </p>
            <p class="text-lg opacity-90">
                ¡Pequeñas acciones, grandes resultados! Juntos podemos hacer la diferencia.
            </p>
        </div>
    </div>
</section>
@endsection
