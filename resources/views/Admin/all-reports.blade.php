@extends('Admin.layout.adminMaster')

@section('content')
  
<div class="col-md-9 col-lg-10 main">

    <h1 class="display-2 hidden-xs-down text-center">
        Reports
        </h1>
    <br>
    <div class="alert alert-warning fade collapse" role="alert" id="myAlert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
      <strong>Holy guacamole!</strong> It's free.. this is an example theme.
    </div>

    <div class="row mb-3">
      <div class="col-xl-3 col-lg-6">
        <div class="card card-inverse card-success">
          <div class="card-block bg-success">
            <div class="rotate">
              <i class="fa fa-share fa-5x"></i>
            </div>
            <h6 class="text-uppercase">Total Reports</h6>
            <h1 class="display-1 text-center">{{ $reports }}</h1>
          </div>
        </div>


        
      </div>

      
      <div class="col-lg-3 col-md-4">
        <div class="card">
        <div class="card-header text-white bg-primary text-center">New Reports Today</div>
        <div class="card-block">
            <h4 class="card-title text-center">
              {{ $reports_per_day}}
  
            </h4>
        </div>
        </div>
        
      </div>
    </div>
      
    
    
    <hr>


    <div id="success_msg" class="alert alert-danger text-center reportdel" style="display: none;">
      Report Deleted Successfully
    </div>

    <div class="row mb-3">

    
    <div class="col-lg-12 col-md-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-inverse">
            <tr>
                
              <th class="text-center">Reason</th>
              <th class="text-center">Post</th>
              <th class="text-center">User</th>
              <th class="text-center">Comment</th>
              <th class="text-center">Created_at</th>
              <th class="text-center">User Who Submitted Report</th>
              <th class="text-center">Operation</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($all_reports as $report)

            <tr>
              <td class="text-center">
                {{ $report->reason }}
            </td>
            
              @if(isset($report->post->content))
              <td class="text-center">{{ $report->post->content }}</td>
              @else
              <td class="text-center">Null</td>

              @endif

              @if(isset( $report->user_reported->name))
              <td class="text-center">{{ $report->user_reported->name }}</td>
              @else
              <td class="text-center">Null</td>

              @endif

              @if(isset( $report->comment->comment ))

              <td class="text-center">{{ $report->comment->comment }}</td>
              @else
              <td class="text-center">Null</td>

              @endif

              <td class="text-center">{{ $report->created_at }}</td> 
              
              <td class="text-center">{{ $report->userwhoreported->name }}</td> 
              
              <td class="text-center"><button  report_id='{{ $report->id }}' class="btn btn-danger deletereport">Delete</button></td>


            </tr>
            @endforeach
            
          </tbody>
          
        </table>
        
      </div>
    </div>

    

  </div>
    

      
    <div class="paginatelink">
      {{ $all_reports->links() }}
  </div>
  </div>


  <style>
    .paginatelink nav{
        margin-top: 20px;
        margin-left: 400px;
        padding: 10px;
    }

    .paginatelink nav a{
        width: 100px;
    margin-left: 100px;
    text-decoration: none;
    padding: 5px;

    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
  $(document).on('click','.deletereport',function(e){
      e.preventDefault();

      let ReportId=$(this).attr('report_id');
      
  $.ajax({
      type: 'post',
      url: "{{ route('dlt.report') }}",
      data: {
          '_token':"{{csrf_token()}}",
          'id':ReportId
      },
      success: function (data) {

          if (data.status == true) {

              $('#success_msg').show();
          }
          $('.reportdel'+data.id).remove();
      },
      
      error: function (reject) {
          var response = $.parseJSON(reject.responseText);
          $.each(response.errors, function (key, val) {
              $("#" + key + "_error").text(val[0]);
          });
      }
  });
});
</script>

  @endsection