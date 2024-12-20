<x-app-layout>
    <div class="container py-12 md:px-10 mx-auto">
        <h1 class="text-xl font-bold mb-2">Cócteles</h1>
        <div class="mb-4">
            @foreach (range('A', 'Z') as $letter)
                <button class="letter-button bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2 mb-2" data-letter="{{ $letter }}">{{ $letter }}</button>
            @endforeach
        </div>

        <div id="cocktail-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($cocktails as $cocktail)
                <div class="border rounded p-4">
                    <h2>{{ $cocktail->strDrink }}</h2>
                    <img src="{{ $cocktail->strDrinkThumb }}" alt="{{ $cocktail->strDrink }}" class="w-full">
                    <p>{{ $cocktail->strInstructions ?? 'Sin instrucciones' }}</p>
                    <button class="save-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-id="{{ $cocktail->idDrink }}">Guardar</button>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
