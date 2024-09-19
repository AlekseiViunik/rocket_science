<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Если есть фильтры по свойствам
        if ($request->has('properties')) {
            $properties = $request->input('properties');

            foreach ($properties as $propertyName => $values) {
                $query->whereHas('propertyValues.property', function ($q) use ($propertyName, $values) {
                    $q->where('name', $propertyName)
                        ->whereIn('value', $values);
                });
            }
        }

        // Получаем товары с их свойствами и пагинацией по 40 элементов
        $products = $query->with('propertyValues.property')->paginate(40);

        return response()->json($products);
    }
}
