@extends('layout.UserMaster')

@section('content')
<?php 
$Nosidebar =''; 

?>
<form action="{{ route('report') }}" method="POST" class="form-group create"  >
@csrf


<div class="container">





<div class="row">
<div class="col-md-12">
    @if(!$post == null)
<input type='hidden' name="postId" value="{{ $post->id }}">
@elseif (!$user == null)
<input type='hidden' name="userId" value="{{ $user->id }}">
@else
<input type='hidden' name="commentId" value="{{ $comment->id }}">

@endif


</div>

</div>
@error('postId')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('userId')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror


@error('commentId')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror
</div>

<div class="row">
    <div class="col-md-12">
        
        <select name="reason" class="select2 form-control" >
            <optgroup label="{{ __('messages.SelectReason') }}">
                
                <option value="Sexaulty">{{ __('messages.Sexaulty') }}</option>
                <option value="Violence">{{ __('messages.Violence') }}</option>
                <option value="Fake News">{{ __('messages.Fake') }}</option>
                <option value="Fraud">{{ __('messages.Fraud') }}</option>

                
            </optgroup>
        </select>
    
    </div>
    @error('reason')  
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    



<input type="submit" value="submit" class="btn btn-success">

</div>


</div>

</form>

@endsection
