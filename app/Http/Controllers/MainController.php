<?php

namespace App\Http\Controllers;


use App\Entry;
use App\Bundle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Application;
use Illuminate\Support\Facades\Validator;

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

        $previous_entry = Entry::where('process_name', $request->name)->get()->last();
//        dd($previous_entry);
        if($previous_entry){
            $current_entry = Entry::create([
                'process_name' => $request->name
            ]);

            $current_entry->bundle_number = $previous_entry->bundle_number + 1;
            $current_entry->save();
            $startTime = Carbon::parse($current_entry->created_at);
            $finishTime = Carbon::parse($previous_entry->created_at);
            $previous_entry->time = $finishTime->diffInSeconds($startTime);
            $previous_entry->save();
        }else{
            Entry::create([
                'process_name' => $request->name,
                'bundle_number' => 1
            ]);

        }


        return response(['success'=> true]);
    }

    public function showRecords()
    {
        $entries = Entry::all();

        return response(['data'=> $entries]);
    }

    public function showRecordsSorted()
    {
        $entries = Entry::all()->groupBy('process_name');

        return view('table', compact('entries'));
    }

    public function time()
    {
        $entries = Entry::all();//->groupBy('process_name');

        $process_one = Entry::where('process_name','p1')->whereNotNull('time')->get();

        $p1_time = 0;

        foreach ($process_one as $p){
            $p1_time = $p1_time+$p->time;
        }

        $p1_average = $p1_time/count($process_one);

        $process_two = Entry::where('process_name','p2')->whereNotNull('time')->get();

        $p2_time = 0;

        foreach ($process_two as $p){
            $p2_time = $p2_time+$p->time;
        }

        $p2_average = $p2_time/count($process_two);


        $process_three = Entry::where('process_name','p3')->whereNotNull('time')->get();

        $p3_time = 0;

        foreach ($process_three as $p){
            $p3_time = $p3_time+$p->time;
        }

        $p3_average = $p3_time/count($process_three);

        return view('log')->with('entries', $entries)->with('average', $p1_average)->with('average2', $p2_average)->with('average3', $p3_average);


    }

    public function startProcessForm()
    {
        return view('start_process');
    }

    public function processStartProcess(Request $request)
    {
        Bundle::create([
            'quantity'=> $request->quantity,
            'finished_quantity'=> 0
        ]);

        return redirect('/');
    }

    public function endProcessForm()
    {
        return view('end_process');
    }

    public function processEndProcess(Request $request)
    {
        $bundle = Bundle::latest()->first();
        $bundle->end_time = Carbon::now();
        $bundle->finished_quantity = $request->quantity;
        $bundle->save();
        return redirect('/');
    }

    public function report()
    {
        $entries = Entry::all();//->groupBy('process_name');

        $process_one = Entry::where('process_name','p1')->whereNotNull('time')->get();

        $p1_time = 0;

        foreach ($process_one as $p){
            $p1_time = $p1_time+$p->time;
        }

        $p1_average = $p1_time/count($process_one);
        $p1_quantity = count($process_one);

        $process_two = Entry::where('process_name','p2')->whereNotNull('time')->get();

        $p2_time = 0;

        foreach ($process_two as $p){
            $p2_time = $p2_time+$p->time;
        }

        $p2_average = $p2_time/count($process_two);
        $p2_quantity = count($process_two);


        $process_three = Entry::where('process_name','p3')->whereNotNull('time')->get();

        $p3_time = 0;

        foreach ($process_three as $p){
            $p3_time = $p3_time+$p->time;
        }

        $p3_average = $p3_time/count($process_three);
        $p3_quantity = count($process_three);

        $header = ['Process','Actual Quantity', 'Target Quantity' , 'Efficiency', 'Average'];

        $data = [
            'p1' => [
                'actual_quantity' => $p1_quantity,
                'target_quantity' => env('P1_TARGET', 0),
                'efficiency' => 0,
                'average' => $p1_average,
            ],
            'p2' => [
                'actual_quantity' => $p2_quantity,
                'target_quantity' => env('P2_TARGET', 0),
                'efficiency' => 0,
                'average' => $p2_average,
            ],
            'p3' => [
                'actual_quantity' => $p3_quantity,
                'target_quantity' => env('P3_TARGET', 0),
                'efficiency' => 0,
                'average' => $p3_average,
            ],
        ];

        return view('report', compact('data', 'header'));
    }

}
