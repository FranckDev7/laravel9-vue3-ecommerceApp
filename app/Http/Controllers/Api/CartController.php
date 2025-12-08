<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CartRepository;
use Darryldecode\Cart\Exceptions\InvalidItemException;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): ?\Illuminate\Http\JsonResponse
    {
        try {
            $cartContent = (new CartRepository())->content();
            $cartCount = (new CartRepository())->count();

            return response()->json([
                'cartContent' => $cartContent,
                'cartCount' => $cartCount,
            ]);

        } catch (\Exception $e) {

            // Log de l'erreur pour le debug
            \Log::error('Erreur lors de la récupération du panier : '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération du panier.',
            ], 500);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Veirifie si l'ID existe dans la colonne 'id' de la table products
        $product = Product::where('id', $request->productId)->first();

        if (!$product) {
            return response()->json([
                'error' => 'Produit introuvable'
            ], 404);
        }

        $count = (new CartRepository())->add($product);

        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        (new CartRepository())->remove($id);
    }

    public function increase($id)
    {
        (new CartRepository())->increase($id);
    }

    public function decrease($id)
    {
        (new CartRepository())->decrease($id);
    }



    public function count(): \Illuminate\Http\JsonResponse
    {
        try {
            $count = (new CartRepository())->count();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Impossible de récupérer le nombre total d\'articles dans le panier !.',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }

        return response()->json([
            'count' => $count,
        ]);
    }


    /**
     * Vide tout le panier
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function clearCart(): ?\Illuminate\Http\JsonResponse
    {
        try {
            (new CartRepository())->clear(); // Méthode à créer dans ton repository pour vider le panier
            return response()->json([
                'message' => 'Le panier a été vidé !'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du panier : '.$e->getMessage());
            return response()->json([
                'message' => 'Impossible de vider le panier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
