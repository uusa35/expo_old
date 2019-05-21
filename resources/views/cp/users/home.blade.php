@extends('layout.app')
@section('title') {{ucwords(__('common.users_management'))}}
@endsection
@section('css')
@endsection
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="btn-group">
                            <button class="btn sbold blue btn--filter">{{__('common.filter')}}
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/users')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">{{__('common.email')}}</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">{{__('common.full_name')}}</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">{{__('common.user_type')}}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="user_type" id="user_type">
                                            <option value="1">customer</option>
                                            <option value="2">expo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('common.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('admin/users')}}" type="submit"
                                           class="btn sbold btn-default ">{{('reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                        {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">--}}
                        {{--<input type="checkbox" class="group-checkable chkBox" data-set="#sample_1 .checkboxes"/>--}}
                        {{--<span></span>--}}
                        {{--</label>--}}
                    </th>
                    <th> {{ucwords(__('common.full_name'))}}</th>
                    <th> {{ucwords(__('common.email'))}}</th>
                    <th> {{ucwords(__('common.image'))}}</th>
                    <th> {{ucwords(__('common.type'))}}</th>
                    <th> {{ucwords(__('common.created'))}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>
                                <span></span>
                            </label>
                        </td>
                        <td> {{$item->name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                         <td>

                            <img src="{{!empty($item->image)?$item->image : url('/admin_assets/Logo.png')}}" width="50px" height="50px">

                        </td>
                        <td class="center">{{$item->user_type_text}}</td>
                        <td class="center">{{$item->created_at}}</td>
                    </tr>

                @empty
                    {{__('common.no')}}
                @endforelse
                </tbody>
            </table>
            {{$items->links()}}
        </div>
    </div>
@endsection
