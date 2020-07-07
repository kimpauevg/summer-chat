@extends('layouts.app')
@section('content')
    {{(json_encode($profile))}}
    {{\Illuminate\Support\Facades\Auth::id()}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Информация о профиле</div>

                <div class="card-body">
                    <div class="table">
                        @foreach($profile as $name => $field)
                            <div class="profile-row">
                                <div class="profile-cell__name">
                                    {{$name}}
                                </div>
                                <div class="profile-cell__text">
                                    {{$field}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(Auth::id() != $profile['user_id'])
                    <button>Начать чат</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .profile-row {
            display: table-row;
        }
        .profile-row > div {
            display: table-cell;
        }
        .profile-cell__name  {
            font-size: 30px;
        }
        .profile-cell__name:after  {
            content: ":";
            font-size: 30px;
        }

        .profile-cell__text {
            font-size: 25px;
        }
    </style>

@endsection