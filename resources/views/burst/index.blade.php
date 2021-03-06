@extends('layouts.app')

@section('content')

@if(session('success'))
   <div class="alert alert-success" role="alert">
      {{ session('success') }}

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
   </div> 
 @endif

<section class="jumbotron text-center mt-0">
    <div class="container">
      <h1>Water Bursts </h1>
      <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
      <p>
        <a href="/bursts/create" class="btn btn-primary my-2">Upload Complaint</a>
      </p>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
        @foreach($reports as $report)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="{{asset($report->filename)}}" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">{{$report->location}}</p>
              <div class="d-flex justify-content-between align-items-center">
                @if($report->canUpdate(Auth::user()))
                <form class="btn-group" action="{{ action('BurstController@destroy', $report->id) }}" method="POST">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <a href="/bursts/{{$report->id}}/edit/" role="button" class="btn btn-sm btn-outline-success">Edit</a>
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
                @endif
                <small class="text-muted">{{$report->created_at->diffForHumans()}}</small>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        

        
      </div>
    </div>
  </div>

@endsection