@php
    $meses=['Enero','Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre']
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estadisticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-10xl mx-auto  sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                          <tr>
                            <th></th>
                            <th>Importe</th>
                            <th>Plan</th>
                            <th>Real</th>
                            <th>%</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- row 1 -->
                          @foreach ($meses as $mes )
                          <tr>
                            <td>{{$mes}}</td>
                            <td>Cy Ganderton</td>
                            <td>Cy Ganderton</td>
                            <td>Quality Control Specialist</td>
                            <td>
                                <div class="radial-progress" style="--value:70;--size:3rem" role="progressbar">70%</div>
                            </td>
                          </tr>
                          @endforeach
                          <!-- row 2 -->
                        </tbody>
                      </table>
                  </div>
            </div>
        </div>
    </div>
  </div>
</div>
</x-app-layout>
