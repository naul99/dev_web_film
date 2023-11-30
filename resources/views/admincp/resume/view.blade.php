@extends('layouts.app')

@section('content')
   
        {{-- <object data="/assets/{{ $data->file }}" type="application/pdf" width="100%" height="500px">
            <p>Unable to display PDF file. <a href="/assets/{{ $data->file }}">Download</a> instead.</p>
          </object> --}}
          <iframe style="width:100%; height:600px" src="/assets/{{ $data->file }}" frameborder="0"></iframe>
   
@endsection