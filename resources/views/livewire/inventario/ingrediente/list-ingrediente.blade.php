<div>
    <nav class="flex px-3 py-3 mb-5 text-gray-700 justify-between border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <x-iconos.home />
                    Home
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <x-iconos.flecha />
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ingredientes</span>
                </div>
            </li>
        </ol>
        <div>
            @can('reportes')
                <input type="date" wire:model='date' value="{{ $date }}" max="{{ $diaAnterior }}"
                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-black bg-white rounded-lg hover:bg-white focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50">
                <a href="{{ route('reportes.ingredientesDiarios', $date) }}"
                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                    Reporte Mov.
                </a>
                <a href="{{ route('reportes.ingredientesMensuales') }}"
                    class="inline-flex items-center justify-center h-9 px-4 ml-1 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                    Reporte
                </a>
            @endcan
            <a href="{{ route('ingredientes.new') }}"
                class="inline-flex items-center justify-center h-9 px-4  text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                Nuevo
            </a>
        </div>
    </nav>
    <x-shared.notificacion :message='$message' :showMessage='$showMessage' />
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div>
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-iconos.search />
                </div>
                <input type="search" id="search"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search" wire:model.lazy='attribute'>
            </div>
        </div>

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
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingredientes as $ingrediente)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $ingrediente->nombre }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $ingrediente->stock }} {{ $ingrediente->unidad }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ingrediente->stock_minimo }} {{ $ingrediente->unidad }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ingrediente->precio_unidad }} Bs
                        </td>
                        <td class="px-6 py-4">
                            {{ Str::limit($ingrediente->descripcion, 40, '...') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a type="button" href="{{ route('ingredientes.edit', $ingrediente->id) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 ">
                                        <x-iconos.edit />
                                    </a>
                                    <a type="button" href="{{ route('ingredientes.show', $ingrediente->id) }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-green-700  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 ">
                                        <x-iconos.view />
                                    </a>
                                    @can('eliminar')
                                        <button type="button" wire:click="delete({{ $ingrediente->id }})"
                                            onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 ">
                                            <x-iconos.delete />
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-shared.pagination :modelo='$ingredientes' />
    </div>
</div>
