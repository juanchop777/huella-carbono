<nav class="bg-white shadow-lg fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo y Título (más compacto para dar espacio al centro) -->
            <div class="flex items-center shrink-0">
                <a href="{{ route('cefa.huellacarbono.index') }}" class="flex items-center gap-3">
                    <i class="fas fa-leaf text-3xl text-green-600"></i>
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold text-gray-900 leading-tight">Huella de Carbono</h1>
                        <p class="text-xs text-gray-500">Centro de Formación La Angostura</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <div class="hidden md:flex items-center gap-1 flex-1 justify-center">
                @auth
                    @if(checkRol('huellacarbono.superadmin'))
                        <!-- Enlaces para SuperAdmin (agrupados con más espacio) -->
                        <a href="{{ route('cefa.huellacarbono.superadmin.dashboard') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('cefa.huellacarbono.superadmin.units.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-industry mr-2"></i>Unidades
                        </a>
                        <a href="{{ route('cefa.huellacarbono.superadmin.factors.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-flask mr-2"></i>Factores
                        </a>
                        <a href="{{ route('cefa.huellacarbono.superadmin.users.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-users mr-2"></i>Usuarios
                        </a>
                        <span class="w-px h-6 bg-gray-200 mx-1" aria-hidden="true"></span>
                        <a href="{{ route('cefa.huellacarbono.superadmin.consumptions.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-clipboard-list mr-2"></i>Consumos
                        </a>
                        <a href="{{ route('cefa.huellacarbono.superadmin.requests.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-paper-plane mr-2"></i>Solicitudes
                        </a>
                    @elseif(checkRol('huellacarbono.leader'))
                        <!-- Enlaces para Líder (antes que Admin: si tiene ambos roles, ve panel Líder) -->
                        <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('cefa.huellacarbono.leader.register') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-plus-circle mr-2"></i>Registrar
                        </a>
                        <a href="{{ route('cefa.huellacarbono.leader.history') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-history mr-2"></i>Historial
                        </a>
                        <a href="{{ route('cefa.huellacarbono.leader.alerts_requests') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition relative inline-flex items-center">
                            <span class="relative">
                                <i class="fas fa-bell mr-2"></i>
                                @if(isset($showLeaderAlertsDot) && $showLeaderAlertsDot)
                                <span class="absolute -top-0.5 -right-1 flex h-2.5 w-2.5" title="{{ $leaderAlertsCount }} día(s) sin reporte">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                </span>
                                @endif
                            </span>Alertas
                        </a>
                        <a href="{{ route('cefa.huellacarbono.leader.statistics') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-chart-line mr-2"></i>Estadísticas
                        </a>
                    @elseif(checkRol('huellacarbono.admin'))
                        <!-- Enlaces para Admin -->
                        <a href="{{ route('cefa.huellacarbono.admin.dashboard') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('cefa.huellacarbono.admin.consumptions.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-clipboard-list mr-2"></i>Consumos
                        </a>
                        <a href="{{ route('cefa.huellacarbono.admin.reports.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-file-pdf mr-2"></i>Reportes
                        </a>
                        <a href="{{ route('cefa.huellacarbono.admin.charts.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-chart-bar mr-2"></i>Gráficas
                        </a>
                    @else
                        <!-- Enlaces públicos (usuario autenticado sin rol de HC) -->
                        <a href="{{ route('cefa.huellacarbono.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-home mr-2"></i>Inicio
                        </a>
                        <a href="{{ route('cefa.huellacarbono.information') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-info-circle mr-2"></i>Información
                        </a>
                        <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-calculator mr-2"></i>Calculadora
                        </a>
                        <a href="{{ route('cefa.huellacarbono.public_statistics') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-chart-line mr-2"></i>Estadísticas
                        </a>
                        <a href="{{ route('cefa.huellacarbono.developers') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                            <i class="fas fa-code mr-2"></i>Desarrolladores
                        </a>
                    @endif
                @else
                    <!-- Enlaces públicos (visitantes no autenticados) -->
                    <a href="{{ route('cefa.huellacarbono.index') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                    <a href="{{ route('cefa.huellacarbono.information') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-info-circle mr-2"></i>Información
                    </a>
                    <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-calculator mr-2"></i>Calculadora
                    </a>
                    <a href="{{ route('cefa.huellacarbono.public_statistics') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-chart-line mr-2"></i>Estadísticas
                    </a>
                    <a href="{{ route('cefa.huellacarbono.developers') }}" class="text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-code mr-2"></i>Desarrolladores
                    </a>
                @endauth

                @auth
                <span class="w-px h-6 bg-gray-200 ml-4 shrink-0" aria-hidden="true"></span>
                <div class="relative shrink-0 pl-4" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-green-600 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                        <i class="fas fa-user-circle text-xl text-gray-500"></i>
                        <span>{{ Auth::user()->nickname }}</span>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50">
                        @if(checkRol('huellacarbono.superadmin'))
                        <a href="{{ route('cefa.huellacarbono.superadmin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                            <i class="fas fa-user-shield mr-2"></i>Panel SuperAdmin
                        </a>
                        <a href="{{ route('cefa.huellacarbono.superadmin.requests.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                            <i class="fas fa-paper-plane mr-2"></i>Solicitudes de registro
                        </a>
                        @elseif(checkRol('huellacarbono.leader'))
                        <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                            <i class="fas fa-user-cog mr-2"></i>Panel Líder
                        </a>
                        @elseif(checkRol('huellacarbono.admin'))
                        <a href="{{ route('cefa.huellacarbono.admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                            <i class="fas fa-user-tie mr-2"></i>Panel Admin
                        </a>
                        @endif
                        <hr class="my-2">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="block px-4 py-2 text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                        </a>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition text-sm font-medium shrink-0">
                    <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-green-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-2">
            @auth
                @if(checkRol('huellacarbono.superadmin'))
                    <a href="{{ route('cefa.huellacarbono.superadmin.dashboard') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('cefa.huellacarbono.superadmin.units.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-industry mr-2"></i>Unidades
                    </a>
                    <a href="{{ route('cefa.huellacarbono.superadmin.factors.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-flask mr-2"></i>Factores
                    </a>
                    <a href="{{ route('cefa.huellacarbono.superadmin.users.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-users mr-2"></i>Usuarios
                    </a>
                    <a href="{{ route('cefa.huellacarbono.superadmin.consumptions.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-clipboard-list mr-2"></i>Consumos
                    </a>
                    <a href="{{ route('cefa.huellacarbono.superadmin.requests.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-paper-plane mr-2"></i>Solicitudes
                    </a>
                @elseif(checkRol('huellacarbono.leader'))
                    <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('cefa.huellacarbono.leader.register') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar
                    </a>
                    <a href="{{ route('cefa.huellacarbono.leader.history') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-history mr-2"></i>Historial
                    </a>
                    <a href="{{ route('cefa.huellacarbono.leader.alerts_requests') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100 relative">
                        <span class="relative inline-block">
                            <i class="fas fa-bell mr-2"></i>
                            @if(isset($showLeaderAlertsDot) && $showLeaderAlertsDot)
                            <span class="absolute -top-0.5 left-4 flex h-2.5 w-2.5" title="{{ $leaderAlertsCount }} día(s) sin reporte">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            </span>
                            @endif
                        </span>Alertas
                    </a>
                    <a href="{{ route('cefa.huellacarbono.leader.statistics') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-line mr-2"></i>Estadísticas
                    </a>
                @elseif(checkRol('huellacarbono.admin'))
                    <a href="{{ route('cefa.huellacarbono.admin.dashboard') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('cefa.huellacarbono.admin.consumptions.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-clipboard-list mr-2"></i>Consumos
                    </a>
                    <a href="{{ route('cefa.huellacarbono.admin.reports.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-file-pdf mr-2"></i>Reportes
                    </a>
                    <a href="{{ route('cefa.huellacarbono.admin.charts.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-bar mr-2"></i>Gráficas
                    </a>
                @else
                    <!-- Usuario autenticado sin rol HC -->
                    <a href="{{ route('cefa.huellacarbono.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                    <a href="{{ route('cefa.huellacarbono.information') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-info-circle mr-2"></i>Información
                    </a>
                    <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-calculator mr-2"></i>Calculadora
                    </a>
                    <a href="{{ route('cefa.huellacarbono.public_statistics') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-line mr-2"></i>Estadísticas
                    </a>
                @endif
            @else
                <!-- Visitantes no autenticados -->
                <a href="{{ route('cefa.huellacarbono.index') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-home mr-2"></i>Inicio
                </a>
                <a href="{{ route('cefa.huellacarbono.information') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-info-circle mr-2"></i>Información
                </a>
                <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-calculator mr-2"></i>Calculadora
                </a>
                <a href="{{ route('cefa.huellacarbono.public_statistics') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-chart-line mr-2"></i>Estadísticas
                </a>
                <a href="{{ route('cefa.huellacarbono.developers') }}" class="block text-gray-700 hover:text-green-600 px-3 py-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-code mr-2"></i>Desarrolladores
                </a>
            @endauth
        </div>
    </div>
</nav>

