@extends('layout.app')
@section('title') {{ucwords(__('common.country'))}}
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
                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('common.country')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/country/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="form-body">
                            <fieldset>
                                <legend>{{__('country')}} {{__('common.name')}}</legend>
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
                                    <label class="col-sm-2 control-label" for="currency_id">
                                        {{__('category.currency')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select id="currency_id" class="form-control select2" name="currency_id"
                                                required>
                                            @foreach($currency as $coin)
                                                <option value="{{$coin->id}}" {{ ($coin->id == $item->currency_id ? "selected":"") }}>
                                                    {{$coin->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <fieldset>
                                <legend>{{__('category')}} {{__('common.order')}}</legend>
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

                               <fieldset>
                        <legend>{{__('common.flag_icon')}}</legend>
                        <div class="form-group {{ $errors->has('flag_icon') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-3">
                                @if ($errors->has('flag_icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('flag_icon') }}</strong>
                                    </span>
                                @endif
                                <div class="fileinput-new thumbnail"
                                     onclick="document.getElementById('edit_image').click()"
                                     style="cursor:pointer">
                                    <img src="{{url($item->flag_icon)}}" id="editImage">
                                </div>
                                <label class="control-label">{{__('common.flag_icon')}}</label>
                                <div class="btn red"
                                     onclick="document.getElementById('edit_image').click()">
                                    <i class="fa fa-pencil"></i>{{__('common.change_image')}}
                                </div>
                                <input type="file" class="form-control" name="flag_icon"
                                       id="edit_image"
                                       style="display:none">
                            </div>
                        </div>
                    </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="{{url(getLocal().'/admin/country')}}" class="btn default">Cancel</a>
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
