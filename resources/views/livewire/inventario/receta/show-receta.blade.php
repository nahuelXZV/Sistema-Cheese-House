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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ver</span>
                </div>
            </li>
        </ol>
        <div>
            <a href="{{ route('recetas.edit', $receta->id) }}"
                class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                Editar
            </a>
        </div>
    </nav>

    <div class="grid grid-cols-2 gap-3">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" value="{{ $receta->nombre }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                readonly>
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo Total</label>
            <input type="text" value="{{ $receta->costo_total }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                readonly>
        </div>

        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4" readonly
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $receta->descripcion }}</textarea>
        </div>

        <div class="mb-4 col-span-2">
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Lista de Ingredientes</h1>
        </div>
        <div class="mb-6 col-span-2">
            <table class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-2 py-2">Nombre</th>
                        <th class="px-2 py-2">Unidad</th>
                        <th class="px-2 py-2">Cantidad</th>
                        <th class="px-2 py-2">Precio</th>
                        <th class="px-2 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receta->ingredientes as $ingrediente)
                        <tr class="justify-center items-center text-center">
                            <td class="px-2 py-2">{{ $ingrediente->nombre }}</td>
                            <td class="px-2 py-2">{{ $ingrediente->unidad }}</td>
                            <td class="px-2 py-2">{{ $ingrediente->pivot->cantidad }}</td>
                            <td class="px-2 py-2">{{ $ingrediente->precio_unidad }}</td>
                            <td class="px-2 py-2">{{ $ingrediente->pivot->costo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
