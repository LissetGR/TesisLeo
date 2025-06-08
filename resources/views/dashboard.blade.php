@php
$datos = ['Productos', 'Real', 'Plan', 'Estadisticas'];
$colors = ['border-blue-500', 'border-green-500', 'border-yellow-500', 'border-purple-500'];
@endphp

<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Gestion Integral</h1>
        </div>

        <!-- Cards with Images -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            @foreach ($datos as $index => $data)
            <a href="{{ Str::lcfirst($data) }}" class="group transform transition duration-300 hover:-translate-y-2">
                <div class="h-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-xl border-t-4 {{ $colors[$index] }}">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('https://media.istockphoto.com/id/1409236261/es/foto/alimentaci%C3%B3n-saludable-antecedentes-de-alimentaci%C3%B3n-saludable-frutas-verduras-bayas.jpg?s=612x612&w=0&k=20&c=HV0f9edLCsmHyms0uBy1yQwJzdWkVGLYzyKeA65qEDE=') }}"
                             alt="{{ $data }}"
                             class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-90"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $data }}</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-600 dark:text-blue-400 text-sm font-medium">Acceder</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Visual Data Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 p-6 mb-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Tendencias Clave</h3>
                    <p class="text-gray-600 dark:text-gray-400">Últimos 30 días</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <button class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium">Mensual</button>
                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-medium">Anual</button>
                </div>
            </div>

            <!-- Graphic Visualization -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Circular Progress -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Crecimiento</h4>
                        <span class="text-green-500 text-sm font-medium">+12%</span>
                    </div>
                    <div class="relative w-full h-40 flex items-center justify-center">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle cx="50%" cy="50%" r="40" stroke="#e5e7eb" stroke-width="8" fill="none" class="dark:stroke-gray-600"/>
                            <circle cx="50%" cy="50%" r="40" stroke="#10b981" stroke-width="8" fill="none" stroke-dasharray="251" stroke-dashoffset="100" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute text-center">
                            <span class="text-3xl font-bold text-gray-800 dark:text-white">68%</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Meta alcanzada</p>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Rendimiento general del sistema</p>
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-xl">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-4">Actividad Reciente</h4>
                    <div class="h-40 flex items-end space-x-2">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 rounded-t-sm h-24" style="height: 70%"></div>
                            <span class="text-xs text-gray-500 mt-1">Lun</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 rounded-t-sm h-32" style="height: 90%"></div>
                            <span class="text-xs text-gray-500 mt-1">Mar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 rounded-t-sm h-20" style="height: 60%"></div>
                            <span class="text-xs text-gray-500 mt-1">Mié</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 rounded-t-sm h-28" style="height: 80%"></div>
                            <span class="text-xs text-gray-500 mt-1">Jue</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-500 rounded-t-sm h-16" style="height: 50%"></div>
                            <span class="text-xs text-gray-500 mt-1">Vie</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-400 rounded-t-sm h-12" style="height: 40%"></div>
                            <span class="text-xs text-gray-500 mt-1">Sáb</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-blue-300 rounded-t-sm h-8" style="height: 30%"></div>
                            <span class="text-xs text-gray-500 mt-1">Dom</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Interacciones diarias</p>
                    </div>
                </div>

                <!-- Radial Progress -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-xl">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-4">Eficiencia</h4>
                    <div class="flex items-center justify-center space-x-6">
                        <div class="relative w-32 h-32">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8" class="dark:stroke-gray-600"/>
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#3b82f6" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="70" stroke-linecap="round"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center flex-col">
                                <span class="text-2xl font-bold text-gray-800 dark:text-white">75%</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Optimizado</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-300">Operacional</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-300">Estable</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-amber-500 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-300">En mejora</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Estado del sistema</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
