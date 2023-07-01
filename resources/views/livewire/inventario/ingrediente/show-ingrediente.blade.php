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
                    <a href="{{ route('ingredientes.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Ingredientes</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <x-iconos.flecha />
                    <span
                        class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $ingrediente->nombre }}</span>
                </div>
            </li>
        </ol>
        <div>
            <a href="{{ route('ingredientes.edit', $ingrediente->id) }}"
                class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                Editar
            </a>
        </div>
    </nav>

    <form class="grid grid-cols-2 gap-3">
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" value="{{ $ingrediente->nombre }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Harina" readonly>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
            <input type="text" value="{{ $ingrediente->unidad }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="kg" readonly>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
            <input type="text" value="{{ $ingrediente->stock }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0" readonly>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
            <input type="text" value="{{ $ingrediente->precio_unidad }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0" readonly>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock minimo</label>
            <input type="text" value="{{ $ingrediente->stock_minimo }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="10" readonly>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock maximo</label>
            <input type="text" value="{{ $ingrediente->stock_maximo }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="100" readonly>
        </div>

        <div class="mb-2 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......">{{ $ingrediente->descripcion }}</textarea>
        </div>
    </form>

    {{-- {{ $recetas[0]->nombre }} --}}
</div>
