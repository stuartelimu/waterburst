<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<head>
</head>
<body>
  <h1>Monthly Report: <?php $month = date('m'); echo date("F", strtotime(date("Y")."-".$month."-01")); ?></h1>
 

  <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Location</th>
                <th>Status</th>
                <th>Date</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report) 
            <tr>
                
                <td>{{$loop->iteration}}</td>
                
                <td>{{$report->user->name}}</td>
                <td>{{$report->location}}</td>
                <td>
                @if($report->status) Resolved @else Unresolved @endif
                </td>
                <td>{{$report->created_at->toDateString()}}</td>
                
            </tr>
            @endforeach
        
        </tbody>
    </table>

</body>

</html>