@extends('layout.app')
@section('title') {{ucwords(__('slider.title'))}}
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
                            <a href="{{url(getLocal().'/admin/slider/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('common.add')}}
                                <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('common.filter')}}
                                <i class="fa fa-search"></i>
                            </button>
                            <button class="btn sbold red event" id="delete">{{__('common.delete')}}
                                <i class="fa fa-times"></i>
                            </button>
                            <button class="btn sbold green event" id="active">{{__('common.active')}}
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn sbold default event" id="not_active">{{__('common.not_active')}}
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/slider')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('common.title')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="title"
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
                                        <a href="{{url('admin/slider')}}" type="submit"
                                           class="btn sbold btn-default ">{{('reset')}}
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
                                            <option value="active">{{__('common.active')}}</option>
                                            <option value="not_active"> {{__('common.not_active')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url("/en/admin/slider/changeStatus")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                    </th>
                    <th> {{ucwords(__('common.title'))}}</th>
                    <th> {{ucwords(__('common.image'))}}</th>
                    <th> {{ucwords(__('common.status'))}}</th>
                    <th> {{ucwords(__('common.createdBy'))}}</th>
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
                        <td> {{$item->title}}</td>
                        <td>
                            <img src="{{$item->image}}" width="50px" height="50px">
                        </td>
                        <td>
                            <span class="label label-sm <?php echo ($item->status == "Active")
                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">
                            {{$item->status}}
                            </span>
                        </td>
                        <td class="center">{{@$item->user->name}}</td>
                        <td class="center">{{$item->created_at}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/admin/slider/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('common.edit')}}"><i class="fa fa-edit"></i></a>
                                <a href="#" onclick="delete_adv('{{$item->id}}',event)"
                                   data-placement="top" class="btn btn-xs red tooltips"
                                   data-original-title="{{__('common.delete')}}"><i class="fa fa-times"
                                                                                    aria-hidden="true"></i></a>
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
@endsection
@section('script')
    <script>
        function delete_adv(id, e) {
            e.preventDefault();
            swal({
                title: "{{__('common.confirm')}}",
                text: "{{__('slider.delete_msg')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var url = '{{url(getLocal()."/admin/slider")}}/' + id;
                    var csrf_token = '{{csrf_token()}}';
                    $.ajax({
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        url: url,
                        success: function (response) {
                            console.log(response);
                            if (response === 'success') {
                                $('#tr-' + id).hide(1000);
                                swal("{{__('slider.delete_done')}}", {icon: "success"});
                            } else {
                                swal('Error', {icon: "error"});
                            }
                        },
                        error: function (e) {
                            swal('exception', {icon: "error"});
                        }
                    });
                } else {
                    swal("{{__('slider.delete_cancel')}}");
                }
            });
        }
    </script>
@endsection
