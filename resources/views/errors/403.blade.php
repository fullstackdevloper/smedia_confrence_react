@extends('errors::layout')

@section('title', __('Unauthorized'))

@section('message', __($exception->getMessage()))