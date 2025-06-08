@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estadisticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Botón de exportar Excel -->
                    <div class="mb-3 flex justify-end">
                        <button onclick="exportToExcel()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar Excel
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="exportTable" class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Importe</th>
                                    <th>Plan</th>
                                    <th>Real</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meses as $mes)
                                <tr>
                                    <td>{{ $mes }}</td>
                                    <td>Cy Ganderton</td>
                                    <td>Cy Ganderton</td>
                                    <td>Quality Control Specialist</td>
                                    <td>
                                        <div class="radial-progress" style="--value:70;--size:3rem" role="progressbar">70%</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            // Seleccionar la tabla
            const table = document.getElementById('exportTable');

            // Convertir la tabla a una hoja de trabajo
            const wb = XLSX.utils.table_to_book(table);

            // Exportar a un archivo XLSX
            XLSX.writeFile(wb, 'estadisticas.xlsx');
        }
    </script>
    @endpush
</x-app-layout>
