@extends('app.index')
@section('content')
<link rel="stylesheet" href="{{url('/css/recommend.css')}}"> 
<div class="recommend_title">
	<span class="img" id="back"><img src="{{url('/img/recommend/back.png')}}"></span>
	<span>热门推荐</span>
</div>
<div class="recommend_container">

</div>
<script type="text/javascript" src="{{url('/js/recommend.js')}}"></script>
@stop