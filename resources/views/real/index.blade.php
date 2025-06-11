@php
    use Illuminate\Support\Str;
    $meses = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Real') }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="real/create" class="btn btn-m btn-primary">+</a>
                <form method="GET" action="{{ route('real.index') }}" class="flex items-center gap-4">
                    <!-- Año -->
                    <div class="flex flex-col">
                        <!-- <label for="year" class="font-semibold mb-1">Año:</label> -->
                        <select name="year" id="year" onchange="this.form.submit()" class="input input-bordered w-32">
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 5;
                            @endphp
                            @for ($y = $currentYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}" @if(isset($year) && $year == $y) selected @endif>{{ $y }}</option>
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

    <div class="py-15">
        <div class="mx-auto max-w-10xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-2">
                    <!-- Totales Resumen -->
                    <div class="p-4 mb-6 bg-gray-100 rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold mb-0">Totales Anuales</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p><strong>Cantidad Total:</strong> {{ $totalesAnuales->total_cantidad }}</p>
                            </div>
                            <div>
                                <p><strong>Precio Total:</strong> ${{ number_format($totalesAnuales->total_precio, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla Principal -->
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th>Producto</th>
                                <th></th>
                                @foreach ($meses as $mes)
                                    <th>{{ $mes }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($real as $r)
                                <tr class="text-center">
                                    <th>
                                        <label>
                                            <input type="checkbox" class="checkbox" id="checkbox-{{ $r->id }}"/>
                                        </label>
                                    </th>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="w-12 h-12 mask mask-squircle">
                                                      <img src="{{ $r->photo ? asset('storage/' . $r->photo) : asset('images/productos.jpg') }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('images/productos.jpg') }}';"
                                                        alt="Imagen del producto"
                                                        class="object-cover w-full h-full">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{ $r->nombre }}</div>
                                                <div class="text-sm opacity-50">{{ $r->u_medida }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                    @foreach ($meses as $mes)
                                        @php
                                            $realDelMes = $r->reals->firstWhere('mes', Str::lower($mes));
                                        @endphp
                                        <td>
                                            @if($realDelMes)
                                                <div class="indicator">
                                                    <!-- Formulario de Eliminar -->
                                                    <form action="{{ route('real.destroy', $realDelMes->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" title="Eliminar" class="indicator-item badge btn-circle bg-red-600 hover:bg-red-700 p-0 w-4 h-4 text-white text-[8px] leading-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <!-- Botón de Editar -->
                                                    <button class="indicator-item indicator-bottom indicator-start badge badge-primary btn-circle p-0 w-4 h-4 text-[8px] leading-none" onclick="openModal('editModal-{{ $realDelMes->id }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-4-4L19 4l-4-4m0 0L4 19"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Datos del Real -->
                                                    <div class="m-1">
                                                        {{ $realDelMes->cantidad }}
                                                        <br />
                                                        <span class="badge badge-ghost badge-sm">$ {{ $realDelMes->precio }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th></th>
                                <th>Producto</th>
                                <th></th>
                                @foreach ($meses as $mes)
                                    <th>{{ $mes }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales de Edición -->
    @foreach ($real as $r)
        @foreach ($meses as $mes)
            @php
                $realDelMes = $r->reals->firstWhere('mes', Str::lower($mes));
            @endphp
            @if($realDelMes)
                <div id="editModal-{{ $realDelMes->id }}" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
                    <div class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                        <div class="w-64 p-4 bg-white rounded-lg shadow-lg">
                            <h2 class="mb-3 text-xl font-semibold">Editar Real</h2>
                            <form action="{{ route('real.update', $realDelMes->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                                    <input type="number" id="cantidad" name="cantidad" value="{{ $realDelMes->cantidad }}"
                                           class="w-full input input-bordered" required />
                                </div>
                                <div class="mb-4">
                                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                                    <input type="text" id="precio" name="precio" value="{{ $realDelMes->precio }}"
                                           class="w-full input input-bordered" required />
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" class="btn btn-ghost" onclick="closeModal('editModal-{{ $realDelMes->id }}')">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach

    <script>
        function openModal(modalId) {
            document.querySelectorAll('[id^="editModal-"]').forEach(modal => {
                modal.classList.add('hidden');
            });
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
