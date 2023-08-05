@extends('layout.UserMaster')

@section('content')
<?php $Nosidebar =''; 

?>
<form action="{{ route('update.post') }}" method="POST" class="form-group create"  enctype="multipart/form-data">
@csrf


<div class="container">

<input type="hidden" name="postid" value="{{$post->id}}">
<div class="row">
<div class="col-md-12">
  
  <textarea name="content">{{ $post->content }}</textarea>
</div>
</div>

@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror 

<div class="row">
  <div class="col-md-12">
<input type="file" name="image[]" multiple>
</div>

</div>
@error('image')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror
</div>
<div class="editpage">

@foreach ($post->images  as $img)
<img src="{{ url('images/Posts',$img->photo) }}" alt="">
@endforeach
</div>


<input type="submit" value="submit" class="btn btn-success">





</form>

@endsection
