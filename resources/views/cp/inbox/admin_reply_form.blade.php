@extends('layout.app')
@section('title') {{ucwords(__('common.message'))}}
@endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"
                              style="color: #e02222 !important;">{{__('common.add')}}{{__('common.message')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/messages/store_reply')}}"
                          class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <fieldset>
                                <legend>{{__('layout.message')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="message">
                                        {{__('layout.message')}}
                                    </label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" name="msg_id" value="{{$id}}">

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/myMessages')}}" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
@section('script')

@endsection
