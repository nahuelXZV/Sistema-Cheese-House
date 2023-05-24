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
                    <a href="{{ route('productos.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Productos</a>
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
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" wire:model.lazy="productoArray.nombre"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Pizza Margarita" required>
            <x-input-error for="productoArray.nombre" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
            <input type="number" wire:model.lazy="productoArray.precio" min=" 0" max="1000000" step="0.01"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="30" required>
            <x-input-error for="productoArray.precio" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tamaño</label>
            <input type="text" wire:model.lazy="productoArray.tamaño"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Familiar" required>
            <x-input-error for="productoArray.tamaño" />
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Subir
                Imagen</label>
            <input wire:model="foto"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="file_input" type="file">
            <x-input-error for="foto" />
        </div>


        <div class="mb-6">
            <label for="categoria"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
            <select id="categoria" wire:model.lazy="productoArray.categoria"
                class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona una categoria</option>
                <option value="Pizza">Pizza</option>
                <option value="Bebida">Bebida</option>
                <option value="Postre">Postre</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error for="productoArray.categoria" />

        </div>

        @if ($productoArray['categoria'] == 'Pizza' || $productoArray['categoria'] == 'Postre')
            <div class="mb-6">
                <label for="tipo_botella"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Receta*</label>
                <select id="tipo_botella" wire:model.lazy="productoArray.receta_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Selecciona una receta</option>
                    @foreach ($recetas as $receta)
                        <option value="{{ $receta->id }}">{{ $receta->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="productoArray.receta_id" />
            </div>
        @else
            <div class="col-span-2"></div>
        @endif

        @if ($productoArray['categoria'] == 'Bebida' || $productoArray['categoria'] == 'Otro')
            @if ($productoArray['categoria'] == 'Bebida')
                <div class="mb-6">
                    <label for="tipo_botella" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo
                        de botella*</label>
                    <select id="tipo_botella" wire:model.lazy="productoArray.tipo_botella"
                        class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Selecciona un tipo</option>
                        <option value="Vidrio">Vidrio</option>
                        <option value="Plastico">Plastico</option>
                        <option value="Retornable">Retornable</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <x-input-error for="productoArray.tipo_botella" />
                </div>
            @endif

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock*</label>
                <input type="number" wire:model.lazy="productoArray.stock" min=" 0" max="1000000" step="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="0" required>
                <x-input-error for="productoArray.stock" />
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Minimo*</label>
                <input type="number" wire:model.lazy="productoArray.stock_minimo" min=" 0" max="1000000"
                    step="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="0" required>
                <x-input-error for="productoArray.stock_minimo" />
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Maximo*</label>
                <input type="number" wire:model.lazy="productoArray.stock_maximo" min=" 0" max="1000000"
                    step="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="0" required>
                <x-input-error for="productoArray.stock_maximo" />
            </div>
        @endif

        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4" wire:model.lazy="productoArray.descripcion"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="......"></textarea>
            <x-input-error for="productoArray.descripcion" />
        </div>


    </div>

</div>
