@php
$datos=['Productos', 'Real', 'Plan', 'Estadisticas']
@endphp

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="flex justify-around flex-wrap sm:mt-10  xl:mt-20">
        @foreach ($datos as $data )
        <a href="{{Str::lcfirst($data)}}">
            <div class="card bg-base-100 w-64 shadow-xl m-10">
                <figure>
                    <img src="{{ asset('build/assets/surco.jpg') }}" alt="Shoes" />
                </figure>
                <div class="card-body">
                <h2 class="card-title">{{$data}}</h2>
                <p></p>

                {{-- <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div> --}}
                </div>
                </div>
        </a>
        @endforeach
    </div>

    <div class="flex justify-center mt-10">
        <div class="stats shadow">
            <div class="stat place-items-center">
              <div class="stat-title">Downloads</div>
              <div class="stat-value">31K</div>
              <div class="stat-desc">From January 1st to February 1st</div>
            </div>

            <div class="stat place-items-center">
              <div class="stat-title">Users</div>
              <div class="stat-value text-secondary">4,200</div>
              <div class="stat-desc text-secondary">↗︎ 40 (2%)</div>
            </div>

            <div class="stat place-items-center">
              <div class="stat-title">New Registers</div>
              <div class="stat-value">1,200</div>
              <div class="stat-desc">↘︎ 90 (14%)</div>
            </div>
          </div>
    </div>
</x-app-layout>
