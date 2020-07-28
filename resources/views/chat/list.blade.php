@extends('layouts.app')
@section('styles')
    <style>
        .profile-row {
            padding: 10px;
            border: 4px groove black;
            margin-bottom: 5px;
        }
        .profile-row > a {
            color: initial;
        }
        .profile-row:last-child{
            margin-bottom: 0;
        }
        .profile-cell__text{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card chat">
                    <div class="card-header">Ваши чаты</div>

                    <div class="card-body">
                        <div class="table">
                            @if(empty($chats))
                                <div>
                                    У вас нет чатов :(
                                </div>
                            @else
                                @foreach($chats as $dialog)
                                    <div class="profile-row" data-user-id="{{$dialog->companion_id}}">
                                        <a href="{{route('chat.show', ['chat' => $dialog->companion_id])}}">
                                            <div class="profile-cell__name">
                                                {{$dialog->nickname}}
                                            </div>
                                            <div class="profile-cell__text">
                                                {{$dialog->message}}
                                            </div>

                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection