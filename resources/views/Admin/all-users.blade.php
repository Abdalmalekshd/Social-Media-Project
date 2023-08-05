@extends('Admin.layout.adminMaster')

@section('content')
  
<div class="col-md-9 col-lg-10 main">

    <h1 class="display-2 hidden-xs-down text-center">
        Users
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
        <div class="card card-inverse card-success">
          <div class="card-block bg-success">
            <div class="rotate">
              <i class="fa fa-user fa-5x"></i>
            </div>
            <h6 class="text-uppercase">Total Users</h6>
            <h1 class="display-1 text-center">{{ $users }}</h1>
          </div>
        </div>
      </div>

        <div class="col-lg-3 col-md-4">
        <div class="card">
        <div class="card-header text-white bg-primary text-center">New Users Today</div>
        <div class="card-block">
            <h4 class="card-title text-center">
            {{ $users_per_day}}
            
            </h4>
        </div>
        </div>
        

        </div>
    </div>
    <!--/row-->
    
    <hr>
    
    
<div id="success_msg" class="alert alert-danger text-center userdel"  style="display: none;">
  User Deleted Successfully
</div>

    <div class="row mb-3">
      <div class="col-lg-12 col-md-12">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead class="thead-inverse">
              <tr>
                  
                <th class="text-center">Avatar</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Phone</th>
                <th class="text-center">Joined At</th>
                <th class="text-center">Posts Number</th>
                <th class="text-center">Comments Number</th>
                <th class="text-center">Followers Number</th>
                <th class="text-center">Following Number</th>
                <th class="text-center">Operation</th>

              </tr>
            </thead>
            <tbody>
                @foreach ($all_users as $user)

                <tr>
                <td>
                @if (!$user->avatar)
                <img src="{{ url('img.png') }}" alt="{{ $user->avatar }}" class="rounded-circle" style="width:50px;height:50px">
                
                @else
                <img src="{{ url('Images/Avatar/',$user->avatar) }}" alt="" class="rounded-circle" style="width:50px;height:50px">

                @endif
                </td>
                <td class="text-center">{{ $user->name }}</td>
                <td class="text-center">{{ $user->email }}</td>
                <td class="text-center">{{ $user->phone }}</td>
                <td class="text-center">{{ $user->created_at }}</td>
                <td class="text-center">{{ $user->post_count }}</td>
                <td class="text-center">{{ $user->comments_count }}</td>
                <td class="text-center">{{ $user->followers_count }}</td>
                <td class="text-center">{{ $user->follow_count }}</td>
                <td class="text-center"><button  class="btn btn-danger deleteuser" user_id='{{ $user->id }}'>Delete</button></td>

            </tr>
            @endforeach
            
            </tbody>
            
            </table>

        </div>
        <div class="paginatelink">
            {{ $all_users->links() }}
        </div>
        </div>
    </div>


    </div>
    <!--/main col-->
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
  $(document).on('click','.deleteuser',function(e){
      e.preventDefault();

      let UserId=$(this).attr('user_id');
      
  $.ajax({
      type: 'post',
      url: "{{ route('dlt.user') }}",
      data: {
          '_token':"{{csrf_token()}}",
          'id':UserId
      },
      success: function (data) {

          if (data.status == true) {

              $('#success_msg').show();
          }
          $('.userdel'+data.id).remove();
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