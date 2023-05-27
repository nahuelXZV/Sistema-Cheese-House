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
                    <a href="{{ route('proveedores.list') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Proveedores</a>
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
            <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                class="inline-flex items-center justify-center h-9 px-4 ml-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                Editar
            </a>
        </div>
    </nav>

    <form class="grid grid-cols-2 gap-3">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Empresa</label>
            <input type="text" wire:model.lazy="proveedorArray.nombre_empresa""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Coca Cola" readonly>
            <x-input-error for="proveedorArray.nombre_empresa" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Encargado</label>
            <input type="text" wire:model.lazy="proveedorArray.nombre_encargado""
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Marcos Rios" readonly>
            <x-input-error for="proveedorArray.nombre_encargado" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono</label>
            <input type="text" wire:model.lazy="proveedorArray.telefono"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="69341428" readonly>
            <x-input-error for="proveedorArray.telefono" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Direccion</label>
            <input type="text" wire:model.lazy="proveedorArray.direccion"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Calle Barron #15" readonly>
            <x-input-error for="proveedorArray.direccion" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
            <input type="text" wire:model.lazy="proveedorArray.correo"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="10" readonly>
            <x-input-error for="proveedorArray.correo" />
        </div>

        <div class="mb-6 col-span-2">
            <label for="message"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <textarea id="message" rows="4" wire:model.lazy="proveedorArray.descripcion"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="..........."></textarea>
            <x-input-error for="proveedorArray.descripcion" />
        </div>
    </form>

    <div class="mb-4 col-span-2">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Historial de Compras</h1>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Proveedor
                </th>
                <th scope="col" class="px-6 py-3">
                    Vendedor
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    Hora
                </th>
                <th scope="col" class="px-6 py-3">
                    Monto Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3">
                    Descripcion
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $compra->proveedor->nombre_empresa }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $compra->user->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $compra->fecha }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $compra->hora }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $compra->monto_total }} Bs
                    </td>
                    <td class="px-6 py-4">
                        {{ $compra->estado }}
                    </td>
                    <td class="px-6 py-4">
                        {{ Str::limit($compra->descripcion, 40, '...') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <a type="button" href="{{ route('compras.show', $compra->id) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-green-700  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 ">
                                    <x-iconos.view />
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-shared.pagination :modelo='$compras' />
</div>
</div>
