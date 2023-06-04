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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Cocina</span>
                </div>
            </li>
        </ol>
        <div>

        </div>
    </nav>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 ">
        @if (count($pedidos) == 0)
            <div class="bg-white rounded-lg shadow-md p-6 border">
                <div class="flex justify-center">
                    <p class="text-gray-700">No hay pedidos</p>
                </div>
            </div>
        @endif
        @foreach ($pedidos as $pedido)
            <div class="grid grid-rows-1 bg-white rounded-lg shadow-md p-6 border ">
                <div>
                    <div class="mb-4">
                        <h2 class="text-xl font-bold">Pedido #{{ $pedido['codigo_seguimiento'] }}</h2>
                        <p class="text-gray-500">Cliente: {{ $pedido['cliente'] }}</p>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <p class="text-md text-gray-700 font-bold">Nombre</p>
                        <p class="text-md text-gray-700 font-bold">#</p>
                    </div>
                    @foreach ($pedido['detalles_pedidos'] as $detalle)
                        <div class="flex justify-between mb-2">
                            @if ($detalle['mitad_uno'] != null && $detalle['mitad_dos'] != null)
                                <p class="text-gray-700">
                                    {{ $detalle['producto_id'] }} <br>
                                    <span class="text-xs text-gray-500 ml-3">-{{ $detalle['mitad_uno'] }}</span><br>
                                    <span class="text-xs text-gray-500 ml-3">-{{ $detalle['mitad_dos'] }}</span>
                                </p>
                            @else
                                <p class="text-gray-700">{{ $detalle['producto_id'] }}</p>
                            @endif
                            <p class="text-gray-700">{{ $detalle['cantidad'] }}</p>
                        </div>
                    @endforeach
                    @if ($pedido['detalles'] != '')
                        <hr class="my-2">
                        <h4 class="text-base font-bold mb-2">Detalles:</h4>
                        <p class="text-sm text-gray-500"> {{ $pedido['detalles'] }}</p>
                    @endif
                </div>
                <div class="flex justify-end mt-4">
                    <a href="{{ route('pedidos.show', $pedido['id']) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ver
                    </a>
                    <button onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()"
                        wire:click="updateEstado({{ $pedido['id'] }})"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Finalizar
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        setInterval(function() {
            @this.call('refreshComponent');
        }, 5000);
    });
</script>
