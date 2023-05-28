<x-app-layout>

    {{-- diseño de dos tablas o graficas para controlar el inventario --}}
    <div class="grid grid-row">

        <div class="max-w-7xl w-full mx-auto my-2">
            <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border-l-4 border-purple-400">
                        <div class="flex items-center">
                            <div class="icon w-14 p-3.5 bg-purple-400 text-white rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-lg">{{ $ventasDinero }} Bs</div>
                                <div class="text-sm text-gray-400">Ventas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border-l-4 border-yellow-400">
                        <div class="flex items-center">
                            <div class="icon w-14 p-3.5 bg-yellow-400 text-white rounded-full mr-3">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-lg">{{ $ventasCantidad }}</div>
                                <div class="text-sm text-gray-400">Cantidad de ventas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border-l-4 border-blue-400">
                        <div class="flex items-center">
                            <div class="icon w-14 p-3.5 bg-blue-400 text-white rounded-full mr-3 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-lg">{{ $comprasDinero }} Bs</div>
                                <div class="text-sm text-gray-400">Compras</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/4">
                    <div class="widget w-full p-4 rounded-lg bg-white border-l-4 border-red-400">
                        <div class="flex items-center">
                            <div class="icon w-14 p-3.5 bg-red-400 text-white rounded-full mr-3">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-lg">{{ $comprasCantidad }}</div>
                                <div class="text-sm text-gray-400">Cantidad de compras</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-5 mt-4 gap-2">
            <div class="col-span-3 w-full h-auto col-row">
                <div>
                    <p class="text-xl text-center font-bold text-gray-700 dark:text-gray-200 mb-2">Ventas por mes</p>
                    <canvas id="acquisitions"></canvas>
                </div>
                <div class="mt-4">
                    <p class="text-xl text-center font-bold text-gray-700 dark:text-gray-200 mb-2">Pizzas mas vendidas
                    </p>
                    <canvas id="pizzas"></canvas>
                </div>
            </div>
            <div class="col-span-2">
                <p class="text-xl text-center font-bold text-gray-700 dark:text-gray-200 mb-2">Tabla de ingredientes</p>
                {{-- una tabla con los ingredientes que estan por vencer --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stock Minimo
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingredientes as $ingrediente)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-2">
                                    {{ $ingrediente->nombre }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ $ingrediente->stock }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ $ingrediente->stock_minimo }}
                                </td>
                                <td class="px-2 py-2 text-right">
                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <a type="button" href="{{ route('ingredientes.show', $ingrediente->id) }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-green-700  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 ">
                                                <x-iconos.view />
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>


    </div>



</x-app-layout>
{{-- <script type="module" src="{{ asset('js/grafica.js') }}" defer></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- usar variables php en js --}}
<script type="text/javascript">
    var labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agostos', 'Septiembre', 'Octubre',
        'Noviembre', 'Diciembre'
    ];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Restaurantes',
            data: [12, 19, 3, 5, 2, 3, 12, 19, 3, 5, 2, 3],
            backgroundColor: '#FF0000',
            borderColor: '#FF0000',
        }, {
            label: 'Pedidos Ya',
            data: [2, 29, 5, 5, 2, 3, 12, 19, 3, 5, 2, 3],
            backgroundColor: '#0000FF',
            borderColor: '#0000FF',
        }, {
            label: 'Yango',
            data: [10, 0, 4, 2, 2, 3, 10, 17, 3, 7, 2, 1],
            backgroundColor: '#00FF00',
            borderColor: '#00FF00',
        }, {
            label: 'Pagina Web',
            data: [20, 15, 3, 5, 2, 3, 2, 19, 3, 5, 2, 3],
            backgroundColor: '#FFFF00',
            borderColor: '#FFFF00',
        }, {
            label: 'Otros',
            data: [13, 19, 3, 5, 4, 3, 12, 10, 3, 1, 2, 1],
            backgroundColor: '#FF00FF',
            borderColor: '#FF00FF',
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    };

    var myChart = new Chart(
        document.getElementById('acquisitions'),
        config
    );
</script>
<script type="text/javascript">
    const dataPizza = {
        labels: ['Enero'],
        datasets: [{
                label: 'Margarita',
                data: [12],
                backgroundColor: '#FF0000',
                borderColor: '#FF0000',
            },
            {
                label: 'Hawaiana',
                data: [2],
                backgroundColor: '#0000FF',
                borderColor: '#0000FF',
            },
            {
                label: 'Napolitana',
                data: [10],
                backgroundColor: '#00FF00',
                borderColor: '#00FF00',
            },
            {
                label: 'Pepperoni',
                data: [20],
                backgroundColor: '#FFFF00',
                borderColor: '#FFFF00',
            },
            {
                label: 'Otras',
                data: [13],
                backgroundColor: '#FF00FF',
                borderColor: '#FF00FF',
            }
        ]
    };

    const configPizza = {
        type: 'bar',
        data: dataPizza,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    };

    var myChart = new Chart(
        document.getElementById('pizzas'),
        configPizza
    );
</script>
