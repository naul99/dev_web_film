@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <h4>Manage Role</h4>
            </div>
            <div class="col-md-12">
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name Role</th>
                            <th scope="col">Manages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listRole as $key => $role)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $role->name }}</td>
                               
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['role.destroy', $role->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this ( '.$role->name.' )?")',
                                    ]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger','disabled']) !!}
                                    <br>
                                    <br>
                                    {!! Form::close() !!}
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-warning">Update</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <h4>Manage Permission</h4>
            </div>
            <div class="col-md-12">
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name Permission</th>
                            <th scope="col">Manages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listPermission as $key => $per)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $per->name }}</td>
                               
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['role.destroy', $per->id],
                                        'onsubmit' => 'return confirm("Are you sure you want to delete this ( '.$per->name.' )?")',
                                    ]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger','disabled']) !!}
                                    <br>
                                    <br>
                                    {!! Form::close() !!}
                                    {{-- <a href="{{ route('role.edit', $per->id) }}" class="btn btn-warning">Update</a> --}}
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection
