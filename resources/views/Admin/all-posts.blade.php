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
              <i class="fa fa-share fa-5x"></i>
            </div>
            <h6 class="text-uppercase">Total Posts</h6>
            <h1 class="display-1 text-center">{{ $posts }}</h1>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="card">
        <div class="card-header text-white bg-primary text-center">New Posts Today</div>
        <div class="card-block">
            <h4 class="card-title text-center">
              {{ $posts_per_day}}
              
            </h4>
        </div>
        </div>
        
      </div>
    </div>
    
    <hr>
  

    <div id="success_msg" class="alert alert-danger text-center postdel" style="display: none;">
      Post Deleted Successfully
    </div>
  
    <div class="col-lg-12 col-md-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-inverse">
            <tr>
                
              <th class="text-center">Content</th>
              <th class="text-center">Image</th>
              <th class="text-center">User</th>
              <th class="text-center">Images Number</th>
              <th class="text-center">Likes Number</th>
              <th class="text-center">Comments Number</th>
              <th class="text-center">Reports Number</th>
              <th class="text-center">Operation</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($all_posts as $post)

            <tr>
              <td>
                {{ $post->content }}
            </td>
            @forelse ($post->images as $img)
              <td>
      <img src="{{ url('Images/Posts/',$img->photo) }}" alt=""  style="width:40px;height:40px">
              </td>
                
            @empty
        
                
            @endforelse
            <td>{{ $post->user->name }}</td>
              <td>{{ $post->images_count }}</td>
              <td>{{ $post->comments_count }}</td>
              <td>{{ $post->like_count }}</td>
              <td>{{ $post->reports_count }}</td>
              
              <td class="text-center"><button  post_id='{{ $post->id }}' class="btn btn-danger deletepost">Delete</button></td>


            </tr>
            @endforeach
            
          </tbody>
          
        </table>
        
        <div class="paginatelink">
          {{ $all_posts->links() }}
      </div>
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
  
</div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
  $(document).on('click','.deletepost',function(e){
      e.preventDefault();

      let PostId=$(this).attr('post_id');
      
  $.ajax({
      type: 'post',
      url: "{{ route('dlt.post') }}",
      data: {
          '_token':"{{csrf_token()}}",
          'id':PostId
      },
      success: function (data) {

          if (data.status == true) {

              $('#success_msg').show();
          }
          $('.postdel'+data.id).remove();
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