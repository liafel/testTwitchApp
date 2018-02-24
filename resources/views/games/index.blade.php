<!-- resources/views/games/index.blade.php -->

@extends('layouts.app')

@section('content')


  <div class="panel-body">
    <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    <!-- Форма добавления новой игры для отслеживания -->
    <form action="{{ url('game') }}" method="POST" class="form-horizontal">
      {{ csrf_field() }}
      
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="search-game" placeholder="Название игры" aria-describedby="basic-addon2" name="name">
        <input type="hidden" name="game_id" id="gameId">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Добавить игру</button>
        </div>
      </div>

    </form>

    @if (count($games) > 0)
    <table class="table table-striped game-table">
    <thead>
    <th>Игра</th>
    <th>&nbsp;</th>
    </thead>

    <tbody>
    @foreach ($games as $game)
        <tr>
        <!-- игра -->
        <td class="table-text">
            <div>{{ $game->name }} [<strong>ID: {{ $game->game_id }}</strong>]</div>
        </td>

        <td>
            <!-- del -->
            <form action="{{ url('game/'.$game->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button type="submit" id="delete-game-{{ $game->id }}" class="btn btn-danger">
                Удалить
            </button>
            </form>
        </td>
        </tr>
    @endforeach
    </tbody>
    </table>
    @endif
  </div>

  <!-- Добавленные игры -->
@endsection