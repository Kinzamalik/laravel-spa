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
        // dd('hello from create');

        $results = product::orderBy('created_at', 'desc')
            ->paginate(15);

        return response()
            ->json(['results' => $results]);
    }


    public function create()
    {

        $form = [
            "item_code" =>'',
            "description" => '',
            'unit_price' => '',
        ];

        return response()
            ->json(['form' => $form]);
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


    public function store(Request $request)
    {
        dd('store')

        $product = new Product;
        $product->fill($request->all());
        $product->save();

     
        return response() ->json(['saved' => true, 'id' => $product->id]);
    }

    public function show($id)
    {
        $model = Product::findOrFail($id);

        return response()
            ->json(['model' => $model]);
    }

    public function edit($id)
    {
        $model = Product::with(['product', 'product.product'])
            ->findOrFail($id);

        return response()
            ->json(['form' => $model]);
    }

    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $product->fill($request->except('product'));
        $product->save();

            return response()
                ->json(['saved' => true, 'id' => $product->id]);

        }

    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->product()->delete();

        $product->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
