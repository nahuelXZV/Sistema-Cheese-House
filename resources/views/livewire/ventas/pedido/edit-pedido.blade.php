<div class="pb-10">
    <div class="sm:mr-100">
        <section class="">
            <nav class="flex px-3 py-3 mb-3 text-gray-700 justify-between border border-gray-200 rounded-md bg-white dark:bg-gray-800 dark:border-gray-700"
                aria-label="Breadcrumb">
                <ul class="grid w-full h-10 gap-2 md:grid-cols-5">
                    <li>
                        <input type="radio" id="Pizza" name="filter" value="Pizza" wire:model.live="filter"
                            class="hidden peer" />
                        <label for="Pizza"
                            class="h-10 inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex justify-center items-center">
                                <x-iconos.pizzaI />
                                <div class="w-full text-lg font-semibold ml-2">Pizzas</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="Mitad" name="filter" value="Mitad" class="hidden peer"
                            wire:model.live="filter" />
                        <label for="Mitad"
                            class="h-10 inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex justify-center items-center">
                                <x-iconos.pizzaI />
                                <div class="w-full text-lg font-semibold ml-2">Mitades</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="Postre" name="filter" value="Postre" class="hidden peer"
                            wire:model.live="filter" />
                        <label for="Postre"
                            class="h-10 inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex justify-center items-center">
                                <x-iconos.postre />
                                <div class="w-full text-lg font-semibold ml-2">Postres</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="Bebida" name="filter" value="Bebida" class="hidden peer"
                            wire:model.live="filter" />
                        <label for="Bebida"
                            class="h-10 inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex justify-center items-center">
                                <x-iconos.bebida />
                                <div class="w-full text-lg font-semibold ml-2">Bebidas</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="Otro" name="filter" value="Otro"
                            class="hidden peer"wire:model.live="filter" />
                        <label for="Otro"
                            class="h-10 inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <div class="flex justify-center items-center">
                                <x-iconos.otro />
                                <div class="w-full text-lg font-semibold ml-2">Otros</div>
                            </div>
                        </label>
                    </li>
                </ul>
            </nav>
            <div class="w-full ">
                <div class="grid grid-cols-5 gap-1">
                    @foreach ($productos as $producto)
                        <div class="">
                            <input type="radio" id="{{ $producto['nombre'] }}" value="{{ $producto['id'] }}"
                                class="hidden peer" required name="producto_id"
                                wire:model.live="productosArray.producto_id">
                            <label for="{{ $producto['nombre'] }}" wire:click="checkProducto({{ $producto['id'] }})"
                                class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-md cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <img src="{{ $producto['url_imagen'] }}" class=" items-center w-24 h-24">
                                    <div class="w-full text-sm font-semibold mt-2"> {{ $producto['nombre'] }}</div>
                                    <div class="w-full text-sm"> {{ $producto['precio'] }}
                                        Bs.
                                    </div>
                                    @if ($productoCheck == $producto['id'])
                                        <button wire:click="add"
                                            class="mt-2 h-6 px-5 text-sm font-base text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                            Añadir
                                        </button>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <aside id="default-sidebar"
        class="fixed top-0 right-0 z-40 w-100 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 mt-14 overflow-y-auto bg-white dark:bg-gray-800">
            <div class="grid grid-cols-3 gap-2 border p-4 rounded-sm">
                <div class="mb-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo </label>
                    <input type="text" wire:model.defer="pedidoArray.codigo_seguimiento" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="xxxxx">
                </div>
                <div class="mb-1 col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Cliente</label>
                    <input type="text" wire:model.defer="pedidoArray.cliente""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombre">
                    <x-input-error for="pedidoArray.cliente" />
                </div>
                <div class="mb-1 col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento</label>
                    <select wire:model="descuentoCheck"
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>Selecciona</option>
                        @foreach ($descuentos as $descuento)
                            <option value="{{ $descuento->id }}">
                                {{ $descuento->nombre . ' | ' . $descuento->porcentaje . '%' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Para</label>
                    <select wire:model="pedidoArray.tipo_pedido"
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>Selecciona </option>
                        @foreach ($tipos as $metodo)
                            <option value="{{ $metodo }}">
                                {{ $metodo }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="pedidoArray.tipo_pedido" />
                </div>

                <div class="mb-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Metodo de pago</label>
                    <select wire:model="pedidoArray.metodo_pago" required
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>Selecciona</option>
                        @foreach ($metodoPagos as $metodo)
                            <option value="{{ $metodo }}">{{ $metodo }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="pedidoArray.metodo_pago" />
                </div>

                <div class="mb-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveniencia</label>
                    <select wire:model.defer="pedidoArray.proveniente" required
                        class="w-full px-2 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Selecciona</option>
                        @foreach ($proveniencias as $metodo)
                            <option value="{{ $metodo }}">{{ $metodo }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="pedidoArray.proveniente" />
                </div>

                <div class="col-span-3 ">
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detalles</label>
                    <textarea id="message" rows="1" wire:model.defer="pedidoArray.detalles"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="......"></textarea>
                    <x-input-error for="pedidoArray.detalles" />
                </div>
            </div>

            <table class="w-full text-sm text-gray-900 bg-white-50 border p-4 rounded-sm border-gray-300  mt-2">
                <tbody>
                    @foreach ($pedidoArray['productos'] as $key => $ingrediente)
                        <tr class="justify-center items-center text-start">
                            <td class="px-2 py-2 w-14">
                                <div class="relative flex items-center">
                                    <button type="button" id="{{ $ingrediente['key'] }}--dec"
                                        wire:click="decrement({{ $ingrediente['key'] }})"
                                        class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                        <x-iconos.menos />
                                    </button>
                                    <input type="text" id="{{ $ingrediente['key'] }}" min="1"
                                        value="{{ $ingrediente['cantidad'] }}"
                                        class="mx-2 flex-shrink-0 text-gray-900 dark:text-white border bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                        required />
                                    <button type="button" id="{{ $ingrediente['key'] }}-add"
                                        wire:click="increment({{ $ingrediente['key'] }})"
                                        class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                        <x-iconos.mas />
                                    </button>
                                </div>
                            </td>
                            <td class="px-2 py-2 w-auto">
                                {{ $ingrediente['nombre'] }}
                            </td>
                            <td class="px-2 py-2 w-20">{{ $ingrediente['subTotal'] }} Bs.</td>
                            <td class="px-2 py-1 w-8">
                                <button wire:loading.attr="disabled" wire:target="deleteProductos"
                                    wire:click="deleteProductos({{ $ingrediente['key'] }})"
                                    class="inline-flex items-center justify-center  text-black">
                                    <x-iconos.equis />
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border p-4 rounded-sm mt-2 mb-20">
                <div class="flex justify-end items-end text-end">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">SubTotal:
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $pedidoArray['monto_total'] + $montoDescuento }} Bs.
                            </span>
                        </label>
                    </div>
                </div>
                @if ($descuentoAplicado)
                    <div class="flex justify-end items-end text-end">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Descuento:
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    -{{ $montoDescuento }} Bs.
                                </span>
                            </label>
                        </div>
                    </div>
                @endif
                <div class="flex justify-end items-end text-end">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Total:
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $pedidoArray['monto_total'] }} Bs.
                            </span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end items-end text-end">
                    <button wire:click="save"
                        class="w-full px-5 py-2 text-sm font-base text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </aside>
</div>
