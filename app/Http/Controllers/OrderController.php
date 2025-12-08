<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    // METHODE MAGIQUE QUI SERA EXECUTE LORSQUE LA CLASSE SERA INSTENCIEE ET QUE
    // L'INSTANCE SERA APPELEE COMME UNE FONCTION
    public function __invoke()
    {
        // auth()->user()->orders() : retourne une relation HasMany (Illuminate\Database\Eloquent\Relations\HasMany)
        // auth()->user()->orders()->create([]) :
        //   - Laravel crée un nouvel objet Order avec les attributs fournis.
        //   - Laravel associe automatiquement la clé étrangère user_id de Order
        //     à l’utilisateur courant (auth()->user()->id).
        //     ensuite sauvegarde cet objet dans la table orders.
        //     et retourne l’instance du modèle Order créé.
        $order = auth()->user()->orders()->create([
            'order_number' => uniqid('', true)
        ]);

        // products() est une relation BelongsToMany entre Order et Product.
        // Quand on appelle attach($productId, $pivotData) : Laravel insère une ligne dans la table pivot
        // order_product avec order_id, product_id et les colonnes supplémentaires (total_price, total_quantity).
        (new CartRepository())
            ->content()
            ->each(function ($product) use ($order) {
                $order->products()->attach($product->id , [ // Attache les produits du panier à la commande
                    'total_price' => $product->price * $product->quantity,
                    'total_quantity' => $product->quantity
                ]);
            });

        (new CartRepository())->clear();
    }
}
