@extends('layout.app')
@section('title') {{ucwords(__('common.currency'))}}
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
                              style="color: #e02222 !important;">{{__('common.add')}}{{__('common.currency')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/currency')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <fieldset>
                                <legend>{{__('common.name')}}</legend>
                                @foreach($locales as $locale)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name_{{$locale->name}}">
                                            {{__('common.name')}} {{$locale->name}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name_{{$locale->lang}}"
                                                   placeholder=" {{__('common.name')}} {{$locale->name}}"
                                                   id="name_{{$locale->name}}"
                                                   value="{{ old('name_'.$locale->lang) }}" required>
                                        </div>
                                    </div>

                                @endforeach
                            </fieldset>
                            <fieldset>
                                <legend>{{__('common.order')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('common.order')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="order" value="0" id="order"
                                               placeholder=" {{__('common.order')}}" {{ old('order') }}>
                                    </div>
                                </div>
                            </fieldset>

                             <fieldset>
                                <legend>{{__('common.shortcut')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="shortcut">
                                        {{__('common.shortcut')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="shortcut" value="" id="shortcut"
                                               placeholder=" {{__('common.shortcut')}}" {{ old('shortcut') }}>
                                    </div>
                                </div>
                            </fieldset>
                             <fieldset>
                                <legend>{{__('common.price')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="price">
                                        {{__('common.price')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="price" value="0" id="price"
                                               placeholder=" {{__('common.price')}}" {{ old('price') }}>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/currency')}}" class="btn default">Cancel</a>
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
