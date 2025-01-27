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
    $bandera = false;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
                {{ __('Plan') }}
            </h2>
            <div>
                <a href="plan/create" class="btn btn-m btn-primary">+</a>
                <x-search></x-search>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2">
                    <div >
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
                                @foreach ($plan as $p)
                                    <tr class="text-center">
                                        <th>
                                            <label>
                                                <input type="checkbox" class="checkbox"  id="checkbox-{{ $p->id }}"/>
                                            </label>
                                        </th>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle h-12 w-12">
                                                        <img src="{{ asset('storage/' . $p->photo) }}"
                                                            alt="Imagen del producto">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $p->nombre }}</div>
                                                    <div class="text-sm opacity-50">{{ $p->u_medida }}</div>
                                                </div>
                                            </div>
                                            <td>
                                               cantidad
                                                <br />
                                                <span class="badge badge-ghost badge-sm">$
                                                   dinero</span>
                                            </td>
                                        </td>
                                        @foreach ($meses as $mes)
                                        @php
                                            $planDelMes = $p->plans->firstWhere('mes', Str::lower($mes));
                                        @endphp
                                        <td>
                                            @if ($planDelMes)
                                                <div class="indicator animate-emphasize transition-all duration-300 opacity-0 checkbox-toggle:checked:opacity-100">
                                                    <button
                                                    x-data="{{ $planDelMes }}"
                                                    title="Eliminar plan" class="indicator-item badge btn-circle bg-red-600 hover:bg-red-700 p-0 w-4 h-4 text-white text-[8px] leading-none " x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                    <a href="{{route('plan.edit', $planDelMes)}}" title="Editar plan"  class="indicator-item indicator-bottom indicator-start badge badge-primary btn-circle  p-0 w-4 h-4 text-[8px] leading-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-4-4L19 4l-4-4m0 0L4 19"></path>
                                                        </svg>
                                                    </a>
                                                    <div class="m-1">
                                                        {{ $planDelMes->cantidad }}
                                                        <br />
                                                        <span class="badge badge-ghost badge-sm">$ {{ $planDelMes->precio }}</span>
                                                    </div>

                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
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
{{-- <x-confirm-deletation :elemento="'plan'" :data="$planDelMes"></x-confirm-deletation> --}}
