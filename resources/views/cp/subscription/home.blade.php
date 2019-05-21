@extends('layout.app')

@section('title') {{ucwords(__('subscription.title'))}}

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

                            <a href="{{url(getLocal().'/admin/subscription/create')}}" style="margin-right: 5px"

                               class="btn sbold green">{{__('common.add')}}

                                <i class="fa fa-plus"></i>

                            </a>

                            <button class="btn sbold blue btn--filter">{{__('common.filter')}}

                                <i class="fa fa-search"></i>

                            </button>

                        </div>

                    </div>

                </div>

                <div class="box-filter-collapse">

                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/subscription')}}">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('common.user')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="{{__('common.user')}}"

                                               placeholder="Enter {{__('common.user')}}">

                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('package.package')}}</label>

                                    <div class="col-md-9">
                                        <select id="package_id" class="form-control select2" name="package_id" required>
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}">{{$package->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn sbold blue">{{__('common.search')}}

                                            <i class="fa fa-search"></i>

                                        </button>

                                        <a href="{{url('admin/subscription')}}" type="submit"

                                           class="btn sbold btn-default ">{{('reset')}}

                                            <i class="fa fa-refresh"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </form>

                </div>

            </div>

            <input type="hidden" id="url" value="{{url("/en/admin/subscription/changeStatus")}}">

            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">

                <thead>

                <tr>

                    <th>



                    </th>
                    <th> {{ucwords(__('common.user'))}}</th>
                    <th> {{ucwords(__('package.package'))}}</th>
                    <th> {{ucwords(__('common.from'))}}</th>
                    <th> {{ucwords(__('common.to'))}}</th>


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
                        <td> {{@$item->user->name}}</td>
                        <td> {{$item->package->title}}</td>
                        <td> {{$item->from}}</td>
                        <td> {{$item->to}}</td>
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

@endsection

@section('script')

    <script>

        function delete_adv(id, e) {

            e.preventDefault();

            swal({

                title: "{{__('common.confirm')}}",

                text: "{{__('subscription.delete_msg')}}",

                icon: "warning",

                buttons: true,

                dangerMode: true

            }).then((willDelete) => {

                if (willDelete) {

                    var url = '{{url(getLocal()."/admin/subscription")}}/' + id;

                    var csrf_token = '{{csrf_token()}}';

                    $.ajax({

                        type: 'DELETE',

                        headers: {'X-CSRF-TOKEN': csrf_token},

                        url: url,

                        success: function (response) {

                            console.log(response);

                            if (response === 'success') {

                                $('#tr-' + id).hide(1000);

                                swal("{{__('subscription.delete_done')}}", {icon: "success"});

                            } else {

                                swal('Error', {icon: "error"});

                            }

                        },

                        error: function (e) {

                            swal('exception', {icon: "error"});

                        }

                    });

                } else {

                    swal("{{__('subscription.delete_cancel')}}");

                }

            });

        }

    </script>

@endsection

