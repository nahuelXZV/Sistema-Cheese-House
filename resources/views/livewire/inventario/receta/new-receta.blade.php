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
                    <a href="{{ route('recetas.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Recetas</a>
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

    <form class="grid grid-cols-2 gap-3">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" wire:model.lazy="recetaArray.nombre""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Pizza Margarita" required>
            <x-input-error for="recetaArray.nombre" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo</label>
            <input type="text" wire:model.lazy="recetaArray.costo""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00" readonly>
            <x-input-error for="recetaArray.costo" />
        </div>

        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4" wire:model.lazy="recetaArray.descripcion"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......"></textarea>
            <x-input-error for="recetaArray.descripcion" />
        </div>


        {{-- un select para seleccionar los ingredientes y una tabla para mostrar dichos ingredietnes --}}
        <div class="mb-6 col-span-2 grid grid-cols-2 gap-3">
            <div class="">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingredientes</label>
                <select
                    class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Selecciona los ingredientes</option>
                    @foreach ($ingredientes as $ingrediente)
                        <option value="{{ $ingrediente }}">{{ $ingrediente->nombre . ' - ' . $ingrediente->unidad }}
                        </option>
                    @endforeach
                </select>
                <x-input-error for="ingrediente_id" />
            </div>
            <div class="grid grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0.00" readonly>
                    <x-input-error for="recetaArray.costo" />
                </div>
                <div class="grid grid-row-2">
                    <label class="invisible mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <button
                        class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
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
                        <th class="px-2 py-2">Cantidad</th>
                        <th class="px-2 py-2">Unidad</th>
                        <th class="px-2 py-2">Precio</th>
                        <th class="px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recetaArray['ingredientes'] as $ingrediente)
                        <tr>
                            <td class="px-2 py-2">{{ $ingrediente['nombre'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['cantidad'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['unidad'] }}</td>
                            <td class="px-2 py-2">{{ $ingrediente['precio'] }}</td>
                            <td class="px-2 py-2">
                                <button wire:click="removeIngrediente({{ $loop->index }})"
                                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </form>
</div>
