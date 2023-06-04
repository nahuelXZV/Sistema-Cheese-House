<div class="w-full h-full bg-cover">
    <div class="absolute w-full h-full bg-cover bg-center bg-no-repeat"
        style="background-image: url('https://i.pinimg.com/550x/cb/5b/da/cb5bdad49312bd35e7413942afc94c3e.jpg');">

        <div class="flex flex-col items-center justify-center min-h-screen">
            <img src="{{ asset('logo_blanco.png') }}" class="w-28 h-auto mb-8" alt="FlowBite Logo" />
            <h1 class="text-5xl font-bold text-white mb-8 uppercase">
                Pedidos Listos
            </h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 ">
                @foreach ($pedidos as $pedido)
                    <div class="bg-white rounded-lg shadow-md p-6 w-full h-auto mx-3">
                        <div class="mb-4">
                            <h2 class="text-4xl font-bold mb-2">Pedido #{{ $pedido->codigo_seguimiento }}</h2>
                            <p class="text-xl text-gray-500">Cliente: {{ $pedido->cliente }}</p>
                        </div>
                        <p class="text-gray-700 invisible">
                            Pedido Listo <br>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            setInterval(function() {
                @this.call('refreshComponent');
            }, 5000);
        });
    </script>
