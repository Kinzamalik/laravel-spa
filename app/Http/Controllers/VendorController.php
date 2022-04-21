<?php

namespace App\Http\Controllers;

use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {

        $results = Vendor::orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json(['results' => $results]);
        //  dd('vendor');

    }

    public function create()
    {

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
        $vendor = new Vendor;
        $vendor->fill($request->all());
        $vendor->save();

        return response()->json(['saved' => true, 'id' => $vendor->id]);
    }

    public function show($id)
    {
        $model = Vendor::findOrFail($id);
        return response()
            ->json(['model' => $model]);

    }

    public function edit($id)
    {
       
        $model = Vendor::findOrFail($id);

        return response()
            ->json(['form' => $model]);
    }

    public function update($id, Request $request)

    {
        $vendor = Vendor::findOrFail($id);
        $vendor->fill($request->all());
        $vendor->save();

        return response()
            ->json(['saved'=> true, 'id' => $vendor->id]);
    }

    public function destroy($id)
    {
        dd('dd');
        $vendor = Vendor::findOrFail($id);
        $vendor->vendor()->delete();
        $vendor->delete();

        return delete();

        return response()
            ->json(['deleted' => true]);
    }

}
