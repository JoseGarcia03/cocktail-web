<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($savedCocktails->isEmpty())
                        <p>No has guardado ningún cóctel aún.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($savedCocktails as $savedCocktail)
                                @php
                                    $cocktail = json_decode($savedCocktail->cocktail_data);
                                @endphp
                                <div class="cocktail border rounded p-4">
                                    <h2>{{ $cocktail->strDrink }}</h2>
                                    <img src="{{ $cocktail->strDrinkThumb }}" alt="{{ $cocktail->strDrink }}" class="w-full">
                                    <p>{{ $cocktail->strInstructions ?? 'Sin instrucciones' }}</p>
                                    <button class="delete-button bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-id="{{ $savedCocktail->cocktail_id }}">Eliminar</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
