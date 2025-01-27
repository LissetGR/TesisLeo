@php
    $meses = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
                {{ __('Real') }}
            </h2>
            <div>
                <a href="real/create" class="btn btn-m btn-primary">+</a>
                <x-search></x-search>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr class="text-center">
                                    <th>
                                    </th>
                                    <th>Producto</th>
                                    <th>Total</th>
                                    <th>Enero</th>
                                    <th>Febrero</th>
                                    <th>Marzo</th>
                                    <th>Abril</th>
                                    <th>Mayo</th>
                                    <th>Junio</th>
                                    <th>Julio</th>
                                    <th>Agosto</th>
                                    <th>Septiembre</th>
                                    <th>Octubre</th>
                                    <th>Noviembre</th>
                                    <th>Diciembre</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- row 1 -->
                                @foreach ($real as $rea)
                                    <tr class="text-center">
                                        <th>
                                            <label>
                                                <input type="checkbox" class="checkbox" />
                                            </label>
                                        </th>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle h-12 w-12">
                                                        <img src="{{ asset('storage/' . $rea->photo) }}"
                                                            alt="Imagen del producto">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $rea->nombre }}</div>
                                                    <div class="text-sm opacity-50">{{ $rea->u_medida }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                        @foreach ($meses as $mes)
                                            @php
                                                $planDelMes = $rea->plans->firstWhere('mes', Str::lower($mes));
                                            @endphp
                                            @if ($planDelMes && $planDelMes->reals)
                                                <td>
                                                    {{ $planDelMes->reals->cantidad }}
                                                    <br />
                                                    <span class="badge badge-ghost badge-sm">$
                                                        {{ $planDelMes->reals->precio }}</span>
                                                </td>
                                            @else
                                                <td>
                                                   -
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tr>

                            </tbody>
                            <!-- foot -->
                            <tfoot>
                                <tr class="text-center">
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Total</th>
                                    <th>Enero</th>
                                    <th>Febrero</th>
                                    <th>Marzo</th>
                                    <th>Abril</th>
                                    <th>Mayo</th>
                                    <th>Junio</th>
                                    <th>Julio</th>
                                    <th>Agosto</th>
                                    <th>Septiembre</th>
                                    <th>Octubre</th>
                                    <th>Noviembre</th>
                                    <th>Diciembre</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
