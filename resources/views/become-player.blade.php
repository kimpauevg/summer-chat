@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Become a player!</div>

                    <div class="card-body">
                        Just write your nickname and start playing.
                        <form id="create-form" action="{{route('player.store')}}" class="form" method="post"  >
                            <input type="text" name="nickname">
                            @csrf
                            <button id="submit" type="button">START</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script defer>
        $( document ).ready(() => {
            console.log('fuk');
            $('#submit').click(() => {
                let form = $('#create-form')
                let data = form.serializeArray();
                console.log(data);
                console.log(form.attr('action'));
                $.post(
                    form.attr('action'),
                    data,
                    function(data) {
                        console.log(data)
                        if (data.message === 'success') {
                            window.location.href = '{{route('profile.index')}}';
                        }
                    }
                );
            })

        });
    </script>
@endsection