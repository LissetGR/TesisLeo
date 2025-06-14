@php
    $meses = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between align-middle">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Real') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
                    Introduzca los datos del Real
                </h1>

                <div class="flex justify-center ml-3 mt-6">
                    <form id="real-form" action="{{ route('real.store') }}" method="POST">
                        @csrf

                        {{-- Selección de Mes y Año --}}
                        <div class="flex gap-10">
                            <div>
                                <label for="mes">Mes</label>
                                <select class="select select-primary w-full max-w-xs" name="mes" id="mes" required>                          
                                    <option value="{{ strtolower($mes) }}">{{ $mes }}</option>                        
                                </select>
                            </div>

                            <div>
                                <label for="anno">Año</label>
                                <select class="select select-primary w-full max-w-xs" name="anno" id="anno" required>                                
                                    <option value="{{ $anno }}">{{ $anno }}</option>                               
                                </select>
                            </div>
                        </div>

                        {{-- Sección de Productos Dinámicos --}}
                        <div class="mt-6">
                            <h2 class="font-semibold text-lg">Productos</h2>
                            <div id="productos-container">
                                <div class="producto-item flex gap-4 mt-4">
                                    <input type="text" class="input input-bordered input-primary w-full max-w-xs bg-gray-100" 
                                        value="{{ $producto->nombre }}" disabled>
                                    <input type="hidden" name="productos_id[]" value="{{ $producto->id }}">
                                    <input type="number" name="cantidad[]" placeholder="Cantidad" required
                                        class="input input-bordered input-primary w-28" />

                                    <input type="number" name="precio[]" placeholder="Precio" required
                                        step="0.01" inputmode="decimal" lang="es" class="input input-bordered input-primary w-28" />

                                </div>
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

    {{-- Script para manejar los productos dinámicos --}}
    <script>

        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-product')) {
                event.target.parentElement.remove();
            }
        });

        // Enviar el formulario con la estructura correcta
        document.getElementById('real-form').addEventListener('submit', function(event) {
            event.preventDefault();

            let form = event.target;
            let productos = [];

            let mes = document.getElementById('mes').value;
            let anno = document.getElementById('anno').value;

            document.querySelectorAll('.producto-item').forEach(item => {
                let productoId = item.querySelector('input[name="productos_id[]"]').value;
                let cantidad = item.querySelector('input[name="cantidad[]"]').value;
                let precio = item.querySelector('input[name="precio[]"]').value;

                if (productoId && cantidad && precio) {
                    productos.push({
                        productos_id: productoId,
                        cantidad: cantidad,
                        precio: precio,
                        mes: mes,
                        anno: anno
                    });
                }
            });

            if (productos.length === 0) {
                alert("Debes agregar al menos un producto.");
                return;
            }

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'productos';
            input.value = JSON.stringify(productos);
            form.appendChild(input);

            form.submit();
        });
    </script>

</x-app-layout>
