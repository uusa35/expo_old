@extends('layout.app')

@section('title') {{ucwords(__('package.title'))}}

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

                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('package.package')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/package/'.$item->id)}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        {{ method_field('PATCH')}}

                        <div class="form-body">


                            <fieldset>
                                <legend>{{__('cafe.cafe')}}{{__('common.title')}}</legend>
                                @foreach($locales as $locale)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="title_{{$locale->name}}">
                                            {{__('common.title')}} {{$locale->name}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="title_{{$locale->lang}}"
                                                   id="title_{{$locale->name}}" required
                                                   value="{{isset($item->translate($locale->lang)->title)?$item->translate($locale->lang)->title:""}}"
                                            >
                                        </div>
                                    </div>

                                @endforeach
                            </fieldset>


                            <fieldset>

                                <legend>{{__('package.package')}}{{__('common.details')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="price">

                                        {{__('common.price')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="price" value="{{$item->price}}"

                                               id="price">

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="duration">

                                        {{__('common.duration')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="duration" value="{{$item->duration}}"

                                               id="duration">

                                    </div>

                                </div>



                            </fieldset>
                            
                            <fieldset>

                                <legend>{{__('common.image')}}</legend>

                                <div class="form-group">

                                    <div class="col-md-6 col-md-offset-3">

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image').click()"

                                             style="cursor:pointer">

                                            <img src="{{url($item->image)}}" id="editImage">

                                        </div>

                                        <label class="control-label">{{__('common.image')}}</label>

                                        <div class="btn red"

                                             onclick="document.getElementById('edit_image').click()">

                                            <i class="fa fa-pencil"></i>{{__('common.change_image')}}

                                        </div>

                                        <input type="file" class="form-control" name="image"

                                               id="edit_image"

                                               style="display:none">

                                    </div>

                                </div>

                            </fieldset>


                            <fieldset>

                                <legend>{{__('package.package')}}{{__('common.order')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                        {{__('common.order')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="order" value="{{$item->order_by}}"

                                               id="order">

                                    </div>

                                </div>

                            </fieldset>

                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">Submit</button>

                                        <a href="{{url(getLocal().'/admin/package')}}" class="btn default">Cancel</a>

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

