@extends('crudbooster::admin_template') @if($show_summary) {!! Charts::assets($chartLibraries) !!} @endif @section('content')
@if(strlen($file_url) > 0)
<a href="{{$file_url}}" target="_blank">Click to View/Download</a> @endif @endsection