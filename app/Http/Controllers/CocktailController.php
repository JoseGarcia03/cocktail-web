<?php

namespace App\Http\Controllers;

use App\Models\SavedCocktail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CocktailController extends Controller
{
    public function index()
    {
        $client = new Client();
        $url = 'www.thecocktaildb.com/api/json/v1/1/search.php?f=a';

        try {
            $response = $client->request('GET', $url);
            $cocktails = json_decode($response->getBody());
            return view('home', ['cocktails' => $cocktails->drinks ?? []]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->getMessage();
            return view('home', ['error' => $error]);
        }
    }

    public function search(Request $request)
    {
        $search = $request->query('s');
        if (!$search) {
            return response()->json(['drinks' => []]);
        }
        $client = new Client();
        $url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?f=" . $search;

        try {
            $response = $client->request('GET', $url);
            $cocktails = json_decode($response->getBody());
            return response()->json($cocktails);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->getMessage();
            return response()->json(['error' => $error], 500);
        }
    }

    public function save(Request $request)
    {
        try {
            $cocktailId = $request->input('id');
            $client = new Client();
            $url = "https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=" . $cocktailId;
            $response = $client->request('GET', $url);
            $cocktailData = json_decode($response->getBody());

            if (!$cocktailData || !$cocktailData->drinks || count($cocktailData->drinks) == 0) {
                return response()->json(['message' => 'Cóctel no encontrado en la API.'], 404);
            }
            $cocktailData = json_encode($cocktailData->drinks[0]);

            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Debes iniciar sesión para guardar cócteles.'], 401);
            }

            if (empty($cocktailId)) {
                return response()->json(['message' => 'ID de cóctel inválido.'], 400);
            }

            $existingSave = SavedCocktail::where('user_id', $user->id)
                ->where('cocktail_id', $cocktailId)
                ->first();

            if ($existingSave) {
                return response()->json(['message' => 'Este cóctel ya está guardado.'], 400);
            }

            $savedCocktail = new SavedCocktail();
            $savedCocktail->user_id = $user->id;
            $savedCocktail->cocktail_id = $cocktailId;
            $savedCocktail->cocktail_data = $cocktailData;
            $savedCocktail->save();

            return response()->json(['message' => 'Cóctel guardado correctamente.']);

        } catch (\Exception $e) {
            Log::error('Error al guardar cóctel: ' . $e->getMessage());
            return response()->json(['message' => 'Error interno al guardar el cóctel.'], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $cocktailId = $request->input('id');
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Debes iniciar sesión para eliminar cócteles.'], 401);
            }

            $savedCocktail = SavedCocktail::where('user_id', $user->id)
                ->where('cocktail_id', $cocktailId)
                ->first();

            if (!$savedCocktail) {
                return response()->json(['message' => 'Este cóctel no está guardado.'], 404);
            }

            $savedCocktail->delete();

            return response()->json(['message' => 'Cóctel eliminado correctamente.']);

        } catch (\Exception $e) {
            Log::error('Error al eliminar cóctel: ' . $e->getMessage());
            return response()->json(['message' => 'Error interno al eliminar el cóctel.'], 500);
        }
    }

    public function saved()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $savedCocktails = SavedCocktail::where('user_id', $user->id)->get();

        return view('saved', ['savedCocktails' => $savedCocktails]);
    }
}
