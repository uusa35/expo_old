@extends('layout.app')

@section('title') {{ucwords(__('common.my_profile'))}}

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

                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('common.my_profile')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/update_profile')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">

                           

                            <fieldset>

                                <legend>User name</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="name">

                                       User name

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="name" value="{{$user->name}}" id="name"

                                               placeholder=" {{__('common.name')}}" {{ old('name') }}>

                                    </div>

                                     


                                </div>

                                

                            </fieldset>

<fieldset>

                                <legend>Mobile</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="username">

                                       Mobile

                                    </label>

                                     <div class="col-md-6">

                                        <input type="text" class="form-control" name="mobile" value="{{$user->mobile}}" id="mobile"

                                               placeholder=" {{__('common.mobile')}}" {{ old('mobile') }}>

                                    </div>
                                </div>
                            </fieldset>


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

                                            <img src="{{$user->image}}" id="editImage">

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

                                        <button type="submit" class="btn green">{{__('common.submit')}}</button>
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

