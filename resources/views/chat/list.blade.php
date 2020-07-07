@extends('layouts.app')
@section('styles')
    <style>
        .chat{

        }
    </style>
@endsection
@section('content')
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
                                <div class="profile-row">
                                    <div class="profile-cell__name">
                                        {{$dialog['id']}}
                                    </div>
                                    <div class="profile-cell__text">
                                        {{$dialog['message']}}
                                    </div>
                                </div>
                            @endforeach
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection