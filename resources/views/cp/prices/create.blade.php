@extends('layout.app')
@section('title') {{ucwords(__('common.price'))}}
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
                              style="color: #e02222 !important;">{{__('common.add')}}{{__('common.price')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/deliveryPrices')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">
                       
                        <div class="form-group">

                                    <label class="col-sm-2 control-label" for="country_id">

                                        Country <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <select id="category_id" class="form-control select2" name="country_id"

                                                required>

                                            @foreach($countries as $country)

                                                <option value="{{$country->id}}" {{ (old("country_id") == $country->id ? "selected":"") }}>

                                                    {{$country->name}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>
                                
                                
                            <fieldset>
                                <legend>{{__('common.price')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="price">
                                        {{__('common.price')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="price" value="" id="price"
                                               placeholder=" {{__('common.price')}}" {{ old('price') }}>
                                    </div>
                                </div>
                            </fieldset>
                             <input type="hidden" class="form-control" name="expo_id" value="{{$expo_id}}" id="expo_id">
                          
 
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/deliveryPrices')}}" class="btn default">Cancel</a>
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
