@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать новый перевод</div>

                    <div class="card-body">
                        <div class="events">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        @php $available_balance = Auth::user()->available_balance @endphp

                        <form id="transfer" method="post" action="">
                            @csrf

                            <div class="form-group">
                                <label for="to_user_id">Кому</label>
                                <select class="form-control" id="to_user_id" name="to_user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Сумма</label>
                                <input class="form-control" id="amount" type="number" name="amount" step="0.01"
                                       min="{{ $available_balance > 0 ? 0.01 : 0 }}" max="{{ $available_balance }}"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input class="form-control" id="date" type="date" name="date"
                                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required/>
                            </div>
                            <div class="form-group">
                                <label for="time">Время</label>
                                <select class="form-control" id="time" name="time" required>
                                    @foreach (range(0, 23) as $hour)
                                        @php $hour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00' @endphp
                                        <option value="{{ $hour }}">{{ $hour }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" {{ $available_balance <= 0 ? 'disabled' : '' }}>Создать
                            </button>
                        </form>
                        <br>

                        <h4>История переводов</h4>

                        <ul class="list-group">
                            @if (!$transfers->isEmpty())
                                @foreach ($transfers as $transfer)
                                    <li class="list-group-item">Перевод на сумму {{ $transfer->amount }} руб.
                                        для {{ $transfer->user->name }} ({{ $transfer->user->email }})<br>
                                        <small>{{ $transfer->status == \App\Transfer::STATUS_WAIT ? 'Ожидает завершения' : 'Завершен' }}</small>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">Нет переводов</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let form = document.querySelector('form#transfer'),
                events = document.querySelector('.events'),
                date = document.getElementById('date'),
                time = document.getElementById('time');

            function alert() {
                let alert = document.createElement('div')
                alert.className = 'alert alert-danger';
                alert.innerText = 'Нельзя запланировать перевод в прошедшем времени';
                setTimeout(() => {
                    alert.remove()
                }, 5000);
                return alert;
            }

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                let currentDate = new Date(),
                    inputDate = new Date(date.value + ' ' + time.value);

                if (inputDate.getTime() <= currentDate.getTime()) {
                    events.appendChild(alert());
                    return false;
                }

                e.target.submit();
            });
        });
    </script>
@endsection