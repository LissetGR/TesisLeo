@php
$datos = ['Productos', 'Plan', 'Real', 'Estadisticas'];
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
    </div>
</x-app-layout>
