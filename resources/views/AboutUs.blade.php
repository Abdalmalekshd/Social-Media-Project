@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';

?>


<p class="aboutus">{{ __('messages.aboutus') }}</p>
@if(LaravelLocalization::getCurrentLocale() == 'ar')
<style>
.aboutus{
    direction:rtl;
}
</style>


@endif

@stop