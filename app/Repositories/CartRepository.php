<?php

namespace App\Repositories;

use App\Models\Product;
use Darryldecode\Cart\Exceptions\InvalidItemException;

class CartRepository
{
    /**
     * Ajoute un article dans le panier
     * \ : Indique que Cart est utilisé depuis le namespace global.
     * Sans le \, PHP chercherait Cart dans le namespace courant (App\Repositories) et ne le trouverait pas.
     * Méthode session() de la librairie Cart pour créer/choisir un panier spécifique à l’utilisateur.
     *
     * Méthode add() ajoute un produit au panier, prenant en argument un tableau associatif décrivant
     * le produit et ses propriétés.
     *
     * attributes : Un tableau pour stocker toutes les informations supplémentaires du produit,
     * par exemple la couleur, la taille ou tout autre attribut du produit.
     *
     */
    public function add(Product $product)
    {
        try {
            \Cart::session(auth()->user()->id)->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'description' => $product->description,
                    'hold_price' => $product->hold_price,
                ],
                'associatedModel' => $product,
            ]);

            return $this->count();

        } catch (\Exception $e) {

            // Log de l’erreur (très bon pour débug)
            \Log::error("Erreur lors de l'ajout au panier : " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'product_id' => $product->id,
            ]);

            return 0;
        }
    }



    /**
     * Récupère le contenu du panier
     */
    public function content(): \Darryldecode\Cart\CartCollection
    {
        try {
            return \Cart::session(auth()->user()->id)->getContent();
        } catch (\Exception $e) {

            // Optionnel mais recommandé : log de l’erreur
            \Log::error('Erreur lors de la récupération du panier : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Retourne un CartCollection vide
            return new \Darryldecode\Cart\CartCollection([]);
        }
    }

    // Récupère le nombre total d'articles dans le panier
    public function count()
    {
        try {
            return $this->content()->sum('quantity');

        } catch (\Exception $e) {

            \Log::error("Erreur lors du comptage du panier : " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Tu décides quoi retourner ici : 0 est la valeur la plus logique
            return 0;
        }
    }

    /**
     * Augmente la quantité d'un article dans le panier
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function increase($id): \Illuminate\Http\JsonResponse
    {
        try {
            \Cart::session(auth()->user()->id)
                ->update($id, [
                    'quantity' => +1,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantité augmentée avec succès.',
            ]);

        } catch (\Exception $e) {

            // 🔥 Log de l'erreur pour déboguer
            \Log::error('Erreur lors de l\'augmentation de la quantité : '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du panier.',
                'error' => $e->getMessage(), // optionnel : enlever en production
            ], 500);
        }
    }


    /**
     * Diminue la quantité d'un article dans le panier
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrease($id): \Illuminate\Http\JsonResponse
    {
        try {
            $cart = \Cart::session(auth()->id()); // panier
            $item = $cart->get($id); // article

            // Vérifie que l'article existe
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produit introuvable dans le panier.',
                ], 404);
            }

            // Si la quantité vaut 1, on supprime l'article
            if ($item->quantity === 1) {
                $this->remove($id);

                return response()->json([
                    'success' => true,
                    'message' => 'Produit supprimé du panier.',
                ]);
            }

            // Sinon on décrémente de 1
            $cart->update($id, [
                'quantity' => -1, // La librairie interprète -1 comme "décrémenter"
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantité diminuée avec succès.',
            ]);

        } catch (\Exception $e) {
            // Log de l'erreur
            \Log::error('Erreur lors de la diminution du panier : '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne lors de la mise à jour du panier.',
            ], 500);
        }
    }


    /**
     * Supprime l'article dans le panier
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id): \Illuminate\Http\JsonResponse
    {
        try {
            $cart = \Cart::session(auth()->id());
            $item = $cart->get($id);

            // Vérifie que l'article existe
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produit introuvable dans le panier.',
                ], 404);
            }

            $cart->remove($id);

            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé du panier.',
            ]);

        } catch (\Exception $e) {
            // Log de l'erreur
            \Log::error('Erreur lors de la suppression du produit du panier : '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne lors de la suppression du produit.',
            ], 500);
        }
    }


    /**
     * Vide tout le panier et retourne un boolean pour signifier que l'opération s'est bien passée
     * @return bool
     */
    public function clear(): bool
    {
        try {
            \Cart::session(auth()->user()->id)->clear();
            return true; // succès
        } catch (\Exception $e) {
            // Log l'erreur pour le debug
            \Log::error('Erreur lors de la suppression du panier : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return false; // échec
        }
    }

    // TOTAL DE LA COMMANDE
    public function total()
    {
        try {
            return \Cart::session(auth()->id())->getTotal();

        } catch (\Exception $e) {

            // Log de l'erreur pour le débogage
            \Log::error('Erreur lors du calcul du total du panier : '.$e->getMessage(), [
                'user_id' => auth()->id(),
            ]);

            // Valeur par défaut si erreur
            return 0;
        }
    }

    // RETOURNE LE CONTENU DU PANIER (COMMANDE) EN FORMAT JSON
    public function jsonOrderItems()
    {
        return $this
            ->content()
            ->map(function ($item) {
                return [
                  'name' => $item->name,
                  'quantity' => $item->quantity,
                  'price' => $item->price,
                ];
            })
            ->toJson();
    }







}
