<footer class="bg-gray-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Columna 1 -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <i class="fas fa-leaf text-3xl text-green-500"></i>
                    <h3 class="text-xl font-bold">Huella de Carbono</h3>
                </div>
                <p class="text-gray-400">
                    Sistema de medición y gestión de emisiones de gases de efecto invernadero del Centro de Formación Agroindustrial "La Angostura".
                </p>
            </div>
            
            <!-- Columna 2 -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('cefa.huellacarbono.index') }}" class="hover:text-green-500 transition"><i class="fas fa-home mr-2"></i>Inicio</a></li>
                    <li><a href="{{ route('cefa.huellacarbono.information') }}" class="hover:text-green-500 transition"><i class="fas fa-info-circle mr-2"></i>Información</a></li>
                    <li><a href="{{ route('cefa.huellacarbono.personal_calculator') }}" class="hover:text-green-500 transition"><i class="fas fa-calculator mr-2"></i>Calculadora</a></li>
                    <li><a href="{{ route('cefa.huellacarbono.public_statistics') }}" class="hover:text-green-500 transition"><i class="fas fa-chart-line mr-2"></i>Estadísticas</a></li>
                </ul>
            </div>
            
            <!-- Columna 3 -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="fas fa-map-marker-alt mr-2"></i>Centro Agroindustrial La Angostura</li>
                    <li><i class="fas fa-envelope mr-2"></i>info@cefa.edu.co</li>
                    <li><i class="fas fa-phone mr-2"></i>+57 123 456 7890</li>
                </ul>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fab fa-facebook text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fab fa-twitter text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fab fa-instagram text-2xl"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Centro de Formación Agroindustrial "La Angostura". Todos los derechos reservados.</p>
            <p class="mt-2 text-sm">Desarrollado por <span class="text-green-500">ADSO</span></p>
        </div>
    </div>
</footer>

