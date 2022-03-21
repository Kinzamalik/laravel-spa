<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Counter;
use DB;

class InvoiceController extends Controller
{

    public function index()
    {
        $results = Invoice::with(['customer'])
            ->orderBy('created_at','desc')
            ->paginate(15);



            return response()
                ->json(['results' => $results]);
    }

    public function create()
    {
        $counter = Counter::where('key','invoice')->first();

        $form =[
            'number' => $counter->prefix . $counter->value,
            'customer_id' => null,
            'date' =>null,
            'due_date'=> null,
            'reference' =>null,
            'discount' => 0,
            'term_and_conditions' 
        ]
    }
    
}
