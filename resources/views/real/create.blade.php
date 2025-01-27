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
                {{ __('Crear plan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">Introduzca los datos del real
                </h1>
                <div class="flex justify-center ml-3 mt-6">
                    <form action="{{ route('real.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="mr-10" for="mes">Mes</label>
                            <select class="select select-primary w-full max-w-xs" name="mes" id="mes">
                                <option required selected>Seleccione el mes correspondiente</option>
                                @foreach ($meses as $mes)
                                    <option value="{{Str::lower($mes)}}">{{ $mes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-6 mr-10">
                            <label for="anno">Año</label>
                            <select class="select select-primary w-full max-w-xs" name="anno" id="anno">
                                <option  required selected>{{$anno}}</option>
                                @for ($i = $anno; $i > $anno - 20; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <div class="mt-6">
                                <label for="productos_id">Productos</label>
                                <select class="select select-primary w-full max-w-xs" name="productos_id" id="productos_id" >
                                    <option required selected >Seleccione el producto correspondiente</option>
                                    @foreach ($productos as $producto)
                                        <option  value="{{$producto->id}}">{{$producto->nombre}}</option>
                                    @endforeach
                                </select>
                                <x-icono-agregar></x-icono-agregar>
                            </div>
                            <div class="mt-6">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" required placeholder="Escribe aquí"
                                    class="input input-bordered input-primary w-full max-w-xs" />
                            </div>
                            <div class="mt-6">
                                <label class="mr-6" for="precio">Precio</label>
                                <input type="decimal" name="precio" id="precio" required placeholder="Escribe aquí"
                                    class="input input-bordered input-primary w-full max-w-xs" />
                            </div>
                        </div>
                        <div class="flex justify-center mt-10">
                            <button type="submit" class="btn btn-primary mr-6">Aceptar</button>
                            <a href="{{ route('real.index') }}" class="btn btn-glass">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
