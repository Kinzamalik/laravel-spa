<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {

        $results = customer::orderBy('created_at', 'desc')
            ->paginate(15);

        return response()
            ->json(['results' => $results]);

    }

    public function create()
    {
        // dd('testing');
        $form = [
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'address' => '',

        ];
        return response()
            ->json(['form' => $form]);
    }

    public function search()
    {

        $results = Customer::orderBy('firstname')
            ->when(request('q'), function ($query) {
                $query->where('firstname', 'like', '%' . request('q') . '%')
                    ->orWhere('lastname', 'like', '%' . request('q') . '%')
                    ->orWhere('email', 'like', '%' . request('q') . '%')
                    ->orWhere('address', 'like', '%' . request('q') . '%');

            })

            ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);

    }

    public function store(Request $request)
    {   
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users",
            'address' => 'required|string',

        ]);
        $customer = new Customer;
        $customer->fill($request->all());
        $customer->save();

        return response()->json(['saved' => true, 'id' => $customer->id]);

    }

    public function show($id)
    {
        $model = Customer::findOrFail($id);

        return response()
            ->json(['model' => $model]);

    }

    public function edit($id)
    {

        $model = Customer::findOrFail($id);

        return response()
            ->json(['form' => $model]);
    }

    public function update($id, Request $request)
    {

        $customer = Customer::findOrFail($id);

        $customer->fill($request->all());
        $customer->save();

        return response()
            ->json(['saved' => true, 'id' => $customer->id]);

    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->customer()->delete();

        $customer->delete();

        return response()
            ->json(['deleted' => true]);
    }

}