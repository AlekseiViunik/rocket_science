<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Property;
use App\Models\ProductPropertyValue;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            'Цвет' => Property::firstOrCreate(['name' => 'Цвет']),
            'Бренд' => Property::firstOrCreate(['name' => 'Бренд']),
            'Размер' => Property::firstOrCreate(['name' => 'Размер']),
        ];
        $products = ['Настольная лампа', 'Напольная лампа', 'Люстра'];
        $colorValues = ['Белый', 'Черный', 'Серый', 'Красный', 'Синий'];
        $brandValues = ['Rev', 'Baga', 'ArtPole', 'Eglo', 'Palma'];
        $sizeValues = ['Небольшой', 'Средний', 'Большой'];

        for ($i = 1; $i <= 100; $i++) {
            // Генерация случайных значений
            $productName = $products[array_rand($products)];
            $colorValue = $colorValues[array_rand($colorValues)];
            $brandValue = $brandValues[array_rand($brandValues)];
            $sizeValue = $sizeValues[array_rand($sizeValues)];

            $sku = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

            $model = strtoupper(Str::substr($brandValue, 0, 2)) . rand(1000, 9999);

            $price = rand(1, 100) * 100;
            $quantity = rand(1, 10);

            // Создаем товар
            $product = Product::create([
                'name' => $productName,
                'price' => $price,
                'quantity' => $quantity,
                'sku' => $sku,
                'model' => $model
            ]);

            // Привязываем значения свойств к товару
            ProductPropertyValue::create([
                'product_id' => $product->id,
                'property_id' => $properties['Цвет']->id,
                'value' => $colorValue
            ]);

            ProductPropertyValue::create([
                'product_id' => $product->id,
                'property_id' => $properties['Бренд']->id,
                'value' => $brandValue
            ]);

            ProductPropertyValue::create([
                'product_id' => $product->id,
                'property_id' => $properties['Размер']->id,
                'value' => $sizeValue
            ]);
        }
    }
}
