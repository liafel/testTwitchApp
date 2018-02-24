<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    protected $model;

    /**
     * Отображение списка добавленных игр
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->model = new Game;

        return view('games.index',[
            'games' => $this->model->allGames(),
            ]);
    }

    /**
     * Добавление игры для отслеживания
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
             'name' => 'required|max:255',
             'game_id' => 'required|integer'
        ]);
        
        Game::create([
            'name' => $request->name,
            'game_id' => $request->game_id
        ]);
    
        return redirect('/games');
    }

    /**
     * Метод для поиска игры
     * 
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $twitch = new TwitchController();
        $return = $twitch->findGame($request);
        return response()->json($return);
    }

    /**
     * Удалить игру.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
    */
    public function destroy(Request $request, Game $game)
    {
        $game->delete();

        return redirect('/games');
    }
}
