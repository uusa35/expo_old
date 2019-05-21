@extends('layout.app')

@section('title') {{ucwords(__('common.expo'))}}

@endsection

@section('css')

    <link href="{{admin_assets('global/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"
          type="text/css"/>

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

                              style="color: #e02222 !important;">{{__('common.add')}}{{__('common.expo')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/expo')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">

                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="type">

                                    Type

                                    <span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">

                                    <select id="type" class="form-control select2" name="type"

                                            required>

                                        <option value="1" {{ (old("type") == '1' ? "selected":"") }}>Expo</option>

                                        <option value="2" {{ (old("type") == '2' ? "selected":"") }}>Business</option>

                                    </select>

                                </div>

                            </div>


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

                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">

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

                                <legend>{{__('common.designer_name')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="designer_name">

                                        {{__('common.designer_name')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="designer_name" value=""
                                               id="designer_name"

                                               placeholder=" {{__('common.designer_name')}}" {{ old('designer_name') }}>

                                    </div>

                                </div>

                            </fieldset>


                            <fieldset>

                                <legend>{{__('common.designer_image')}}</legend>

                                <div class="form-group {{ $errors->has('designer_image') ? ' has-error' : '' }}">

                                    <div class="col-md-6 col-md-offset-3">

                                        @if ($errors->has('designer_image'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('designer_image') }}</strong>

                                            </span>

                                        @endif

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image1').click()"

                                             style="cursor:pointer">

                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage1">

                                        </div>
                                        <div class="btn red"

                                             onclick="document.getElementById('edit_image1').click()">

                                            <i class="fa fa-pencil"></i>{{__('common.change_image')}}

                                        </div>

                                        <input type="file" class="form-control" name="designer_image"

                                               id="edit_image1"

                                               style="display:none">

                                    </div>

                                </div>

                            </fieldset>


                            <fieldset>

                                <legend>{{__('common.details')}}</legend>
                                
                                <div class="form-group">

                                        <label class="col-sm-2 control-label" for="details">

                                            {{__('common.details')}}

                                        </label>

                                        <div class="col-md-6">

                                            <textarea class="form-control" rows="5" cols="5" name="details"
                                                  id="details"></textarea>
                                        </div>
                                </div>

                            </fieldset>


                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="category_id">

                                    {{__('common.category')}}<span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">
                                    <select id="multiple" class="form-control select2-multiple" name="category_id[]"
                                            multiple>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ (old("category_id") == $category->id ? "selected":"") }}>
                                                {{$category->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>


                        <!--   <fieldset>

                                <legend>{{__('material.material')}}{{__('common.civil_id')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="civil_id">

                                        {{__('common.civil_id')}}

                                </label>

                                <div class="col-md-6">

                                    <input type="text" class="form-control" name="civil_id" value="0" id="civil_id"

                                           placeholder=" {{__('common.civil_id')}}" {{ old('civil_id') }}>

                                    </div>

                                </div>

                            </fieldset> -->


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

                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage2">

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

                                <legend>{{__('common.city-name')}}</legend>


                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="country_id">

                                        {{__('common.country')}} <span class="symbol">*</span>

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


                            <!--       <div class="form-group">

                                    <label class="col-sm-2 control-label" for="city_id">

                                        City <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <select id="category_id" class="form-control select2" name="city_id"

                                                required>

                                            @foreach($cities as $city)

                                <option value="{{$city->id}}" {{ (old("city_id") == $city->id ? "selected":"") }}>

                                                    {{$city->name}}

                                        </option>

@endforeach

                                    </select>

                                </div>

                            </div> -->


                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                        {{__('common.city-name')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="city_name" value="" id="city_name"

                                               placeholder="city name" {{ old('city_name') }}>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="address">

                                        {{__('common.address')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="address" value="" id="address"

                                               placeholder=" {{__('common.address')}}" {{ old('address') }}>

                                    </div>

                                </div>

                            </fieldset>


                        <!--    <div class="form-group">

                                    <label class="col-sm-2 control-label" for="delivery_country_id">

                                       Delivery Country <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">
                                        <select id="multiple" class="form-control select2-multiple" name="delivery_country_id[]" multiple>
                                         @foreach($countries as $country)

                            <option value="{{$country->id}}" {{ (old("delivery_country_id") == $country->id ? "selected":"") }}>

                                                    {{$country->name}}

                                    </option>

@endforeach
                                </select>



                                </div>

                            </div>-->


                        <!-- <div class="form-group">

                                    <label class="col-sm-2 control-label" for="delivery_city_id">

                                       Delivery City <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <select id="category_id" class="form-control select2" name="delivery_city_id"

                                                required>

                                            @foreach($cities as $city)

                            <option value="{{$city->id}}" {{ (old("delivery_city_id") == $city->id ? "selected":"") }}>

                                                    {{$city->name}}

                                    </option>

@endforeach

                                </select>

                            </div>

                        </div> -->

                        <!--  <fieldset>

                                <legend>Delivery city name</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                       Delivery city name

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="delivery_city_name" value="" id="delivery_city_name"

                                               placeholder="" {{ old('delivery_city_name') }}>

                                    </div>

                                </div>

                            </fieldset>-->

                            <fieldset>


                                <legend>{{__('common.address')}}</legend>
                                <div class="form-group">

                                    <label class="control-label col-md-3"> {{__('common.delivery-service')}}</label>

                                    <div class="col-md-9">

                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                <input type="radio" name="delivery_service"
                                                       id="delivery_service_yes" value="yes"
                                                       {{ old('delivery_service') == 'yes' ? 'checked' : ''}} required> {{__('yes')}}
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="delivery_service"
                                                       id="delivery_service_no" value="no"
                                                        {{ old('delivery_service') == 'no' ? 'checked' : ''}}> {{__('no')}}
                                                <span></span>
                                            </label>
                                        </div>

                                    </div>

                                </div>

                                <div class="input_fields_wrap delivery_block">


                                    <div class="form-group">

                                        <label class="col-sm-2 control-label" for="delivery_country_id">

                                            {{__('common.delivery-country')}} <span class="symbol">*</span>

                                        </label>

                                        <div class="col-md-3">

                                            <select class="form-control select2 delivery_country" name="delivery_country_id[]"

                                                    required>

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
                                            <input type="text" class="form-control delivery_country" name="cities[]" required>
                                        </div>

                                    </div>

                                </div>
                                <div>
                                    <button type="button" style="margin-bottom: 10px;;" class="add_field_button btn green col-md-2 delivery_block">Add Delivery Country</button>
                                </div>


                            </fieldset>
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
                                
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="highlight">

                                        {{__('common.in_slider')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="checkbox" class="make-switch" name="in_slider" id="in_slider" data-size="small">

                                    </div>

                                </div>

                            </fieldset>


                            <fieldset>

                                <legend>Details</legend>
                                
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="mobile">

                                        mobile

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="mobile" value="" id="mobile"

                                               placeholder=" {{__('common.mobile')}}" {{ old('mobile') }}>

                                    </div>

                                </div>
                                
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="email">

                                        {{__('common.email')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="email" value="" id="email"

                                               placeholder=" {{__('common.email')}}" {{ old('email') }}>

                                    </div>

                                </div>


                               <div class="form-group">

                                    <label class="col-sm-2 control-label" for="password">

                                        {{__('common.password')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="password" class="form-control" name="password" value=""
                                               id="password"

                                               placeholder=" {{__('common.password')}}" {{ old('password') }}>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="password">

                                        {{__('common.repeat-password')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="password" class="form-control" name="password" value=""
                                               id="password"

                                               placeholder=" {{__('common.password')}}" {{ old('password') }}>

                                    </div>

                                </div>

                            </fieldset>


                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">Submit</button>

                                        <a href="{{url(getLocal().'/admin/expo')}}" class="btn default">Cancel</a>

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
    <script src="{{admin_assets('global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('global/plugins/jquery-validation/js/jquery.validate.min.js')}}"
            type="text/javascript"></script>
    <script src="{{admin_assets('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{admin_assets('global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}"
            type="text/javascript"></script>

    <script src="{{admin_assets('global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}"
            type="text/javascript"></script>
    <script src="{{admin_assets('pages/scripts/components-bootstrap-select.min.js')}}" type="text/javascript"></script>

@endsection

@section('script')

    <script>

        $('#edit_image1').on('change', function (e) {

            readURL(this, $('#editImage1'));

        });

    </script>

    <script>
        $(document).on("click","#delivery_service_no",function() {
            $('.delivery_block').hide();
            $('.delivery_country').removeAttr('required');
        });
        $(document).on("click","#delivery_service_yes",function() {
            $('.delivery_block').show();
            $('.delivery_country').attr('required', 'required');
        });

    </script>


    <script>

        $('#edit_image').on('change', function (e) {

            readURL(this, $('#editImage'));

        });

    </script>

    <script>

        $('#edit_image2').on('change', function (e) {

            readURL(this, $('#editImage2'));

        });

    </script>
    <script>
        var x = 1; //initlal text box count
        $('.add_field_button').click(function (e) { //on add input button click
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

                    ' <select  class="form-control select2" name="delivery_country_id[]"' +

                    '   required>' +

                    '  @foreach($countries as $country)' +

                    '  <option value="{{$country->id}}" >' +

                    '{{$country->name}}' +

                    '   </option>' +

                    '                        @endforeach' +

                    '     </select>' +

                    '    </div>' +

                    '                                     <label class="col-sm-2 control-label" for="delivery_country_id">' +
                    '{{__("common.delivery-city")}} <span class="symbol">*</span>' +
                    '                                     </label>' +
                    '   <div class="col-md-3">' +
                    '  <input type="text" class="form-control" name="cities[]">' +
                    '  </div> <a href="#" class="remove_field">Remove</a></div></div>'); //add input box'+
            }
            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text'+
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        });

    </script>




@endsection

