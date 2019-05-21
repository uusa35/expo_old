@extends('layout.app')
@section('title') {{ucwords(__('slider.title'))}}
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
                              style="color: #e02222 !important;">{{__('common.add')}}{{__('slider.slider')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/slider')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <fieldset>
                                <legend>{{__('slider.slider')}}{{__('common.title')}}</legend>
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
                                <legend>{{__('slider.slider')}}{{__('common.order')}}</legend>
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
                           
                          <!--  <fieldset>
                                <legend>{{__('slider.slider')}}{{__('common.link')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="link">
                                        {{__('common.link')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="link" value="" id="link"
                                               placeholder=" {{__('common.link')}}" {{ old('link') }}>
                                    </div>
                                </div>
                            </fieldset> -->

                           <!--  <fieldset>
                                <legend>{{__('cafe_products.cafe_product')}}{{__('common.details')}}</legend>
                                @foreach($locales as $locale)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            {{__('common.details')}} {{$locale->name}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="details_{{$locale->lang}}"
                                                      rows="6" required>

                                                {{ old('details_'.$locale->lang) }}
                                            </textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset> -->

                            <fieldset>
                                <legend>{{__('common.image')}}</legend>
                                <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-3">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">
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
         
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/slider')}}" class="btn default">Cancel</a>
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
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
    </script>
@endsection
