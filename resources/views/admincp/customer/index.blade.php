@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Auth Type</th>
                            <th scope="col">Status Register</th>
                            <th scope="col">Status</th>
                            <th scope="col">Manages</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $cus)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $cus->name }}</td>
                                <td>{{ $cus->email }}</td>
                                <td>{{ $cus->auth_type }}</td>
                                <td>
                                    @if ($cus->status_registration == 1)
                                        Có
                                    @else
                                        Không
                                    @endif
                                </td>
                                <td>
                                    <select id="{{ $cus->id }}">
                                        @if ($cus->status == 1)
                                            <option selected value="1">Active</option>
                                            <option value="0">Hidden</option>
                                        @else
                                            <option value="1">Active</option>
                                            <option selected value="0">Hidden</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['destroycustomer', $cus->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this ( ' . $cus->name . ' )?")',
                                    ]) !!}
                                   
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        <br>
                                        <br>
                                   
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
