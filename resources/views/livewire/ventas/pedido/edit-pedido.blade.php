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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Editar</span>
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
    <div class="grid grid-cols-5 gap-3">

        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo Seguimiento</label>
            <input type="text" wire:model.defer="pedidoArray.codigo_seguimiento" readonly
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="xxxxx">
        </div>

        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Cliente</label>
            <input type="text" wire:model.defer="pedidoArray.cliente""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nombre">
            <x-input-error for="pedidoArray.cliente" />
        </div>

        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Metodo de pago</label>
            <select wire:model.defer="pedidoArray.metodo_pago" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona el tipo de pago</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                <option value="QR">QR</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error for="pedidoArray.metodo_pago" />
        </div>

        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveniencia</label>
            <select wire:model.defer="pedidoArray.proveniente" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona el lugar</option>
                <option value="Local">Local</option>
                <option value="Pagina Web">Pagina Web</option>
                <option value="Pedidos Ya">Pedidos Ya</option>
                <option value="Uber Eats">Uber Eats</option>
                <option value="Rappi">Rappi</option>
                <option value="Glovo">Glovo</option>
                <option value="Whatsapp">Whatsapp</option>
                <option value="Telefono">Telefono</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error for="pedidoArray.proveniente" />
        </div>

        <div class="mb-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo Total</label>
            <input type="text" wire:model.defer="pedidoArray.monto_total""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="pedidoArray.monto_total" />
        </div>

        <div class="mb-6 col-span-3">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detalles</label>
            <textarea id="message" rows="2" wire:model.defer="pedidoArray.detalles"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......"></textarea>
            <x-input-error for="pedidoArray.detalles" />
        </div>
    </div>


    <div>
        <p class="col-span-4 text-lg font-medium text-gray-900 dark:text-white mb-2">Selecciona los productos</p>
        <div class="mb-6 col-span-4 grid grid-cols-7 gap-3">

            <div class="col-span-5 grid grid-rows">
                <div class="grid grid-cols-6">
                    @foreach ($pizzas as $pizza)
                        <div class="flex items-center h-42 px-4 py-2 border border-gray-200 rounded">
                            <input id="{{ $pizza['nombre'] }}" type="radio" value="{{ $pizza['id'] }}"
                                name="producto_id" wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="{{ $pizza['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $pizza['url_imagen'] }}" class="w-24 h-24">
                                {{ $pizza['nombre'] }} <br /> {{ $pizza['tamaño'] }} <br /> {{ $pizza['precio'] }} Bs
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($postres as $postre)
                        <div class="flex items-center h-42 px-4 py-2 border border-gray-200 rounded">
                            <input id="{{ $postre['nombre'] }}" type="radio" value="{{ $postre['id'] }}"
                                name="producto_id" wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="{{ $postre['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $postre['url_imagen'] }}" class="w-24 h-24">
                                {{ $postre['nombre'] }} <br /> {{ $postre['tamaño'] }} <br /> {{ $postre['precio'] }}
                                Bs
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($bebidas as $bebida)
                        <div
                            class="flex items-center h-42 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $bebida['nombre'] }}" type="radio" value="{{ $bebida['id'] }}"
                                name="producto_id" wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $bebida['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $bebida['url_imagen'] }}" class="w-24 h-24">
                                {{ $bebida['nombre'] }} <br /> {{ $bebida['tamaño'] }} <br /> {{ $bebida['precio'] }}
                                Bs
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-6">
                    @foreach ($otros as $otro)
                        <div
                            class="flex items-center h-42 px-4 py-2 border border-gray-200 rounded dark:border-gray-700">
                            <input id="{{ $otro['nombre'] }}" type="radio" value="{{ $otro['id'] }}"
                                name="producto_id" wire:model="productosArray.producto_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $otro['nombre'] }}"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 text-center">
                                <img src="{{ $otro['url_imagen'] }}" class="w-24 h-24">
                                {{ $otro['nombre'] }} <br /> {{ $otro['tamaño'] }} <br /> {{ $otro['precio'] }} Bs
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-2 h-32">
                @if ($productosArray['producto_id'] == 1)
                    <div class="grid grid-cols-2 gap-2 mb-1">
                        <div class="mb-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mitad
                                Uno</label>
                            <select required wire:model.defer="productosArray.mitad_uno"
                                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Selecciona la mitad</option>
                                @foreach ($mitades as $pizza)
                                    <option value="{{ $pizza['id'] }}">{{ $pizza['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="productosArray.mitad_uno" />
                        </div>
                        <div class="mb-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mitad
                                Dos</label>
                            <select required wire:model.defer="productosArray.mitad_dos"
                                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Selecciona la mitad</option>
                                @foreach ($mitades as $pizza)
                                    <option value="{{ $pizza['id'] }}">{{ $pizza['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="productosArray.mitad_dos" />
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                        <input type="number" wire:model.defer="productosArray.cantidad" min="0"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="0" required>
                        <x-input-error for="productosArray.cantidad" />
                    </div>
                    <div class="flex justify-center text-center items-end py-1">
                        <button wire:click="addProductos"
                            class="h-9 px-5  text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                            Añadir
                        </button>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-0.5">Separado por un punto (.)</p>
                <div class="mb-6">
                    <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2">Nombre</th>
                                <th class="px-2 py-2">Cantidad</th>
                                <th class="px-2 py-2">Total</th>
                                <th class="px-2 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidoArray['productos'] as $ingrediente)
                                <tr class="justify-center items-center text-center">
                                    <td class="px-2 py-2">
                                        {{ $ingrediente['nombre'] }}
                                        @if ($ingrediente['mitad_uno'] != null && $ingrediente['mitad_dos'] != null)
                                            <br>
                                            {{ $ingrediente['nombre_uno'] }} / {{ $ingrediente['nombre_dos'] }}
                                        @endif

                                    </td>
                                    <td class="px-2 py-2">{{ $ingrediente['cantidad'] }}</td>
                                    <td class="px-2 py-2">{{ $ingrediente['monto_total'] }}</td>
                                    <td class="px-2 py-2">
                                        <button
                                            wire:click="deleteProductos({{ $ingrediente['key'] }}, {{ $ingrediente['monto_total'] }})"
                                            class="inline-flex items-center justify-center h-9 px-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
