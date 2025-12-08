<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        // Prix actuel
        $price = random_int(1000, 15000);

        // Prix barré (hold_price) légèrement supérieur au prix actuel
        $holdPrice = $price + random_int(500, 5000);

        // Tableau contenant uniquement des URLs Amazon VALIDES
        // Chaque image sera choisie aléatoirement
        $amazonImages = [
            "https://m.media-amazon.com/images/I/817z+CW86XL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/81KhifuX3rL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61hfaenFu1L._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/517qtTD35dL._AC_UL480_FMwebp_QL65_.jpg",

            "https://m.media-amazon.com/images/I/71dciCzKAML._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61GiukzmG9L._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/81EC+sfEghL._AC_UL480_FMwebp_QL65_.jpg",

            "https://m.media-amazon.com/images/I/71pHQAb9m8L._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61Yqhpg-YSL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/71t2Kcy50jL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/412oPOjI4nL._AC_UL480_FMwebp_QL65_.jpg",

            "https://m.media-amazon.com/images/I/61B2y95e7BL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/71bSlh6CJGL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61DECuvqL4L._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61jLtxc889L._AC_UL480_FMwebp_QL65_.jpg",

            "https://m.media-amazon.com/images/I/61F+dxVyQeL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61hp+vAcZXL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/51ZTTeFKqzL._AC_UL480_FMwebp_QL65_.jpg",
            "https://m.media-amazon.com/images/I/61JyQaofUeL._AC_UL480_FMwebp_QL65_.jpg",
        ];

        // Sélection aléatoire d'une image Amazon valide
        $imageUrl = $amazonImages[array_rand($amazonImages)];

        return [
            // Nom du produit généré aléatoirement
            'name' => $this->faker->sentence(2),

            // Description du produit générée aléatoirement
            'description' => $this->faker->paragraph(3, false),

            // URL de l'image du produit
            'image' => $imageUrl,

            // Prix actuel
            'price' => $price,

            // Prix barré
            'hold_price' => $holdPrice,

            // Produit actif ou non (80% de chance d'être actif)
            'active' => $this->faker->boolean(80),
        ];
    }
}
