@extends('layout.app')
@section('title') {{ucwords(__('layout.my_messages'))}}
@endsection
@section('css')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="message">
            <div class="row col-md-10">
            @if(!empty($items))
            @foreach($items->message as $item)
            <div style="height: 70px;margin-bottom: 20px;
            @if($item->sender_admin==1)
                    background-color: #4661f7;
            @else
                    background-color: #9e9e9e;text-align: right;
            @endif
            " class="content col-md-12">
                @if($item->sender_admin==1)
                    <label style="color:white">admin</label>
                @else
                    <label  style="color:white" >you</label>
                @endif
                <p>  {{$item->message}}</p>
            </div>
            @endforeach
           @endif
            </div>
            {{--<div class="row">--}}

            {{--<div style="height: 70px;background-color: #9e9e9e;margin-left: 30%;text-align: right;" class="content col-md-6">--}}
                {{--<p> test</p>--}}

            {{--</div>--}}
            {{--</div>--}}

        </div>

    </div>

</div>

@endsection

@section('js')
@endsection
