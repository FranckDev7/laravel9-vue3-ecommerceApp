<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws RandomException
     */
    public function run(): void
    {
        User::factory()
            ->count(10) // Créer 10 utilisateurs
            ->has(
                Order::factory()
                    ->count(3) // À chaque utilisateur, on ajoute 3 commandes
                    ->hasAttached(
                        Product::factory()->count(5), // À chaque commande, on attache 5 produits dans la table pivot order_product
                        fn () => [ // pour chaque produit attaché, on ajoute les colonnes du pivot, fn : permet de générer des valeurs pivot différentes pour chaque attachement
                            'total_price' => random_int(100, 500),
                            'total_quantity' => random_int(1, 3),
                        ]
                    )
            )
            ->create();
    }

}
