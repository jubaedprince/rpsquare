<?php

namespace App\Http\Controllers;


use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Application;

class MainController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(Application $app)
    {
        return $app->version();
    }

    public function record(Request $request)
    {
        $validator = Validator::make($request->all(), ['name'=> 'required']);

        if($validator->fails())
        {
            return response(['success'=>false, 'error' => $validator->errors()]);
        }

        Entry::create([
            'process_name' => $request->name
        ]);

        return response(['success'=> true]);
    }

    public function showRecords()
    {
        $entries = Entry::all();

        return response(['data'=> $entries]);
    }
}
