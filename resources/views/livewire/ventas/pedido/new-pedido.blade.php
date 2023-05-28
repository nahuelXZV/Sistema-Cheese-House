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
                    <a href="{{ route('pedidos.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Pedidos</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <x-iconos.flecha />
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nuevo</span>
                </div>
            </li>
        </ol>
        <div>
            <button wire:click="save"
                class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                Guardar
            </button>
        </div>
    </nav>
    <div class="grid grid-cols-4 gap-3">

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo Total</label>
            <input type="text" wire:model.lazy="pedidoArray.monto_total""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="pedidoArray.monto_total" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
            <input type="date" wire:model.lazy="pedidoArray.fecha"" value="{{ date('Y-m-d') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="pedidoArray.fecha" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
            <input type="time" wire:model.lazy="pedidoArray.hora"" value="{{ date('H:i') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="pedidoArray.hora" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Metodo de pago</label>
            <select wire:model="pedidoArray.metodo_pago" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona el tipo de pago</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error for="pedidoArray.metodo_pago" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveniencia</label>
            <select wire:model="pedidoArray.proveniente" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona el lugar de procedencia</option>
                <option value="Local">Local</option>
                <option value="Pagina Web">Pagina Web</option>
                <option value="Pedidos Ya">Pedidos Ya</option>
                <option value="Uber Eats">Uber Eats</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error for="pedidoArray.proveniente" />
        </div>

        <p class="col-span-4 text-lg font-medium text-gray-900 dark:text-white">Selecciona los productos</p>
        <div class="mb-6 col-span-4 grid grid-cols-7 gap-3">

            <div class="col-span-5 grid grid-rows">
                <div class="grid grid-cols-6">
                    @foreach ($pizzas as $pizza)
                        <div
                            class="flex items-center h-32 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $pizza['nombre'] }}" type="radio" value="{{ $pizza['id'] }}"
                                wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $pizza['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $pizza['url_imagen'] }}" class="w-24 h-24">
                                {{ $pizza['nombre'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($postres as $postre)
                        <div
                            class="flex items-center h-32 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $postre['nombre'] }}" type="radio" value="{{ $postre['id'] }}"
                                wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $postre['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $postre['url_imagen'] }}" class="w-24 h-24">
                                {{ $postre['nombre'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($bebidas as $bebida)
                        <div
                            class="flex items-center h-32 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $bebida['nombre'] }}" type="radio" value="{{ $bebida['id'] }}"
                                wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $bebida['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $bebida['url_imagen'] }}" class="w-24 h-24">
                                {{ $bebida['nombre'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($otros as $otro)
                        <div
                            class="flex items-center h-32 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $otro['nombre'] }}" type="radio" value="{{ $otro['id'] }}"
                                wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $otro['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $otro['url_imagen'] }}" class="w-24 h-24">
                                {{ $otro['nombre'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-2 grid grid-cols-2 gap-2 h-32">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="number" wire:model="productosArray.cantidad" min="0" step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" required>
                    <p class="text-sm text-gray-500 mt-0.5">Separado por un punto (.)</p>
                    <x-input-error for="productosArray.cantidad" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unidad</label>
                    <input type="number" wire:model="productosArray.precio_unidad" min="0" step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" required>
                    <p class="text-sm text-gray-500 mt-0.5">Separado por un punto (.)</p>
                    <x-input-error for="productosArray.precio_unidad" />
                </div>
                <div class="mb-6 col-span-2">
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detalles</label>
                    <textarea id="message" rows="4" wire:model.lazy="productosArray.detalles"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="......"></textarea>
                    <x-input-error for="productosArray.detalles" />
                </div>
                <div class="grid grid-col-2">
                    <div class="col-span-1 w-full"></div>
                    <button wire:click="addProductos"
                        class="inline-flex items-center justify-center h-9   text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                        Añadir
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-6 col-span-3">
            <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-2 py-2">Nombre</th>
                        <th class="px-2 py-2">Unidad</th>
                        <th class="px-2 py-2">Cantidad</th>
                        <th class="px-2 py-2">Precio</th>
                        <th class="px-2 py-2">Detalles</th>
                        <th class="px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidoArray['productos'] as $ingrediente)
                        <tr class="justify-center items-center text-center">
                            <td class="px-2 py-2">{{ $ingrediente['nombre'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['unidad'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['cantidad'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['precio_unidad'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['detalles'] }}</td>
                            <td class="px-2 py-2">
                                @if ($ingrediente['tipo'] == 'ingrediente')
                                    <button
                                        wire:click="deleteProductos({{ $ingrediente['ingrediente_id'] }},0, {{ $ingrediente['monto_total'] }})"
                                        class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                        Eliminar
                                    </button>
                                @else
                                    <button
                                        wire:click="deleteProductos(0,{{ $ingrediente['producto_id'] }},{{ $ingrediente['monto_total'] }})"
                                        class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                        Eliminar
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
