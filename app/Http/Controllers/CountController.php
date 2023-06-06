<?php

namespace App\Http\Controllers;

use App\Models\Counts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CountController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table note
        $count = Counts::all();

        //make response JSON
        return response()->json($count, 200);

    }

}
