@extends('Admin.layout.adminMaster')

@section('content')
  
<div class="col-md-9 col-lg-10 main">

    <h1 class="display-2 hidden-xs-down text-center">
        Comments
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
      
      <div class="col-xl-3 col-lg-6" style="margin-left: 200px">
        <div class="card card-inverse card-info">
          <div class="card-block bg-info">
            <div class="rotate">
              <i class="fa fa-comments fa-5x"></i>
            </div>
            <h6 class="text-uppercase">Total Comments</h6>
            <h1 class="display-1 text-center">{{ $comments }}</h1>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="card">
        <div class="card-header text-white bg-primary text-center">New Comments Today</div>
        <div class="card-block">
            <h4 class="card-title text-center">
              {{ $comments_per_day}}
              
            </h4>
        </div>
        </div>
        
      </div>
    </div>
    
    <hr>
  

    <div id="success_msg" class="alert alert-danger text-center commentdel" style="display: none;">
      Comment Deleted Successfully
    </div>


    <div class="col-lg-12 col-md-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-inverse">
            <tr>
                
              <th class="text-center">Content</th>
              <th class="text-center">Parent</th>
              <th class="text-center">Post</th>
              <th class="text-center">User</th>
              <th class="text-center">Operation</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($all_comments as $comment)

            <tr>
              <td class="text-center">
                {{ $comment->comment }}
            </td>
            <td class="text-center"></td>

              <td class="text-center">{{ $comment->post->content }}</td>
              <td class="text-center">{{ $comment->user->name }}</td>
              <td class="text-center"><button  comment_id='{{ $comment->id }}' class="btn btn-danger deletecomment">Delete</button></td>

              
            </tr>
            @endforeach
            
          </tbody>
          
        </table>
        
      </div>

      <div class="paginatelink">
        {{ $all_comments->links() }}
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
    

    

    
    
    </div>


  </div>
  <!--/main col-->
</div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
  $(document).on('click','.deletecomment',function(e){
      e.preventDefault();

      let CommentId=$(this).attr('comment_id');
      
  $.ajax({
      type: 'post',
      url: "{{ route('dlt.comment') }}",
      data: {
          '_token':"{{csrf_token()}}",
          'id':CommentId
      },
      success: function (data) {

          if (data.status == true) {

              $('#success_msg').show();
          }
          $('.commentdel'+data.id).remove();
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