@extends('layout.app')

@section('title') {{ucwords(__('subscription.title'))}}

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

                              style="color: #e02222 !important;">{{__('common.add')}}{{__('subscription.subscription')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/subscription')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">


                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="user_id">

                                    {{__('common.user')}}

                                    <span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">


                                    <select id="user_id" class="form-control select2" name="user_id"

                                            required>

                                        @foreach($users as $ex)

                                            <option value="{{$ex->id}}" {{ (old("user_id") == $ex->id ? "selected":"") }}>

                                                {{$ex->name}}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>
                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="package_id">

                                    {{__('package.package')}}

                                    <span class="symbol">*</span>

                                </label>

                                <div class="col-md-6">


                                    <select id="package_id" class="form-control select2" name="package_id"

                                            required>

                                        @foreach($packages as $ex)

                                            <option value="{{$ex->id}}" {{ (old("package_id") == $ex->id ? "selected":"") }}>

                                                {{$ex->title}}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>




                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">Submit</button>

                                        <a href="{{url(getLocal().'/admin/subscription')}}" class="btn default">Cancel</a>

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

