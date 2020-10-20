@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
<a class="btn btn-dark" href="{{ route('login') }}">Ingresar</a>
@section('message', __('Page Expired'))
