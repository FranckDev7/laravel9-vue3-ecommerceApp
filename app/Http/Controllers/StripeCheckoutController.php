<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Error;


class StripeCheckoutController extends Controller
{
    public function create()
    {
        return view('checkout.create');
    }

    public function paymentIntent()
    {
        try {
            $stripeSecretKey = config('stripe.test_secret_key');

            // $stripe est une instance de \Stripe\StripeClient.
            $stripe = new \Stripe\StripeClient($stripeSecretKey);

            // ⚠️ Stripe veut le montant en CENTS !!
            $cartTotal = (new CartRepository())->total();

            // Crée un objet PaymentIntent (objet avec toutes les infos du paiement.).
            // paymentIntents est une propriété magique du client Stripe qui donne accès
            // à toutes les méthodes liées aux Payment Intents (create, retrieve, update, confirm, etc.).
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $cartTotal,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'order_items' => (string)(new CartRepository())->jsonOrderItems()
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Erreurs Stripe
            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            // Autres erreurs PHP
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function success(Request $request)
    {
        $stripeSecretKey = config('stripe.test_secret_key');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        // Récupère le client_secret passé par Stripe dans l'URL
        $clientSecret = $request->query('payment_intent_client_secret');


        if (!$clientSecret) {
            return view('checkout.success')->with([
                'status' => 'error',
                'message' => 'Aucun PaymentIntent fourni.'
            ]);
        }

        try {
            // Récupère le PaymentIntent via le client secret
            $paymentIntent = $stripe->paymentIntents->retrieve(
                $request->query('payment_intent')
            );

            // Vérifie le statut du paiement
            $status = $paymentIntent->status; // 'succeeded', 'processing', 'requires_payment_method', etc.

            return view('checkout.success')->with([
                'status' => $status,
                'message' => match ($status) { // fonction match : fonctionne un peu comme un switch, mais avec des différences importantes
                    'succeeded' => 'Paiement réussi ! ',
                    'processing' => 'Paiement en cours…',
                    'requires_payment_method' => 'Paiement échoué. Veuillez réessayer.',
                    default => 'Statut du paiement : ' . $status,
                }
            ]);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return view('checkout.success')->with([
                'status' => 'error',
                'message' => 'Erreur Stripe : ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return view('checkout.success')->with([
                'status' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }

    }


}
