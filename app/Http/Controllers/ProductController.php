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

        $products = $query->with('propertyValues.property')->paginate(40);

        $customResponse = $products->getCollection()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'properties' => $product->propertyValues->map(function ($propertyValue) {
                    return [
                        'property_name' => $propertyValue->property->name,
                        'value' => $propertyValue->value,
                    ];
                }),
            ];
        });

        return response()->json([
            'products' => $customResponse,
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'first_page_url' => $products->url(1),
            'last_page_url' => $products->url($products->lastPage()),
            'next_page_url' => $products->nextPageUrl(),
            'prev_page_url' => $products->previousPageUrl(),
        ]);
    }
}
