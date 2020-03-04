@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Edit/Update Pipe burst report</h3>

    @if (count($errors) > 0)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"><strong>Whoops!</strong> There were some problems with your input.</h4>
        
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <form method="post" action="{{ action('BurstController@update', $burst->id) }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PATCH">

        <div class="form-group">
            <label for="locationInput">Location</label>
            <input type="text" class="form-control" id="locationInput" name="location" aria-describedby="locationHelp" value="{{ $burst->location }}">
            <small id="locationHelp" class="form-text text-muted">We'll never share your location with anyone else.</small>
        </div>

        

        <div class="input-group control-group increment">
            
            <input type="file" class="form-control" id="fileInput" name="filename">
            <!-- <div class="input-group-append">
                <button class="btn btn-success" type="button">Add</button>
            </div> -->
            
            
        </div>

        <!-- <div class="clone hide">

            <div class="input-group control-group mt-2">
                
                <input type="file" class="form-control" id="fileInput" name="filename[]">
                <div class="input-group-append">
                    <button class="btn btn-danger" type="button">Remove</button>
                </div>
                
                
            </div>

        </div> -->
        
        <button type="submit" class="mt-5 btn btn-primary">Submit</button>
    </form>

</div>

<!-- <script type="text/javascript">

    $(document).ready(function() {

        $('.btn-success').click(function() {
            let html = $('.clone').html();
            $('.increment').after(html);
        });

        $('body').on('click', '.btn-danger', function() {
            $(this).parents('.control-group').remove();
        });

    });

</script> -->

@endsection