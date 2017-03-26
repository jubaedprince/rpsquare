<style>
    h3{
        margin: 4px;
    }
</style>

<h1>Process 1 Average time: {{$average}}</h1>
<h1>Process 2 Average time: {{$average2}}</h1>
<h1>Process 3 Average time: {{$average3}}</h1>
<h1>Report: Detailed Report by Time Stamp</h1>
<h1>Date: </h1>
<h1>Time Period: </h1>
<h1>Line: #1 </h1>
<table border="1">
    <tr>
        <td><h3>Process</h3></td>
        <td><h3>Duration</h3></td>
        <td><h3>Bundle</h3></td>
    </tr>

    @foreach($entries as $entry)
        <tr>
            <td><h3>{{$entry->process_name}}</h3></td>
            <td><h3>{{$entry->time}}</h3></td>
            <td><h3>{{$entry->bundle_number}}</h3></td>
        </tr>
    @endforeach

</table>
