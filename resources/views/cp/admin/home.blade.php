@extends('layout.app')
@section('title') {{ucwords(__('common.title_admin'))}}
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
                            <a href="{{url(app()->getLocale().'/admin/admins/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('common.add')}}
                                <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('common.filter')}}
                                <i class="fa fa-search"></i>
                            </button>
                        <!--<button class="btn sbold red event" id="delete">{{__('common.delete')}}-->
                            <!--    <i class="fa fa-times"></i>-->
                            <!--</button>-->
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
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/admins')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('common.email')}}</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="email"
                                               placeholder="{{__('common.email')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('common.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url(app()->getLocale().'/admin/admins')}}" type="submit"
                                           class="btn sbold btn-default ">{{__('common.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('common.mobile')}}</label>
                                    <div class="col-md-9">
                                        <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text" class="form-control" name="mobile"
                                               placeholder="{{__('common.mobile')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url(app()->getLocale()."/admin/admins/changeStatus")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>

                    </th>
                    <th> {{ucwords(__('common.full_name'))}}</th>
                    <th> {{ucwords(__('common.email'))}}</th>
                    {{--<th> {{ucwords(__('common.image'))}}</th>--}}
                    <th> {{ucwords(__('common.mobile'))}}</th>

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
                        <td> {{$item->name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                        <td> {{$item->mobile}}</td>

                        <td class="center">{{$item->created_at}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/admin/admins/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('common.edit')}}"><i class="fa fa-edit"></i></a>

                                <a href="{{url(getLocal().'/admin/admins/'.$item->id.'/edit_password')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('common.edit_password')}}"><i class="fa fa-expeditedssl"></i></a>

                                <a data-placement="top" data-original-title="{{__('common.delete')}} "
                                   href="#myModal{{$item->id}}" role="button" data-toggle="modal"
                                   class="btn btn-xs red tooltips">
                                    &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                                <div id="myModal{{$item->id}}" class="modal fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                <h4 class="modal-title">{{__('common.delete')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{__('common.confirm')}} </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn default" data-dismiss="modal"
                                                        aria-hidden="true">{{__('common.cancel')}}</button>
                                                <a href="#" onclick="delete_adv('{{$item->id}}','{{$item->id}}',event)">
                                                    <button class="btn btn-danger">{{__('common.delete')}}</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>




                        </td>
                    </tr>

                @empty
                    {{__('common.no')}}
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
@endsection
@section('script')
    <script>


        function delete_adv(id, iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/admin/admins")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method: 'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#tr-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                        //swal("القضية حذفت!", {icon: "success"});
                    } else {
                        // swal('Error', {icon: "error"});
                    }
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });

        }
    </script>
    <script>

        var IDArray = [];
        $("input:checkbox[name=chkBox]:checked").each(function () {
            IDArray.push($(this).val());
        });
        if (IDArray.length == 0) {
            $('.event').attr('disabled', 'disabled');
        }
        $('.chkBox').on('change', function () {

            var IDArray = [];
            $("input:checkbox[name=chkBox]:checked").each(function () {
                IDArray.push($(this).val());
            });
            if (IDArray.length == 0) {
                $('.event').attr('disabled', 'disabled');
            } else {
                $('.event').removeAttr('disabled');
            }
        });
        $('.event').on('click', function () {
            var event = $(this).attr('id');
            //alert(event);
            var url = $('#url').val();
            // alert(url);
            var csrf_token = '{{csrf_token()}}';
            var IDsArray = [];
            $("input:checkbox[name=chkBox]:checked").each(function () {
                IDsArray.push($(this).val());
                //alert(IDsArray);
            });

            if (IDsArray.length > 0) {
                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    url: url,
                    data: {event: event, IDsArray: IDsArray, _token: csrf_token},
                    success: function (response) {
                        if (response === 'active') {
                            //alert('fsvf');
                            $.each(IDsArray, function (index, value) {
                                $('#label-' + value).removeClass('label-danger');
                                $('#label-' + value).addClass('label-info');
                                $r = '{{app()->getLocale()}}';
                                if($r == 'ar'){
                                    $('#label-' + value).text('فعال ');
                                }else{
                                    $('#label-' + value).text('active');

                                }
                            });
                        } else if (response === 'not_active') {
                            //alert('fg');
                            $.each(IDsArray, function (index, value) {
                                $('#label-' + value).removeClass('label-info');
                                $('#label-' + value).addClass('label-danger');
                                $r = '{{app()->getLocale()}}';
                                if($r == 'ar'){
                                    $('#label-' + value).text('غير فعال');
                                }else{
                                    $('#label-' + value).text('Not Active');

                                }
                            });
                        } else if (response === 'delete') {
                            $.each(IDsArray, function (index, value) {
                                $('#tr-' + value).hide(2000);
                            });
                        }

                    },
                    fail: function (e) {
                        alert(e);
                    }
                });
            } else {
                alert('{{__('common.not_selected')}}');
            }
        });

        function readURL(input, target) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    target.attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        
        $('.btn--filter').click(function () {
            $('.box-filter-collapse').slideToggle(500);
        });

    </script>
@endsection
