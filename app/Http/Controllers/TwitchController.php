<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\DataStream;

class TwitchController extends Controller
{
    const CLIENT_ID = 'bln67rp9s9t862x2511gwerafd9yim';
    const LIMIT = 50;

    protected $client;

    public function __construct()
    {
        $this->client = new Client(['headers' => 
        [
            'Accept' => 'application/vnd.twitchtv.v5+json',
            'Client-ID'=> self::CLIENT_ID]
        ]);
    }
    //
    /**
     * Метод для поиска игры
     * 
     * @param Request $request
     * @return array Возвращает массив с найденными играми
     */
    public function findGame(Request $request)
    {
        $arr = [];
        $res = $this->client->request('GET', 'https://api.twitch.tv/kraken/search/games?query='.$request->get('q'));
        $return = json_decode($res->getBody());
        foreach($return->games as $r){
            $arr[] = ['id'=>$r->_id,'name'=>$r->name,'thumb'=>$r->box->small];
        }

        return $arr;
    }

    public function getStreams()
    {
        $gameModel = new \App\Game;
        #$dataModel = new \;
        $needGames = [];
        $page = '';
        $url = "https://api.twitch.tv/helix/streams?first=".self::LIMIT."&type=live";

        # получаем игры, которые добавлены для отслеживания
        foreach($gameModel->allGames() as $game) {
            $needGames[] = "game_id={$game->game_id}";
        }
        
        if(empty($needGames))
        {
            Log::info('Игры не выбраны'); 
            return; 
        }
        $url = "{$url}&".implode('&',$needGames);

        do
        {
            # генерациция url с проверкой страницы
            $urlPage = (isset($return->pagination->cursor)) ? "{$url}&after={$return->pagination->cursor}" : $url;
            $res = $this->client->request('GET',$urlPage);
            $return = json_decode($res->getBody());
            # обработка стримов
            $addStats = [];
            foreach($return->data as $stream) {
                $addStats = [
                    'stream_id' => $stream->user_id,
                    'game_id' => $stream->game_id,
                    'service' => 'T',
                    'viewers' => $stream->viewer_count
                ];
                DataStream::create($addStats);
            }
            #if(!empty($addStats)) DataStream::create($addStats);
            #print_r($addStats);
        } while(isset($return->pagination->cursor));
        #print_r($return);
    }
}
