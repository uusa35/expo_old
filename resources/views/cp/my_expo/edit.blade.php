@extends('layout.app')

@section('title') {{ucwords(__('common.expo'))}}

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

                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('common.expo')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/update_my_expo')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">
                            <fieldset>

                                <legend>{{__('common.booth_image')}}</legend>

                                <div class="form-group {{ $errors->has('booth_image') ? ' has-error' : '' }}">

                                    <div class="col-md-6 col-md-offset-3">

                                        @if ($errors->has('booth_image'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('booth_image') }}</strong>

                                            </span>

                                        @endif

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image').click()"

                                             style="cursor:pointer">

                                            <img src="{{(!empty($item->booth_image)? url($item->booth_image) :url(admin_assets('/images/ChoosePhoto.png')))}}"
                                                 id="editImage">

                                        </div>

                                        <div class="btn red"

                                             onclick="document.getElementById('edit_image').click()">

                                            <i class="fa fa-pencil"></i>{{__('common.change_image')}}

                                        </div>

                                        <input type="file" class="form-control" name="booth_image"

                                               id="edit_image"

                                               style="display:none">

                                    </div>

                                </div>

                            </fieldset>


                            <fieldset>

                                <legend>{{__('common.details')}}</legend>
                                
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

                                                   value="{{isset($item->translate($locale->lang)->name)?$item->translate($locale->lang)->name:""}}"
                                                   required>

                                        </div>

                                    </div>



                                @endforeach
                                
                                
                                <div class="form-group">

                                        <label class="col-sm-2 control-label" for="details">

                                            {{__('common.details')}}

                                        </label>

                                        <div class="col-md-6">

                                            <textarea class="form-control" rows="5" cols="5" name="details"
                                                  id="details">{{$item->details}}</textarea>

                                        </div>

                                </div>

                            
                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="category_id">

                                    {{__('common.category')}} <span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">
                                        <select id="multiple" class="form-control select2-multiple" name="category_id[]"
                                                multiple>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{ (in_array($category->id,$e_categories)? "selected":"") }}>
                                                    {{$category->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>

                            </div>
                            </fieldset>

                            <fieldset>

                                <legend>{{__('common.civil_id')}}</legend>

                                <div class="form-group {{ $errors->has('civil_id') ? ' has-error' : '' }}">

                                    <div class="col-md-6 col-md-offset-3">

                                        @if ($errors->has('civil_id'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('civil_id') }}</strong>

                                            </span>

                                        @endif

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image2').click()"

                                             style="cursor:pointer">

                                            <img src="{{(!empty($item->civil_id)? url($item->civil_id) :url(admin_assets('/images/ChoosePhoto.png')))}}"
                                                 id="editImage2">

                                        </div>
                                        
                                        <div class="btn red"

                                             onclick="document.getElementById('edit_image2').click()">

                                            <i class="fa fa-pencil"></i>{{__('common.change_image')}}

                                        </div>

                                        <input type="file" class="form-control" name="civil_id"

                                               id="edit_image2"

                                               style="display:none">

                                    </div>

                                </div>

                            </fieldset>
                            
                            <fieldset>

                                <legend>{{__('common.address')}}</legend>
                                
                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="country_id">

                                    {{__('common.country')}} <span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">

                                    <select id="category_id" class="form-control select2" name="country_id"

                                            required>

                                        @foreach($countries as $country)

                                            <option value="{{$country->id}}" {{ ($item->country_id == $country->id ? "selected":"") }}>

                                                {{$country->name}}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                        {{__('common.city-name')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="city_name"
                                               value="{{$item->city_name}}" id="city_name"

                                               placeholder="{{__('common.city-name')}}" {{ old('city_name') }}>

                                    </div>

                                </div>


                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="address">

                                    {{__('common.address')}}

                                </label>

                                <div class="col-md-6">

                                    <input type="text" class="form-control" name="address" value="{{$item->address}}"
                                           id="address"

                                           placeholder=" {{__('common.address')}}" {{ old('address') }}>

                                </div>

                            </div>

                            </fieldset>


                            
                            <fieldset>


                                <legend>{{__('common.delivery-country')}}</legend>

                                <div class="form-group">

                                    <label class="control-label col-md-3">{{__('common.delivery-service')}}</label>

                                    <div class="col-md-9">
                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                <input type="radio" name="delivery_service"
                                                       id="delivery_service_yes" value="yes"
                                                       {{ old('delivery_service', $item->delivery_service) == 'yes' ? 'checked' : ''}} required> {{__('yes')}}
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="delivery_service"
                                                       id="delivery_service_no" value="no"
                                                        {{ old('delivery_service', $item->delivery_service) == 'no' ? 'checked' : ''}}> {{__('no')}}
                                                <span></span>
                                            </label>
                                        </div>

                                    </div>

                                </div>


                                <div class="input_fields_wrap delivery_block" style="display: {{($item->delivery_service == 'yes') ? 'block' : 'none' }}">
                                    @if($item->delivery_service == 'yes')
                                        @foreach($ex_countries as $e_country)
                                            <div class="form-group">

                                                <label class="col-sm-2 control-label" for="delivery_country_id">

                                                    {{__('common.delivery-country')}} <span class="symbol">*</span>

                                                </label>

                                                <div class="col-md-3">

                                                    <select class="form-control select2 delivery_country_id"
                                                            name="delivery_country_id[]"
                                                            required>

                                                        @foreach($countries as $country)

                                                            <option value="{{$country->id}}" {{ ($e_country->country_id == $country->id ? "selected":"") }}>

                                                                {{$country->name}}

                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>
                                                <label class="col-sm-2 control-label" for="delivery_country_id">

                                                    {{__('common.delivery-city')}} <span class="symbol">*</span>

                                                </label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control cities"
                                                           name="cities[]"
                                                           value="{{$e_country->cities}}">
                                                </div>
                                                {{--<a href="#" class="remove_field">Remove</a>--}}
                                            </div>
                                        @endforeach
                                        @else
                                        <div calss="col-md-10" >
                                            <div class="form-group">

                                            <label class="col-sm-2 control-label" for="delivery_country_id">

                                                {{__('common.delivery-country')}} <span class="symbol">*</span>

                                            </label>

                                            <div class="col-md-3">

                                                <select class="form-control select2 delivery_country_id" name="">

                                                    @foreach($countries as $country)

                                                        <option value="{{$country->id}}">

                                                            {{$country->name}}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>
                                            <label class="col-sm-2 control-label" for="delivery_country_id">
                                                {{__('common.delivery-city')}} <span class="symbol">*</span>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control cities" name="">
                                            </div>

                                        </div>
                                        </div>

                                    @endif

                                </div>
                                <div class="delivery_block" style="display: {{$item->delivery_service == 'yes'? 'block' :'none'}}">
                                    <button type="button"
                                            class="add_field_button btn green col-md-2">{{__('common.add')}}</button>
                                </div>


                            </fieldset>


                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">{{__('common.submit')}}</button>

                                        <a href="{{url(getLocal().'/admin/myExpo')}}" class="btn default">{{__('common.cancel')}}</a>

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


        $('#edit_image1').on('change', function (e) {

            readURL(this, $('#editImage1'));

        });
        $('#edit_image2').on('change', function (e) {

            readURL(this, $('#editImage2'));

        });

    </script>

    <script>
        $(document).on("click","#delivery_service_no",function() {
            $('.delivery_block').hide();
            $('.cities').removeAttr('name');
            $('.delivery_country_id').removeAttr('name');
            $('.cities').removeAttr('required');
        });
        $(document).on("click","#delivery_service_yes",function() {
            $('.delivery_block').show();
            $('.cities').attr('name', 'cities[]');
            $('.delivery_country_id').attr('name', 'delivery_country_id[]');
            $('.cities').attr('required','');
        });

    </script>
    <script type="text/javascript">
        var x = 1; //initlal text box count
        $(document).on("click",".add_field_button",function(e) {
            var max_fields = 10; //maximum input boxes allowed
            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var add_button = $(".add_field_button"); //Add button ID


            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div calss="col-md-10" >    <div class="form-group">' +

                    '<label class="col-sm-2 control-label" for="delivery_country_id">' +

                    'Delivery Country <span class="symbol">*</span>' +

                    '</label>' +

                    ' <div class="col-md-3">' +

                    ' <select  class="form-control select2 delivery_country_id" name="delivery_country_id[]"' +

                    '   required>' +

                    '  @foreach($countries as $country)' +

                    '  <option value="{{$country->id}}" {{ ($item->delivery_country_id == $country->id ? "selected":"") }}>' +

                    '{{$country->name}}' +

                    '   </option>' +

                    '                        @endforeach' +

                    '     </select>' +

                    '    </div>' +

                    '                                     <label class="col-sm-2 control-label" for="delivery_country_id">' +
                    '{{__("common.delivery-city")}} <span class="symbol">*</span>' +
                    '                                     </label>'+
                    ' <div class="col-md-3">' +
                    '  <input type="text" class="form-control cities" name="cities[]">' +
                    '  </div> <a href="#" class="remove_field">Remove</a></div>'); //add input box'+
            }
            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text'+
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        });

    </script>

@endsection

