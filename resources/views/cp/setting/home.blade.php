@extends('layout.app')

@section('title') {{ucwords(__('setting.title'))}}

@endsection

@section('css')

    <script type="text/javascript"

            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjOp2BjQx-ruFkTnb4mB_2m3eFtcCyPbU&sensor=false&libraries=places"></script>

    <link rel="stylesheet" type="text/css" href="{{url('/admin_assets/datepicker/jquery.datetimepicker.css')}}"/>

    <style type="text/css">

        .input-controls {

            margin-top: 10px;

            border: 1px solid transparent;

            border-radius: 2px 0 0 2px;

            box-sizing: border-box;

            -moz-box-sizing: border-box;

            height: 32px;

            outline: none;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);

        }



        #searchInput {

            background-color: #fff;

            font-family: Roboto;

            font-size: 15px;

            font-weight: 300;

            margin-left: 12px;

            padding: 0 11px 0 13px;

            text-overflow: ellipsis;

            width: 50%;

        }



        #searchInput:focus {

            border-color: #4d90fe;

        }

    </style>

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

                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('setting.setting')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/setting/')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        {{--                        {{ method_field('PATCH')}}--}}

                        <div class="form-body">

                            @foreach($settings as $setting)

                                @if($setting->key == 'site_logo')@continue;@endif

                                @if($setting->key == 'longitude')@continue;@endif

                                @if($setting->key == 'latitude')@continue;@endif

                                @if($setting->key == 'privacy')@continue;@endif

                                @if($setting->key == 'terms')@continue;@endif

                                @if($setting->key == 'about')@continue;@endif

                                @if($setting->key == 'contract')@continue;@endif

                                @if($setting->key == 'contract_content')@continue;@endif
                                @if($setting->key == 'payment_subscribtion')@continue;@endif
                                @if($setting->key == 'about_ar')@continue;@endif
                                @if($setting->key == 'about_en')@continue;@endif
                                @if($setting->key == 'terms_ar')@continue;@endif
                                @if($setting->key == 'terms_en')@continue;@endif
                                @if($setting->key == 'privacy_ar')@continue;@endif
                                @if($setting->key == 'privacy_en')@continue;@endif
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="{{$setting->key}}">

                                        {{__("setting.$setting->key")}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="{{$setting->key}}"

                                               value="{{$setting->value}}"

                                               id="{{$setting->key}}">

                                    </div>

                                </div>

                            @endforeach
                        <fieldset>
                              <legend>{{'Payment subscribtion'}}</legend>

                            <div class="form-group">
                                <div class="col-md-9">
                            <div class="radio">
                              <label><input type="radio" name="{{$settings[20]->key}}" id="{{$settings[20]->key}}"  value="on" 
                                @if($settings[20]->value=='on')
                                checked
                                @endif
                                >On</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="{{$settings[20]->key}}" id="{{$settings[20]->key}}" value="off" 
                                @if($settings[20]->value=='off')
                                checked
                                @endif
                                >Off</label>
                            </div>
                        </div>
                        </div>
                        </fieldset>
                            <fieldset>

                                <legend>{{'Terms and Policies'}}</legend>

                                <!-- <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        {{__("common.".$settings[13]->key)}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[13]->key}}"

                                                      rows="6" required>

                                                {{$settings[13]->value}}

                                            </textarea>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        {{__("common.".$settings[11]->key)}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[11]->key}}"

                                                      rows="6" required>

                                                {{$settings[11]->value}}

                                            </textarea>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        {{__("common.".$settings[12]->key)}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[12]->key}}"

                                                      rows="6" required>

                                                {{$settings[12]->value}}

                                            </textarea>

                                    </div>

                                </div> -->
                                <hr>
                                  <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        about arabic

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[21]->key}}"

                                                      rows="6" required>

                                                {{$settings[21]->value}}

                                            </textarea>

                                    </div>

                                </div>

                                          <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        about english

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[22]->key}}"

                                                      rows="6" required>

                                                {{$settings[22]->value}}

                                            </textarea>

                                    </div>

                                </div>

                                  <hr>
                                  <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        terms arabic

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[23]->key}}"

                                                      rows="6" required>

                                                {{$settings[23]->value}}

                                            </textarea>

                                    </div>

                                </div>

                                          <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        terms english

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[24]->key}}"

                                                      rows="6" required>

                                                {{$settings[24]->value}}

                                            </textarea>

                                    </div>

                                </div>


                                  <hr>
                                  <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        privacy arabic

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[25]->key}}"

                                                      rows="6" required>

                                                {{$settings[25]->value}}

                                            </textarea>

                                    </div>

                                </div>

                                          <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        privacy english

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[26]->key}}"

                                                      rows="6" required>

                                                {{$settings[26]->value}}

                                            </textarea>

                                    </div>

                                </div>


                            </fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        {{__("common.".$settings[18]->key)}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[18]->key}}"

                                                      rows="6" required>

                                                {{$settings[18]->value}}

                                            </textarea>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label class="col-sm-2 control-label">

                                        {{__("common.".$settings[19]->key)}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="{{$settings[19]->key}}"

                                                      rows="6" required>

                                                {{$settings[19]->value}}

                                            </textarea>

                                    </div>

                                </div>



                            
                            <fieldset>

                                <legend>{{__('common.image')}}</legend>

                                <div class="form-group">

                                    <div class="col-md-6 col-md-offset-3">

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image').click()"

                                             style="cursor:pointer">

                                            <img src="{{url($settings[7]->value)}}" id="editImage">

                                        </div>

                                        <label class="control-label">{{__('common.image')}}</label>

                                        <div class="btn red"

                                             onclick="document.getElementById('edit_image').click()">

                                            <i class="fa fa-pencil"></i>{{__('common.change_image')}}

                                        </div>

                                        <input type="file" class="form-control" name="{{$settings[7]->key}}"

                                               id="edit_image"

                                               style="display:none">

                                    </div>

                                </div>

                            </fieldset>

                            <fieldset>

                                <legend>{{('Location')}}</legend>

                                <input id="searchInput" class="input-controls" type="text"

                                       placeholder="Enter a location">

                                <div class="map" id="map" style="width: 100%; height: 300px;"></div>

                                <div class="form_area">

                                    <input type="hidden" name="location" id="location" value="">

                                    <input type="hidden" name="latitude" id="lat" value="{{$settings[9]->value}}">

                                    <input type="hidden" name="longitude" id="lng" value="{{$settings[8]->value}}">

                                </div>

                                <script>

                                    /* script */

                                    function initialize() {

                                        var latlng = new google.maps.LatLng('{{$settings[9]->value}}', '{{$settings[8]->value}}');

                                        var map = new google.maps.Map(document.getElementById('map'), {

                                            center: latlng,

                                            zoom: 10

                                        });

                                        var marker = new google.maps.Marker({

                                            map: map,

                                            position: latlng,

                                            draggable: true,

                                            anchorPoint: new google.maps.Point(0, -29)

                                        });

                                        var input = document.getElementById('searchInput');

                                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                                        var geocoder = new google.maps.Geocoder();

                                        var autocomplete = new google.maps.places.Autocomplete(input);

                                        autocomplete.bindTo('bounds', map);

                                        var infowindow = new google.maps.InfoWindow();

                                        autocomplete.addListener('place_changed', function () {

                                            infowindow.close();

                                            marker.setVisible(false);

                                            var place = autocomplete.getPlace();

                                            if (!place.geometry) {

                                                window.alert("Autocomplete's returned place contains no geometry");

                                                return;

                                            }



                                            // If the place has a geometry, then present it on a map.

                                            if (place.geometry.viewport) {

                                                map.fitBounds(place.geometry.viewport);

                                            } else {

                                                map.setCenter(place.geometry.location);

                                                map.setZoom(17);

                                            }



                                            marker.setPosition(place.geometry.location);

                                            marker.setVisible(true);



                                            bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());

                                            infowindow.setContent(place.formatted_address);

                                            infowindow.open(map, marker);



                                        });

                                        // this function will work on marker move event into map

                                        google.maps.event.addListener(marker, 'dragend', function () {

                                            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {

                                                if (status == google.maps.GeocoderStatus.OK) {

                                                    if (results[0]) {

                                                        bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());

                                                        infowindow.setContent(results[0].formatted_address);

                                                        infowindow.open(map, marker);

                                                    }

                                                }

                                            });

                                        });

                                    }



                                    function bindDataToForm(address, lat, lng) {

                                        document.getElementById('location').value = address;

                                        document.getElementById('lat').value = lat;

                                        document.getElementById('lng').value = lng;

//                                                console.log('location = ' + address);

//                                                console.log('lat = ' + lat);

//                                                console.log('lng = ' + lng);

                                    }



                                    google.maps.event.addDomListener(window, 'load', initialize);

                                </script>

                            </fieldset>





                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">Submit</button>

                                        <a href="{{url(getLocal().'/admin/home')}}" class="btn default">Cancel</a>

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

@section('script')

    <script>

        $('#edit_image').on('change', function (e) {

            readURL(this, $('#editImage'));

        });

    </script>

@endsection

