@extends('layout.app')

@section('title') {{ucwords(__('product.title'))}}

@endsection

@section('css')

@endsection

@section('content')
<style>
    .myCheckbox{
        border:2px solid black;
        
    }
    .choosColor
    {
        height: 25px; width: 25px; display: inline-block; cursor:pointer; margin: 10px;
    }
</style>

    <div class="row">

        <div class="col-md-12">

            <!-- BEGIN SAMPLE FORM PORTLET-->

            <div class="portlet light bordered">

                <div class="portlet-title">

                    <div class="caption">

                        <i class="icon-settings font-dark"></i>

                        <span class="caption-subject font-dark sbold uppercase"

                              style="color: #e02222 !important;">{{__('common.edit')}}{{__('product.product')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/myProduct/'.$item->id)}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        {{ method_field('PATCH')}}

                        <div class="form-body">

                            <fieldset>

                                <legend>{{__('product.product')}}{{__('common.title')}}</legend>

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

                                <legend>{{__('product.product')}}{{__('common.order')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                        {{__('common.order')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="order" value="{{$item->order_by}}"

                                               id="order">

                                    </div>

                                </div>

                                {{--<div class="form-group">

                                    <label class="col-sm-2 control-label" for="highlight">

                                        {{__('product.highlight')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="checkbox" class="make-switch" name="highlight"

                                               id="highlight" data-size="small"

                                                {{ ($item->highlight == "1" ? "checked":"") }} >

                                    </div>

                                </div>--}}

                            </fieldset>

                            <fieldset>

                                <legend>{{__('product.product')}}{{__('common.details')}}</legend>

                               <div class="form-group">

                                    <label class="col-sm-2 control-label" for="is_sale">

                                        {{__('product.slaes')}}

                                    </label>

                                    <div class="col-md-6">

                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                <input type="radio" name="is_sale"
                                                       id="is_sale_yes" value="on"
                                                       {{ ($item->discount_percentage) ? 'checked' : ''}} required> {{__('yes')}}
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="is_sale"
                                                       id="is_sale_no" value=""
                                                        {{ ($item->discount_percentage == '') ? 'checked' : ''}}> {{__('no')}}
                                                <span></span>
                                            </label>
                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="discount">

                                        {{__('common.discount')}} %

                                        <span class="symbol" id="discount_label" style="display: none">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="discount" value="{{$item->discount_percentage}}"

                                               id="discount"

                                               placeholder=" {{__('common.discount')}}">

                                    </div>

                                </div>
                                
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="price">

                                        {{__('product.old_price')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="old_price"

                                               value="{{$item->old_price}}"

                                               id="old_price" disabled

                                               placeholder=" {{__('product.old_price')}}">

                                    </div>

                                </div>
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="price">

                                        {{__('common.price')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="price"

                                               value="{{$item->current_price}}"

                                               id="price" required

                                               placeholder=" {{__('common.price')}}">

                                    </div>

                                </div>

                               <div class="form-group">

                                    <label class="col-sm-2 control-label" for="quantity">

                                        {{__('common.quantity')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="quantity" value="{{$item->quantity}}"

                                               id="quantity" required

                                               placeholder=" {{__('common.quantity')}}">

                                    </div>

                                </div>

                                

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="category_id">

                                        {{__('common.category')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <select id="multiple" class="form-control select2-multiple" name="category_id[]" multiple>

                                               

                                            @foreach($categories as $category)

                                                <option value="{{$category->id}}" {{ (in_array($category->id,$p_categories)? "selected":"") }} >

                                                    {{$category->title}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>



                          



                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="clothing_id">

                                        {{__('common.clothing_types')}}

                                    </label>

                                    <div class="col-md-6">

                                          <select id="multiple" class="form-control select2-multiple" name="clothing_id[]" multiple>

                                            @foreach($clothing_types as $item2)

                                                <option value="{{$item2->id}}" {{ (in_array($item2->id,$p_clothing_types)? "selected":"") }} >

                                                    {{$item2->name}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="size_id">

                                        {{__('common.sizes')}}

                                    </label>

                                    <div class="col-md-6">

                                         <select id="multiple" class="form-control select2-multiple" name="size_id[]" multiple>

                                            @foreach($sizes as $item3)

                                                <option value="{{$item3->id}}" {{ (in_array($item3->id,$p_sizes)? "selected":"") }}>

                                                    {{$item3->name}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="material_id">

                                        {{__('common.materials')}}

                                    </label>

                                    <div class="col-md-6">

                                        <select id="multiple" class="form-control select2-multiple" name="material_id[]" multiple>

                                            @foreach($materials as $item4)

                                                <option value="{{$item4->id}}" {{ (in_array($item4->id,$p_materials)? "selected":"") }}>

                                                    {{$item4->name}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="color">

                                        {{__('common.colors')}}

                                    </label>

                                    <div class="col-md-6">
                                        
                                        @foreach($colors as $item2)
                                            <?php
                                            $cls = in_array($item2->id,$p_colors) ? 'myCheckbox' :'' ;
                                            
                                            $chk = in_array($item2->id,$p_colors) ? 'checked' :'' ;
                                            ?>
                                        
                                        <div class="choosColor {{$cls}}" style="background-color:#{{$item2->color}}">
                                                
                                            <input type="checkbox" name="colors[]" {{$chk}} value="{{$item2->id}}" style="display:none;">
                                            </div>

                                            @endforeach
                                            
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset>

                                <legend>{{__('product.product')}}{{__('common.details')}}</legend>

                                @foreach($locales as $locale)

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">

                                            {{__('common.details')}} {{$locale->name}}

                                            <span class="symbol">*</span>

                                        </label>

                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" name="details_{{$locale->lang}}"

                                                      rows="6" required>

                                                {{isset($item->translate($locale->lang)->details)?$item->translate($locale->lang)->details:""}}

                                            </textarea>

                                        </div>

                                    </div>

                                @endforeach

                            </fieldset>

                            <fieldset>

                                <legend>{{__('common.image')}}</legend>

                                <div class="form-group">

                                    <div class="col-md-6 col-md-offset-3">

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image').click()"

                                             style="cursor:pointer">

                                            <img src="{{url($item->cover_image)}}" id="editImage">

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
                                <legend>Product Images</legend>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="product_images">
                                        Product Images
                                    </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="product_images[]" multiple
                                               id="product_images">
                                        @if ($errors->has('product_images'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('product_images') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                        <fieldset>
                        <div class="input_fields_wrap">
                            <button type="button" style="margin-bottom: 10px;;" class="add_field_button btn green col-md-2">Add Video URL</button>
                            @foreach($videos as $video)
                            <input type="text" class="col-md-10" style="margin-left: 10%;height: 35px;margin-bottom: 10px;" name="product_videos[]" value="{{$video->image}}">
                            @endforeach
                            <input type="text" class="col-md-10" style="margin-left: 10%;height: 35px;" name="product_videos[]">
                        </div>
                        </fieldset>




                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">Submit</button>

                                        <a href="{{url(getLocal().'/admin/myProduct')}}" class="btn default">Cancel</a>

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


    <script type="text/javascript">
            var x = 1; //initlal text box count

  $('.add_field_button').click(function(e){ //on add input button click
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        
        
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div calss="col-md-10" ><input type="text" calss="col-md-12" style="width: 83.5%;margin-left: 10%;height: 35px;margin-top:5px;" name="product_videos[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
     });
     
     $(document).on("click", "#is_sale_no", function () {
            $('#discount_label').hide();
            $('#discount').removeAttr('required');
            $('#discount').val('0');
        });
        $(document).on("click", "#is_sale_yes", function () {
            $('#discount_label').show();
            $('#discount').attr('required', 'required');
        });
        
     
     $(document).on("click", ".choosColor", function () {
            
            if($(this).find('input').is(':checked')) {
                $(this).find('input').attr('checked', false);
                $(this).removeClass('myCheckbox');
            }
            else
            {
                $(this).find('input').attr('checked', true);
                $(this).addClass('myCheckbox');
            }
           
        });

    </script>

@endsection

