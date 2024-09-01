<div>
    <nav class="flex px-5 py-3 mb-5 text-gray-700 justify-between border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <x-iconos.home />
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <x-iconos.flecha />
                    <a href="{{ route('caja.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Caja</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <x-iconos.flecha />
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ver</span>
                </div>
            </li>
        </ol>
        <div>

        </div>
    </nav>
    <br>
    <x-shared.notificacion :message='$message' :showMessage='$showMessage' />
    <div class="grid grid-cols-5 gap-3">
        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dia</label>
            <input type="text" readonly value="{{ $caja->dia }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
            <input type="text" readonly value="{{ $caja->fecha }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-1 col-span-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cajero</label>
            <input type="text" readonly value="{{ $cajero }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
    </div>
    <br>
    <div>
        <div class="col-span-2 h-full">
            <p>
                <span class="text-lg font-bold text-gray-900 dark:text-white">FLUJO DE CAJA DIARIO</span>
            </p>
            <div class="mb-6">
                <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                    <thead class="bg-gray-200">
                        <tr class="justify-start items-start text-start">
                            <th class="px-2 py-2">Nro Pedido</th>
                            <th class="px-2 py-2">Nombre del pedido</th>
                            <th class="px-2 py-2">Total Bs del pedido</th>
                            <th class="px-2 py-2">Metodo de pago</th>
                            <th class="px-2 py-2">Unidades Pizza</th>
                            <th class="px-2 py-2">OBS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $key => $pedido)
                            <tr class="justify-center items-center text-center">
                                <td class="px-2 py-2"> {{ $key + 1 }} </td>
                                <td class="px-2 py-2">{{ $pedido['cliente'] }}</td>
                                <td class="px-2 py-2">{{ $pedido['monto_total'] }}</td>
                                <td class="px-2 py-2">{{ $pedido['metodo_pago'] }}</td>
                                <td class="px-2 py-2">{{ $pedido['totalPizzasVendidas'] }}</td>
                                <td class="px-2 py-2">{{ $pedido['proveniente'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="justify-center items-center text-center bg-gray-100">
                            <td class="px-2 py-2  font-bold"></td>
                            <td class="px-2 py-2 font-bold">TOTAL: </td>
                            <td class="px-2 py-2  font-bold">{{ $ventas }} Bs.</td>
                            <td class="px-2 py-2"></td>
                            <td class="px-2 py-2 font-bold">{{ $totalPizzasVendidas }} </td>
                            <td class="px-2 py-2 font-bold"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div>
                    <p>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">RESUMEN</span>
                    </p>
                    <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                        <tbody>
                            <tr class="justify-start items-start text-start bg-red-200">
                                <td class="px-2 py-2 font-bold">INICIO DE CAJA</td>
                                <td class="px-2 py-2 font-bold">{{ $cajaInicial }} Bs.</td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-100">
                                <td class="px-2 py-2 font-bold">EFECTIVO</td>
                                <td class="px-2 py-2 font-bold">{{ $estadoCaja['efectivo'] }} Bs.</td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-red-200">
                                <td class="px-2 py-2 font-bold">FIN DE CAJA</td>
                                <td class="px-2 py-2 font-bold">
                                    {{ $cajaInicial + $estadoCaja['efectivo'] }} Bs.
                                </td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-100">
                                <td class="px-2 py-2 font-bold">TARJETA</td>
                                <td class="px-2 py-2 font-bold">{{ $estadoCaja['tarjeta'] }} Bs.</td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-100">
                                <td class="px-2 py-2 font-bold">QR</td>
                                <td class="px-2 py-2 font-bold">{{ $estadoCaja['qr'] }} Bs.</td>
                            </tr>
                            {{-- <tr class="justify-start items-start text-start bg-gray-100">
                                <td class="px-2 py-2 font-bold">PAGOS ONLINE</td>
                                <td class="px-2 py-2 font-bold">0 </td>
                            </tr> --}}
                            <tr class="justify-start items-start text-start bg-blue-100">
                                <td class="px-2 py-2 font-bold">TOTAL INGRESOS</td>
                                <td class="px-2 py-2 font-bold">{{ $ventas }} Bs. </td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-blue-100">
                                <td class="px-2 py-2 font-bold">NRO. PIZZAS VENDIDAS</td>
                                <td class="px-2 py-2 font-bold">{{ $totalPizzasVendidas }} UND. </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <p>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">ESTADO</span>
                    </p>
                    <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                        <tbody>
                            <tr class="justify-start items-start text-start bg-red-200">
                                <td class="px-2 py-2 font-bold">CANTIDAD A DEPOSITAR EN BS</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="cantidad_deposito"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 p-2.5 h-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="cantidad_deposito" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 p-2.5
                                                h-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                                </td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-blue-200">
                                <td class="px-2 py-2 font-bold">TRANSPASO A CAJA CHICA EN BS</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="transpaso_caja_chica"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="transpaso_caja_chica" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                                </td>
                            </tr>
                            <tr class="justify-start items-start text-start bg-green-200">
                                <td class="px-2 py-2 font-bold">ADICION DE CAJA CHICA EN BS</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="adicion_caja_chica"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="adicion_caja_chica" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-200">
                                <td class="px-2 py-2 font-bold">CAJA PARA DIA SIGUIENTE</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="caja_dia_siguiente"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="caja_dia_siguiente" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-200">
                                <td class="px-2 py-2 font-bold">CORTESIA</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="cortesia"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="cortesia" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                            </tr>
                            <tr class="justify-start items-start text-start bg-gray-200">
                                <td class="px-2 py-2 font-bold">FALTO</td>
                                <td class="px-2 py-2 font-bold">
                                    @can('caja.update')
                                        <input type="number" wire:model="falto"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @else
                                        <input type="number" wire:model="falto" readonly
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 h-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @endcan
                            </tr>
                            @can('caja.update')
                                <tr class="justify-start items-start text-start bg-gray-200">
                                    <td class="px-2 py-2 font-bold"></td>
                                    <td class="px-2 py-2 font-bold">
                                        <button wire:click="update"
                                            class="bg-blue-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 p-2.5  ">
                                            Actualizar
                                        </button>
                                    </td>
                                </tr>
                            @endcan
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
