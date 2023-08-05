@extends('layout.UserMaster')

@section('content')
<?php 
$Nosidebar =''; 

?>
<form action="{{ route('store.post') }}" method="POST" class="form-group create"  enctype="multipart/form-data">
@csrf


<div class="container">


<div class="row">
<div class="col-md-12">
  
  <textarea name="content"></textarea>
</div>
</div>

@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
{{-- <div class="form-control"> --}}
  
<div class="row">
  <div class="col-md-12">
<input type="file" name="image[]" multiple>
</div>

</div>
@error('image')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror
</div>


<input type="submit" value="submit" class="btn btn-success">



</div>

</form>


@endsection
