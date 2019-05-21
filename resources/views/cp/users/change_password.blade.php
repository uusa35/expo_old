@extends('layout.app')
@section('title') {{ucwords(__('common.change_password'))}}
@endsection
@section('css')
@endsection

@section('content')

<div class="col-md-6">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{route('password_store')}}"  method="Post">
        {{csrf_field()}}
        <label><h3>{{__('common.change_password')}}</h3>  </label>
        <div class="form-group">
            <label>{{__('common.old_password')}}</label>
            <input required type="password" name="current-password" class="form-control" placeholder="{{__('common.old_password')}}" value="">
        </div>

        <div class="form-group">
            <label>{{__('common.new_password')}}</label>
            <input required type="password" name="new-password" class="form-control" placeholder="{{__('common.new_password')}}" value="">
        </div>
        <div class="form-group">
            <label>{{__('common.repeat_password')}}</label>
            <input  required type="password" name="new-password_confirmation" class="form-control" placeholder="{{__('common.repeat_password')}}" value="">
        </div>

        <button type="submit" class="view-btn">{{__('common.change')}}</button>
    </form>
@endsection