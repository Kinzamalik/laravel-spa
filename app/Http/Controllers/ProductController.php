<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $results = Product::with(['product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()
            ->json(['results' => $results]);
    }


    public function search()
    {

        $results = Product::orderBy('item_code')
            ->when(request('q'), function ($query) {
                $query->where('item_code', 'like', '%' . request('q') . '%')
                    ->orWhere('description', 'like', '%' . request('q') . '%')
                    ->orWhere('unit_price', 'like', '%' . request('q') . '%');
            })

          ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);

    }
    public function create()
    {
        dd('hello from create');

        $form = [
            "id"=>'',
            "item_code" =>'',
            "description" => '',
            'unit_price' => '',
        ];

        return response()
            ->json(['form' => $form]);
    }

    public function store(Request $request)
    {
        

        $product = new Product;
        $product->fill($request->except('items'));

     
        return response()
            ->json(['saved' => true, 'id' => $product->id]);
    }

    public function show($id)
    {
        $model = Product::with(['customer', 'items.product'])
            ->findOrFail($id);

        return response()
            ->json(['model' => $model]);
    }

    public function edit($id)
    {
        $form = Product::with(['customer', 'items.product'])
            ->findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }

    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'sometimes|required|integer|exists:invoice_items,id,invoice_id,' . $product->id,
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $product->fill($request->except('items'));

        $product->sub_total = collect($request->items)->sum(function ($item) {
            return $item['qty'] * $item['unit_price'];
        });

        $product = DB::transaction(function () use ($product, $request) {
            // custom method from app/Helper/HasManyRelation
            $product->updateHasMany([
                'items' => $request->items,
            ]);

            return $product;
        });

        return response()
            ->json(['saved' => true, 'id' => $product->id]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->items()->delete();

        $product->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
