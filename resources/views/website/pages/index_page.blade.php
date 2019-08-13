@extends('website.layouts.default')

@section('content')
	@include("website.includes.home")
		
	@include("website.includes.about")
		

    @include("website.includes.departments")
		
	@include("website.includes.doctors")

	@include('website.includes.testimonials')

    @include("website.includes.consultation")

    @include("website.includes.pricing")

    @include("website.includes.recent_blog")
@stop