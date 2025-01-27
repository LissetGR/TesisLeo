<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
                {{ __('Productos') }}
            </h2>
            <div>
                <a href="productos/create" class="btn btn-m btn-primary">+</a>
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
                                <tr>
                                    <th>
                                    </th>
                                    <th>Producto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                @foreach ($productos as $producto)
                                    <tr>
                                        <th>
                                            <label>
                                                <input type="checkbox" class="checkbox" />
                                            </label>
                                        </th>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle h-12 w-12">
                                                        <img src="{{ asset('storage/' . $producto->photo) }}"
                                                            alt="Imagen del producto">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $producto->nombre }}</div>
                                                    <div class="text-sm opacity-50">{{ $producto->u_medida }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <th>
                                            <a href="{{ route('productos.edit', $producto) }}"
                                                class="btn btn-neutral btn-xs">Editar</a>
                                            <button x-data="{{ $producto }}" class="btn btn-warning btn-xs"
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')">Eliminar</button>
                                        </th>
                                @endforeach
                                </tr>

                            </tbody>
                            <!-- foot -->
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Producto</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}

</x-app-layout>


<x-confirm-deletation :elemento="'productos'" :data="$producto"></x-confirm-deletation>
