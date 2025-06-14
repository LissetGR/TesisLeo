@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between align-middle">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estadisticas') }}
        </h2>
        <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('estadisticas') }}" class="flex items-center gap-4">
            <!-- Año -->
            <div class="flex flex-col">
                <select name="anno" id="anno" onchange="this.form.submit()" class="input input-bordered w-32">
                    @php
                        $currentYear = date('Y');
                        $startYear = $currentYear - 5;
                    @endphp
                    @for ($y = $currentYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}" @if(isset($anno) && $anno == $y) selected @endif>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <noscript>
                <button type="submit" class="btn btn-primary mt-6">Filtrar</button>
            </noscript>
        </form>
            </div>
     </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Botón de exportar Excel -->
                    <div class="mb-3 flex justify-end">
                        <a href="{{ route('estadisticas.exportar') }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar Excel
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="exportTable" class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Mes</th>                   
                                    <th>Plan</th>
                                    <th>Real</th>
                                    <th>Top Producto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estadisticas as $dato)
                                <tr>
                                    <td>{{ $dato['mes'] }}</td>                              
                                    <td>{{ number_format($dato['importe_plan'], 2) }}</td>
                                    <td>{{ number_format($dato['importe_real'], 2) }}</td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.975a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.386 2.46a1 1 0 00-.364 1.118l1.286 3.975c.3.921-.755 1.688-1.538 1.118l-3.386-2.46a1 1 0 00-1.176 0l-3.386 2.46c-.783.57-1.838-.197-1.538-1.118l1.286-3.975a1 1 0 00-.364-1.118L2.045 9.402c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.975z" />
                                        </svg>
                                        {{ $dato['top_productos'][0]['nombre'] ?? 'N/A' }}</td>

                                    <td class="flex justify-center">
                                        @php
                                            $cumplimiento = $dato['cumplimiento'];
                                            if ($cumplimiento >= 80) {
                                                $color = 'text-green-600 bg-green-200';
                                            } elseif ($cumplimiento >= 50) {
                                                $color = 'text-yellow-600 bg-yellow-200';
                                            } else {
                                                $color = 'text-red-600 bg-red-200';
                                            }
                                        @endphp
                                        <div class="radial-progress {{ $color }}" style="--value:{{ $cumplimiento }}; --size:4rem; --thickness:5px" role="progressbar" aria-valuenow="{{ $cumplimiento }}" aria-valuemin="0" aria-valuemax="100">
                                            <span class="text-sm font-semibold">{{ $cumplimiento }}%</span>
                                        </div>
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
</x-app-layout>
