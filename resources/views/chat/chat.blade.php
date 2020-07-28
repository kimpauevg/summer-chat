@extends('layouts.app')
@section('styles')
    <style>
        .messages {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            overflow-y: scroll;
            min-height: 0;
            height: 650px;
        }

        .message-textarea {
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

        .mine .message__sender, .mine .message__text {
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
                            <div class="no-message">
                                Сообщений нет, но вы можете начать первым
                            </div>
                        @else
                            @foreach(array_reverse($messages) as $message)
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
                        <button id="send-message" type="button">
                            Отправить сообщение
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script defer>
        $(document).ready(() => {
            $('.messages').scrollTop(9999);
            Echo.channel('{{$key}}')
                .listen('.NewPrivateMessage', (e) => {
                    console.log('message');
                    console.log(e);

                    if (e.)
                    $('.messages').append(
                        '<div class="' + msg_class + '">' +
                            '<div class="message__sender">' +
                                nickname +
                            '</div>' +
                            '<div class="message__text">' +
                                e.message +
                            '</div>'+
                        '</div>'
                    );
                });
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
            function addMessage(message, mine) {
                let msg_class = 'message';
                let nickname = '{{$profile['nickname']}}';
                if (mine) {
                    msg_class += " mine";
                    nickname = 'Вы';
                }


                $('.messages').append(
                    '<div class="' + msg_class + '">' +
                    '<div class="message__sender">' +
                    nickname +
                    '</div>' +
                    '<div class="message__text">' +
                    e.message +
                    '</div>'+
                    '</div>'
                );

            }
        });
    </script>
@endsection