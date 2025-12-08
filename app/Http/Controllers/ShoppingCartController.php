<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    // __invoke() : méthode magique en PHP qui permet à une instance de classe d'être "appelable" comme une fonction.
    // et après l'appel cette dernière avec des parenthèses () cela va automatiquement exécuter la méthode __invoke().
    public function __invoke()
    {
        return view('cart.index');
    }
}
