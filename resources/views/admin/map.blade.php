@extends('layouts.app')

@section('content')

<div class="container">
    {!! $map['html'] !!}
</div>


{!! $map['js'] !!}

@endsection