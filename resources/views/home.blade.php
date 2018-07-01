@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Пользователи и их последие переводы</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul class="list-group">
                            @foreach ($users as $user)
                                <li class="list-group-item">{{ $user->name }} ({{ $user->email }})<br>
                                    @if(!is_null($user->to_user_id))
                                        <small>Перевод на сумму {{ $user->amount }} руб. для {{ $user->to_name }}
                                            ({{ $user->to_email }})<br>
                                            {{ $user->status == \App\Transfer::STATUS_WAIT ? 'Ожидает завершения' : 'Завершен' }}
                                        </small>
                                    @else
                                        <small>Переводов нет</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
