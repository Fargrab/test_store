<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class TestProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            0 => [
                'title' => 'Мышь оптическая',
                'descriptions' => 'Оптическая мышь нового поколения супер классным быстродействием',
                'count' => 5,
                'price' => 550.99
            ],
            1 => [
                'title' => 'Клавиатура SuperJet',
                'descriptions' => 'Клавиатура с подсветкой и всякими там наворотами',
                'count' => 2,
                'price' => 700.65
            ],
        ];
        foreach ($products as $product) {
            $new_product = new Product();
            $new_product->title = $product['title'];
            $new_product->descriptions = $product['descriptions'];
            $new_product->count = $product['count'];
            $new_product->price = $product['price'];
            $new_product->save();
        }
    }
}
