@extends('layout.app')
@section('title') {{ucwords(__('common.edit_admin'))}}
@endsection
@section('css')

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
                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('common.admins')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="form_category" method="post" action="{{url(app()->getLocale().'/admin/admins/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}

                        <div class="form-body">

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('common.name')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control"  value="{{ $item->name }}"
                                               placeholder=" {{__('common.name')}}" {{ old('name') }} required>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('common.email')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" name="email" value="{{ $item->email }}"
                                               placeholder=" {{__('common.email')}}" {{ old('email') }} required>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('common.admin_type')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="admin_type">
                                            <option {{ $item->type==1 ? 'selected' : ''}} value="1">{{__('common.Admin')}}</option>
                                            <option {{ $item->type==2 ? 'selected' : ''}} value="2">{{__('common.Sub_Admin')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('common.mobile')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="mobile" value="{{ $item->mobile }}"
                                               placeholder=" {{__('common.mobile')}}" {{ old('mobile') }} required>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
                                    <label class="col-sm-2 control-label">
                                        {{__('common.role')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" id="permissions" name="permissions[]"
                                                multiple="multiple" required>


                                            @foreach($role as$roleItem)
                                                <option value="{{$roleItem->roleSlug}}" @if(in_array($roleItem->roleSlug,$userRoleItem)) selected @endif>{{$roleItem->name}}</option>

                                            @endforeach



                                        </select>
                                    </div>
                                </div>
                            </fieldset>



                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('common.submit')}}</button>
                                        <a href="{{url(getLocal().'/admin/admins')}}" class="btn default">{{__('common.cancel')}}</a>
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



        var FormValidation = function () {

            // basic validation
            var handleValidation1 = function () {
                // for more info visit the official plugin documentation:
                // http://docs.jquery.com/Plugins/Validation

                var form1 = $('#form_category');
                var error1 = $('.alert-danger', form1);
                var success1 = $('.alert-success', form1);

                form1.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",  // validate all fields including form hidden input
                    messages: {
                        select_multi: {
                            maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                            minlength: jQuery.validator.format("At least {0} items must be selected"),
                        },
                    },
                    rules: {
                        title_ar: {required: true},
                        title_en: {required: true},
                        logo: {required: true},
                    },

                    invalidHandler: function (event, validator) { //display error alert on form submit
                        success1.hide();
                        error1.show();
                        App.scrollTo(error1, -200);
                    },


                    highlight: function (element) { // hightlight error inputs

                        $(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },

                    success: function (label) {
                        label
                            .closest('.form-group').removeClass('has-error'); // set success class to the control group
                    },

                    submitHandler: function (form) {
                        success1.show();
                        error1.hide
                        e.submit()
                    }
                });


            };


            return {
                //main function to initiate the module
                init: function () {

                    handleValidation1();

                }

            };

        }();

        jQuery(document).ready(function () {
            FormValidation.init();
        });


    </script>
@endsection
