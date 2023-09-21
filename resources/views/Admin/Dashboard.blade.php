@extends('Admin.layout.adminMaster')

@section('content')
  <?php
    $search='';
  ?>

<div class="col-md-9 col-lg-10 main">

    <h1 class="display-2 hidden-xs-down text-center">
        Social Media Project
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
              <i class="fa fa-user fa-5x"></i>
            </div>
            <h6 class="text-uppercase text-center">Total Users</h6>
            <h1 class="display-1 text-center"><a href="{{ route('all.users') }}" style="color: white;">{{ $users }}</a></h1>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-inverse card-danger">
          <div class="card-block bg-danger">
            <div class="rotate">
              <i class="fa fa-twitter fa-4x"></i>
            </div>
            <h6 class="text-uppercase text-center">Total Posts</h6>
            <h1 class="display-1 text-center"><a href="{{ route('all.posts') }}" style="color: white;" >{{ $posts }}</a></h1>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-inverse card-info">
          <div class="card-block bg-info">
            <div class="rotate">
              <i class="fa fa-comments fa-5x"></i>
            </div>
            <h6 class="text-uppercase text-center">Total Comments</h6>
            <h1 class="display-1 text-center"> <a href="{{ route('all.comments') }}" style="color: white">{{ $comments }}</a></h1>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-inverse card-warning">
          <div class="card-block bg-warning">
            <div class="rotate">
              <i class="fa fa-share fa-5x"></i>
            </div>
            <h6 class="text-uppercase text-center">Total Reports</h6>
            <h1 class="display-1 text-center"> <a href="{{ route('all.reports') }}" style="color: white">{{ $reports }}</a></h1>
          </div>
        </div>
      </div>
    </div>
    <!--/row-->

    <hr>
    <div class="row mb-3">
<h1 class="text-center" style="margin-left: 450px">Last 5 Users</h1>


<div id="success_msg" class="alert alert-danger text-center userdel"  style="display: none;">
  User Deleted Successfully
</div>

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

              <tr class="userrow{{ $user->id }}">
                <td>
                @if ($user->avatar)
                <img src="{{ url('Images/Avatar/',$user->avatar) }}" alt="" class="rounded-circle" style="width:50px;height:50px">
                @else
                <img src="{{ url('img.png') }}" alt="" class="rounded-circle" style="width:50px;height:50px">

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
      </div>
    </div>
    <!--/row-->



<h1 class="text-center">Last 5 Posts</h1>

<div id="delpost_success_msg" class="alert alert-danger text-center postdel" style="display: none;">
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

            <tr class="postrow{{ $post->id }}">

              <td>
                {{ $post->content }}
            </td>
            @forelse ($post->images as $img)
              <td>
      <img src="{{ url('Images/Posts/',$img->photo) }}" alt=""  style="width:50px;height:50px">
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

      </div>
    </div>


<h1 class="text-center">Last 5 Comments</h1>


<div id="commentdel_success_msg" class="alert alert-danger text-center commentdel" style="display: none;">
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

            <tr class="commentrow{{ $comment->id }}">

              <td class="text-center">
                {{ $comment->comment }}
            </td>
            <td class="text-center">
                {{ $comment->parent_id }}
            </td>

              <td class="text-center">{{ $comment->post->content }}</td>
              <td class="text-center">{{ $comment->user->name }}</td>
              <td class="text-center"><button  comment_id='{{ $comment->id }}' class="btn btn-danger deletecomment">Delete</button></td>


            </tr>
            @endforeach

          </tbody>

        </table>

      </div>
    </div>


    <h1 class="text-center">Last 5 Reports</h1>

    <div id="report_success_msg" class="alert alert-danger text-center reportdel" style="display: none;">
      Report Deleted Successfully
    </div>
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

            <tr class="reportrow{{ $report->id }}">

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

    <div class="col-lg-3 col-md-4">
      <div class="card">
      <div class="card-header text-white bg-primary text-center">New Posts Today</div>
      <div class="card-block">
          <h4 class="card-title text-center">
            {{ $posts_per_day }}
          </h4>
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

  </div>
  <!--/main col-->
</div>

</div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
//Delete Post

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

              $('#delpost_success_msg').show();
          }
          $('.postrow'+data.id).remove();
      },

      error: function (reject) {
          var response = $.parseJSON(reject.responseText);
          $.each(response.errors, function (key, val) {
              $("#" + key + "_error").text(val[0]);
          });
      }
  });
});

//Delete User
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
          $('.userrow'+data.id).remove();
      },

      error: function (reject) {
          var response = $.parseJSON(reject.responseText);
          $.each(response.errors, function (key, val) {
              $("#" + key + "_error").text(val[0]);
          });
      }
  });
});



//Delete Comment


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

              $('#commentdel_success_msg').show();
          }
          $('.commentrow'+data.id).remove();
      },

      error: function (reject) {
          var response = $.parseJSON(reject.responseText);
          $.each(response.errors, function (key, val) {
              $("#" + key + "_error").text(val[0]);
          });
      }
  });
});

//Delete Report

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

              $('#report_success_msg').show();
          }
          $('.reportrow'+data.id).remove();
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
