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
                    <a href="{{ route('compras.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Compras</a>
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

    <div class="grid grid-cols-2 gap-3">
        <div class="">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveedor</label>
            <select wire:model="compraArray.proveedor_id" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Seleccione el proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">
                        {{ $proveedor->nombre_empresa }}
                    </option>
                @endforeach
            </select>
            <x-input-error for="compraArray.proveedor_id" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo Total</label>
            <input type="text" wire:model.defer="compraArray.monto_total""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="compraArray.monto_total" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
            <input type="date" wire:model.defer="compraArray.fecha"" value="{{ date('Y-m-d') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="compraArray.fecha" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
            <input type="time" wire:model.defer="compraArray.hora"" value="{{ date('H:i') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="compraArray.hora" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de pago</label>
            <select wire:model.defer="compraArray.tipo_pago" required
                class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona el tipo de pago</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                <option value="QR">QR</option>
                <option value="Otro">Otro</option>

            </select>
            <x-input-error for="compraArray.tipo_pago" />
        </div>


        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4" wire:model.defer="compraArray.descripcion"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......"></textarea>
            <x-input-error for="compraArray.descripcion" />
        </div>

        {{-- un select para seleccionar los ingredientes y una tabla para mostrar dichos ingredietnes --}}
        <p class="text-lg font-medium text-gray-900 dark:text-white">Selecciona los ingredientes o productos</p>
        <div class="mb-6 col-span-2 grid grid-cols-2 gap-3">
            <div class="">
                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingredientes</label>
                    <select wire:model="productosArray.ingrediente_id" required
                        @if ($productosArray['producto_id'] != '') disabled @endif
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Selecciona los ingredientes</option>
                        @foreach ($ingredientes as $ingrediente)
                            <option value="{{ $ingrediente['id'] }}">
                                {{ $ingrediente['nombre'] . ' - ' . $ingrediente['unidad'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="productosArray.ingrediente_id" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Productos</label>
                    <select wire:model="productosArray.producto_id" required
                        @if ($productosArray['ingrediente_id'] != '') disabled @endif
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Selecciona los productos</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto['id'] }}">
                                {{ $producto['nombre'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="productosArray.producto_id" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="number" wire:model.defer="productosArray.cantidad" min="0" step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" required>
                    <p class="text-sm text-gray-500 mt-0.5">Separado por un punto (.)</p>
                    <x-input-error for="productosArray.cantidad" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unidad</label>
                    <input type="number" wire:model.defer="productosArray.precio_unidad" min="0" step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" required>
                    <p class="text-sm text-gray-500 mt-0.5">Separado por un punto (.)</p>
                    <x-input-error for="productosArray.precio_unidad" />
                </div>
                <div class="mb-6 col-span-2">
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detalles</label>
                    <textarea id="message" rows="4" wire:model.defer="productosArray.detalles"
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

        <div class="mb-6 col-span-2">
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
                    @foreach ($compraArray['productos'] as $ingrediente)
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
