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
                    <a href="{{ route('combos.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Combos</a>
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

    <div class="grid grid-cols-3 gap-3">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" wire:model.defer="comboArray.nombre""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Combo 1" required>
            <x-input-error for="comboArray.nombre" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo Total</label>
            <input type="text" wire:model.defer="comboArray.costo_total""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00">
            <x-input-error for="comboArray.costo_total" />
        </div>
        <div class="">
            <label for="categoria" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
            <div class="grid grid-cols-2">
                <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                    <input id="bordered-radio-1" type="radio" value="{{ true }}" name="bordered-radio"
                        wire:model="comboArray.activo"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-radio-1"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</label>
                </div>
                <div class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                    <input id="bordered-radio-2" type="radio" value="{{ false }}" name="bordered-radio"
                        wire:model="comboArray.activo"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-radio-2"
                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Inactivo</label>
                </div>
            </div>
            <x-input-error for="comboArray.activo" />
        </div>

        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="3" wire:model.defer="comboArray.descripcion"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......"></textarea>
            <x-input-error for="comboArray.descripcion" />
        </div>


        <div class="col-span-3 mb-6 grid grid-cols-2 gap-3">
            <div class="">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Productos</label>
                <select wire:model="productosArray.producto_id" required
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
            <div class="grid grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="text" wire:model.defer="productosArray.cantidad"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" required>
                    <x-input-error for="productosArray.cantidad" />
                </div>
                <div class="grid grid-row-2">
                    <label class="invisible mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <button wire:click="addIngrediente"
                        class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
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
                        <th class="px-2 py-2">Cantidad</th>
                        <th class="px-2 py-2">Precio</th>
                        <th class="px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comboArray['productos'] as $producto)
                        <tr class="justify-center items-center text-center">
                            <td class="px-2 py-2">{{ $producto['nombre'] }}</td>
                            <td class="px-2 py-2">{{ $producto['cantidad'] }}</td>
                            <td class="px-2 py-2">{{ $producto['precio_unidad'] }}</td>
                            <td class="px-2 py-2">
                                <button
                                    wire:click="deleteIngrediente({{ $producto['producto_id'] }}, {{ $producto['cantidad'] }})"
                                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
