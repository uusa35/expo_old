@extends('layout.app')
@section('title') {{ucwords(__('common.city'))}}
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
                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('common.city')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/city/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="form-body">
                            <fieldset>
                                <legend>{{__('common.name')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">
                                        {{__('common.name')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" value="{{$item->name}}" id="name"
                                               placeholder=" {{__('common.name')}}" {{ old('name') }}>
                                    </div>
                                </div>
                            </fieldset>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="country_id">
                                        {{__('common.country')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select id="country_id" class="form-control select2" name="country_id"
                                                required>
                                            @foreach($country as $c)
                                                <option value="{{$c->id}}" {{ ($c->id == $item->country_id ? "selected":"") }}>
                                                    {{$c->name}}
                                                </option>
                                            @endforeach
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
                                        <input type="text" class="form-control" name="order" value="{{$item->order_by}}"
                                               id="order">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/city')}}" class="btn default">Cancel</a>
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
