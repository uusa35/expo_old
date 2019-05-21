@extends('layout.app')
@section('title') {{ucwords(__('common.message'))}}
@endsection
@section('css')
    <style>

        .cor {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .cor::after {
            content: "";
            clear: both;
            display: table;
        }

        .cor img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .cor img.right {
            float: right;
            margin-left: 20px;
            margin-right: 0;
        }

        .time-right {
            float: right;
            color: #aaa;
        }

        .time-left {
            float: left;
            color: #999;
        }
    </style>
@endsection
@section('content')

<?php
/*$contacts = \App\Models\MessageContact::query()->where('sender_id', 238)
            ->orWhere('receiver_id', 238)->with('sender', 'receiver')->get();
        foreach ($contacts as $contact) {
            if ($contact->sender_id == auth('api')->id()) {
                $contact->contact = $contact->receiver;
            } else {
                $contact->contact = $contact->sender;
            }
            unset($contact->sender);
            unset($contact->receiver);
            $ids = [$contact->contact->id, auth('api')->id()];
            $contact->last_message = \App\Models\Message::query()->where('message_contact_id', $contact->id)->get()->last();
        }*/
        
        ?>
       
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"
                              style="color: #e02222 !important;">{{__('common.add')}}{{__('common.message')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/messages')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        <input type="hidden" name="user_id" value="{{request()->user_id}}">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <fieldset>
                                <legend>{{__('layout.message')}}</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="message">
                                        {{__('layout.message')}}
                                    </label>
                                    <div class="col-md-6">
                                                    <textarea class="form-control" name="message" rows="5"
                                                              id="message"></textarea>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    
                        @foreach($contacts as $contact)
                        
                        @if($contact->sender_id == auth()->user()->id)
                         <div class="cor">
                                    <img src="{{auth()->user()->image}}" alt="Avatar"
                                         class="left" style="width:100%;">
                                    <p>{{$contact->message}}</p>
                                    <span class="time-right">{{$contact->created_at}}</span>

                                </div>
                        
                        @else
                    
                                <div class="cor">
                                    <img src="{{admin_assets('/layouts/layout4/img/avatar1.jpg')}}" alt="Avatar"
                                         class="left" style="width:100%;">
                                    @if($contact->message)
                                    <p>{{$contact->message}}</p>
                                    @endif
                                    
                                    @if($contact->image)
                                    <img src="{{$contact->image}}"
                                        style="max-width:150px;">
                                        @endif
                                    <span class="time-right">{{$contact->created_at}}</span>

                                </div>
                                @endif
                        @endforeach
                    
                </div>
                <div class="portlet-body form">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
@section('script')

@endsection
