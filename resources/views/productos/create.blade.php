<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
                {{ __('Crear productos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">Introduzca los datos del
                    producto</h1>
                <div class="flex justify-center h-full w-full ml-3 mt-6">
                    <form action="{{ isset($producto) ? route('productos.update', $producto->id) : route('productos.store') }}"  method="POST" enctype="multipart/form-data">
                        @if( isset($producto))
                            @method('PUT')
                        @endif
                        @csrf
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" required placeholder="Escribe aquí"
                                class="input input-bordered input-primary w-full max-w-xs"
                                value="{{ old('nombre', $producto->nombre ?? '') }}"
                                />
                        </div>
                        <div class="mt-6">
                            <label for="u_medida">Unidad de medida</label>
                            <input type="text" name="u_medida" id="u_medida" required placeholder="Escribe aquí"
                                class="input input-bordered input-primary w-full max-w-xs"
                                value="{{ old('u_medida', $producto->u_medida ?? '') }}"
                                />
                        </div>
                        <div class="mt-6">
                            <input type="file" name="photo" id="photo"
                                class="file-input file-input-bordered file-input-primary w-full max-w-xs" />

                        </div>

                        <div class="flex justify-end mt-10">
                            <button type="submit" class="btn btn-primary mr-6">Aceptar</button>
                            <a href="{{ route('productos.index') }}" class="btn btn-glass">Cancelar</a>
                        </div>
                    </form>
                    @if(isset($producto->photo))
                    <div class="mt-4 ml-8">
                        <p class="text-sm text-gray-500">Imagen actual:</p>
                        <img src="{{ Storage::url($producto->photo) }}" alt="Imagen actual" class="h-36 w-36 object-cover rounded mt-6">
                    </div>
                     @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>


