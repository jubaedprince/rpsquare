@extends('layouts.main')

<style>
    h3{
        margin: 4px;
    }
</style>
<h1>Report: Detailed Report by Time Stamp</h1>
<h1>Date: </h1>
<h1>Time Period: </h1>
<h1>Line: #1 </h1>
<table border="1">
    <tr>
        <td><h3>Process</h3></td>
        <td><h3>Bundle 1</h3></td>
        <td><h3>Bundle 2</h3></td>
        <td><h3>Bundle 3</h3></td>
        <td><h3>Bundle 4</h3></td>
    </tr>

    @foreach($entries as $key=>$process)
    <tr>
        <td><h3>{{$key}}</h3></td>
        @foreach($process as $p)
            <td><h3>{{Carbon\Carbon::parse($p->created_at)->toTimeString()}}</h3></td>
        @endforeach
    </tr>
    @endforeach

</table>