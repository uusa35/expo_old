@extends('layout.app')
@section('title') {{ucwords(__('common.event'))}}
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
                              style="color: #e02222 !important;">{{__('common.add')}} {{__('events')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/calendar_event')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <fieldset>
                                <legend>{{__('common.title')}}</legend>
                                @foreach($locales as $locale)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="title_{{$locale->name}}">
                                            {{__('common.title')}} {{$locale->name}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="title_{{$locale->lang}}"
                                                   placeholder=" {{__('common.title')}} {{$locale->name}}"
                                                   id="title_{{$locale->name}}"
                                                   value="{{ old('title_'.$locale->lang) }}" required>
                                        </div>
                                    </div>

                                @endforeach
                            </fieldset>
                            
                            
                            <fieldset>
                                <legend>{{__('common.description')}}</legend>
                                @foreach($locales as $locale)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="description_{{$locale->name}}">
                                            {{__('common.description')}} {{$locale->name}}
                                        </label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="description_{{$locale->lang}}"
                                                   placeholder=" {{__('common.description')}} {{$locale->name}}"
                                                   id="description_{{$locale->name}}">{{ old('description'.$locale->lang) }}</textarea>
                                        </div>
                                    </div>

                                @endforeach
                            </fieldset>

                             <div class="form-group">
                                    <label class="col-sm-2 control-label" for="type">
                                        {{__('common.type')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select id="category_id" class="form-control select2" name="type"
                                                required>
                                                <option value="1" {{ (old("type") == 1 ? "selected":"") }}>
                                                    {{__('common.expo')}}
                                                </option>
                                                <option value="2" {{ (old("type") == 2 ? "selected":"") }}>
                                                    {{__('common.business')}}
                                                </option>
                                        </select>
                                    </div>
                                </div>

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
                            
                             <div class="form-group">

                                    <label class="col-sm-2 control-label" for="expo_id">

                                        {{__('common.related-expo')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">
                                        <select id="expo_id" class="form-control select2" name="expo_id"

                                                required>
                                            @foreach($expo as $ex)

                                                <option value="{{$ex->id}}" {{ (old("expo_id") == $ex->id ? "selected":"") }}>

                                                    {{$ex->name}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>
                                

           

                                    <div class="form-group">
                                                <label class="control-label col-md-3"> {{__('common.start-date')}}</label>
                                                <div class="col-md-3">
                                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" name="start_date" class="form-control" readonly>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>  

                                         <div class="form-group">
                                                <label class="control-label col-md-3">{{__('common.end-date')}}</label>
                                                <div class="col-md-3">
                                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" name="end_date"class="form-control" readonly>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>

                        
                           

                                </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/calendar_event')}}" class="btn default">Cancel</a>
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
        <script src="{{url('/admin_assets/assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>       
        <script src="{{url('/admin_assets/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>

@endsection
@section('script')
   

@endsection
