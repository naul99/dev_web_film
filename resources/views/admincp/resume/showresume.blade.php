@extends('layouts.app')

@section('content')
    <div class="container">
        <table border="1">
            <tr>
                <th>Name</th>
                <th>View</th>
                <th>Download</th>
            </tr>
            @foreach ($data as $data)
                <tr>
                    <th>{{ $data->name }}</th>
                    <th><a href="{{ url('admin/view-resume',$data->id) }}">View</a></th>
                    <th><a href="{{ url('admin/download',$data->file) }}">Download</a></th>

                </tr>
            @endforeach
        </table>



    </div>
@endsection
