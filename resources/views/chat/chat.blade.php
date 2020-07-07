@extends('layouts.app')
@section('styles')
    <style>
        .messages {
            display: flex;
            flex-direction: column-reverse;
        }
        .message-textarea{
            width: 100%;
            resize: none;
        }
        .message__sender {
            font-weight: bold;
        }
        .message {
            border: black 1px;
            width: 100%;
            padding: 10px;
        }
        .mine .message__sender, .mine .message__text{
            text-align: right;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Чат с {{$profile['nickname']}}</div>
                    <div class="card-body messages">
                        @if(empty($messages))
                            Сообщений нет, но вы можете начать первым
                        @else
                            @foreach($messages as $message)
                                @if($message->player_id == $profile['player_id'])
                                    <div class="message">
                                        <div class="message__sender">
                                            {{$message->nickname}}
                                        </div>
                                        <div class="message__text">
                                            {!! nl2br(e($message->message)) !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="mine message">
                                        <div class="message__sender">
                                            Вы
                                        </div>
                                        <div class="message__text">
                                            {!! nl2br(e($message->message)) !!}
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="card-body">
                        <textarea class="message-textarea">
                        </textarea>
                        <button id="send-message" type="button">Отправить сообщение</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script defer>
        $( document ).ready(() => {
            $('#send-message').click(function () {
                let message = ($(this).siblings('textarea')[0].value);
                console.log(message)
                if (message !== '') {
                    $.post(
                        '{{route('comment.store', [
                            'another_player_id' => $another_player_id
                        ])}}',
                        {
                            'comment': message,
                            '_token': '{{csrf_token()}}'
                        },
                        function (data) {
                            console.log(data)
                        }
                    );
                    console.log('should send')
                }
            })
        });
    </script>
@endsection