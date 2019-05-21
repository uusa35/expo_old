@extends('layout.app')

@section('title') {{ucwords(__('common.order_details'))}}

@endsection

@section('css')

@endsection

@section('content')
<div class="portlet light bordered">
<span><b>{{__('common.customer_name')}} </b>: {{$items{0}->user_order->name}}</b><br /><br /></span>
<span><b>{{__('common.email')}} </b>: {{$items{0}->user_order->email}}</b><br /><br /></span>
<span><b>{{__('common.mobile')}} </b>: {{$items{0}->user_order->mobile}}</b><br /><br /></span>
<span><b>{{__('common.address')}} </b>: {{$items{0}->user_order->address}}</b><br /><br /></span>
        <div class="portlet-body">
            
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
    
              <thead>

                <tr>

                    <th>#</th>
                    <th> {{ucwords(__('common.expo'))}}</th>
                    <th> {{ucwords(__('common.name'))}}</th>
                    <th> {{ucwords(__('image'))}}</th>
                    <th> {{ucwords(__('size'))}}</th>
                    <th> {{ucwords(__('color'))}}</th>
                    <th> {{ucwords(__('material'))}}</th>
                    <th> {{ucwords(__('price'))}}</th>
                    <th> {{ucwords(__('quantity'))}}</th>
                    <th> {{ucwords(__('total'))}}</th>
                </tr>

                </thead>

                <tbody>

                @forelse($items as $item)

                    <tr class="odd gradeX" id="tr-{{$item->id}}">

                        <td>{{$loop->iteration}}</td>

                        <td>{{$item->order_expo->name}} </td>
                        <td>{{$item->product_details{0}->title}} </td>

                          <td>
                            <img src="{{$item->product_details{0}->cover_image}}" width="50px" height="50px">
                           </td>

                          <td> {{@$item->size['name']}}</td>
                          <td><span><div style="width:30px; height:30px; background-color:#{{@$item->color->color}}"></div></span></td>
                          <td> {{@$item->material['name']}}</td>
                          <td> {{$item->price}}</td>
                          <td> {{$item->quantity}}</td>
                          <td> {{$item->total}}</td>
                    </tr>



                @empty

                    {{__('common.no')}}

                @endforelse

                </tbody>

            </table>
            
            </div></div>
            
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="{{url()->previous()}}" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
@endsection