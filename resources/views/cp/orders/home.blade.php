@extends('layout.app')

@section('title') {{ucwords(__('common.order_management'))}}

@endsection

@section('css')

@endsection

@section('content')

    <div class="portlet light bordered">

        <div class="portlet-body">

            <div class="table-toolbar">

                <div class="row">

                    <div class="col-sm-9">

                        <div class="btn-group">

{{--
                            <a href="{{url(getLocal().'/admin/myProduct/create')}}" style="margin-right: 5px"

                               class="btn sbold green">{{__('common.add')}}

                                <i class="fa fa-plus"></i>

                            </a>
--}}

                            <button class="btn sbold blue btn--filter">{{__('common.filter')}}

                                <i class="fa fa-search"></i>

                            </button>

{{--
                            <button class="btn sbold red event" id="delete">{{__('common.delete')}}

                                <i class="fa fa-times"></i>

                            </button>
--}}

                            <button class="btn sbold green event" id="new">{{__('common.new')}}

                                <i class="fa fa-check"></i>

                            </button>

                            <button class="btn sbold default event" id="canceled">{{__('common.canceled')}}

                                <i class="fa fa-minus"></i>

                            </button>

                        </div>

                    </div>

                </div>

                <div class="box-filter-collapse">

                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/orders')}}">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('common.name')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="name"

                                               placeholder="Enter text">

                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('common.date')}}</label>

                                    <div class="col-md-9">

                                        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
                                            <input type="text" name="created_at"class="form-control" readonly>
                                            <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('common.order_id')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="order_id"

                                               placeholder="Enter text">

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn sbold blue">{{__('common.search')}}

                                            <i class="fa fa-search"></i>

                                        </button>

                                        <a href="{{url('admin/orders')}}" type="submit" class="btn sbold btn-default ">{{('reset')}}

                                            <i class="fa fa-refresh"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('common.status')}}</label>

                                    <div class="col-md-9">

                                        <select class="form-control select2" name="status">

                                            <option value="">{{__('common.all')}}</option>
                                            <option value="new">{{__('common.new')}}</option>

                                            <option value="canceled"> {{__('common.canceled')}}</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <input type="hidden" id="url" value="{{url("/en/admin/orders/changeStatus")}}">

            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">

                <thead>

                <tr>

                    <th></th>
                    <th> {{ucwords(__('common.order_id'))}}</th>
                    <th> {{ucwords(__('common.name'))}}</th>
                    <th> {{ucwords(__('common.mobile'))}}</th>
                    <th> {{ucwords(__('common.total'))}} (KD)</th>
                    <th> {{ucwords(__('common.status'))}}</th>
                    <th> {{ucwords(__('common.payment_method'))}}</th>
                    <th> {{ucwords(__('common.created'))}}</th>
                    <th> {{ucwords(__('common.action'))}}</th>

                </tr>

                </thead>

                <tbody>

                @forelse($items as $item)

                    <tr class="odd gradeX" id="tr-{{$item->id}}">

                        <td>

                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">

                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>

                                <span></span>

                            </label>

                        </td>
                        
                        <td> {{$item->order_id}}</td>
                        <td> {{@$item->name}}</td>
                        <td> {{@$item->mobile}}</td>
                        <td> {{$item->total_cost}}</td>
                        <td>

                            <span class="label label-sm <?php echo ($item->status == "New" || $item->status == "new")

                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">

                            {{$item->status}}

                            </span>

                        </td>
                        <td class="center">{{($item->payment_method ==1) ? "Cash" : "Knet"}}</td>
                        <td class="center">{{$item->created_at}}</td>
                        <td>

                            <div class="btn-group btn-action">

                             <a class="btn btn-xs blue tooltips" href="{{url(getLocal().'/admin/order_view/'.$item->id)}}"><i class="fa fa-eye"></i></a>
                                

                            </div>

                        </td>

                    </tr>



                @empty

                    {{__('common.no')}}

                @endforelse

                </tbody>

            </table>

            {{$items->links()}}

        </div>

    </div>

@endsection



@section('js')
    <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/admin_assets/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/admin_assets/assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>

@endsection

@section('script')

    <script>

        function delete_adv(id, e) {

            e.preventDefault();

            swal({

                title: "{{__('common.confirm')}}",

                text: "{{__('product.delete_msg')}}",

                icon: "warning",

                buttons: true,

                dangerMode: true

            }).then((willDelete) => {

                if (willDelete) {

                    var url = '{{url(getLocal()."/admin/myProduct")}}/' + id;

                    var csrf_token = '{{csrf_token()}}';

                    $.ajax({

                        type: 'DELETE',

                        headers: {'X-CSRF-TOKEN': csrf_token},

                        url: url,

                        success: function (response) {

                            console.log(response);

                            if (response === 'success') {

                                $('#tr-' + id).hide(1000);

                                swal("{{__('product.delete_done')}}", {icon: "success"});

                            } else {

                                swal('Error', {icon: "error"});

                            }

                        },

                        error: function (e) {

                            swal('exception', {icon: "error"});

                        }

                    });

                } else {

                    swal("{{__('product.delete_cancel')}}");

                }

            });

        }

    </script>

@endsection

