@extends('layouts.main')

@section('page_content')




<style>
    h3{
        margin: 4px;
    }
</style>

<table class="table  table-bordered table-hover">

    <tr>
        @foreach($header as $h)
            <td>{{$h}}</td>
        @endforeach

    </tr>


    <tbody>
    @foreach($data as $key=>$value)
        <tr>
            <td>{{$key}}</td>
            <td>{{$value['actual_quantity']}}</td>
            <td>{{$value['target_quantity']}}</td>
            <td>{{$value['efficiency']}}</td>
            <td>{{$value['average']}}</td>
        </tr>
    @endforeach

    </tbody>


</table>
@endsection

