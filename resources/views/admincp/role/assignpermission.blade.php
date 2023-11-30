@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Quan Ly Role, Permission</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => 'assignPermissionsToRole', 'method' => 'POST']) !!}


                        <div class="form-group">
                            <label for="">Role</label>
                            <select style="width: 50%" class="form-control select-role" name="role">
                                @foreach ($listRole as $key => $ro)
                                    <option value="{{ $ro->id }}">{{ $ro->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Permission have in the Role</strong></label><br />
                            <select style="width: 50%" id="show_permission" class="form-control">
                                <option>---Permission:...---</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Permission:</strong></label><br />
                            <select class="selects selectpicker" id="" multiple data-live-search="true"
                                name="permissions[]">
                                @foreach ($listPermission as $key => $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach

                            </select>

                        </div>

                        {!! Form::submit('Update ', ['class' => 'btn btn-success']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Initialize the plugin: -->

    <script type="text/javascript">
        $(document).ready(function() {

            $('.selects').selectpicker();

        });
    </script>

    <script type="text/javascript">
        $('.select-role').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('select-role') }}",
                method: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#show_permission').html(data);
                }
            });
        })
    </script>
@endsection
