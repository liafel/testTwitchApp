<?php

namespace App\Http\Controllers;

use App\DataStream;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class ApiController extends Controller
{
    
    //
    public function index(Request $request)
    {
        $model = new DataStream;
        $arr = parse_url($request->fullUrl());
        
        if(empty($arr['query'])) {
            return response()->json([
                'message' => 'Zero params',
            ], 404);
        }
        $output = $this->parse_query2array($arr['query']);
        

        $validator = Validator::make($output, [
            'type'=>'required|in:streams,viewers',
            'game_id'=>'array',
            'date_from'=>'date|date_format:Y-m-d',
            'date_to'=>'date|date_format:Y-m-d|before_or_equal:today'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Wrong params. Bad request for api',
            ], 400);
        }
        
        #if(empty($output['type'])) $output['type'] = 'streams';
        $data = $model->getData($output);

        return response()->json($data, 200);
    }

    /**
     * Метод обрабатывает строку параметров и возвращает массив
     * Метод необходим, т.к. в php нет стандартной функции, которая 
     * корректно обрабатывает строку запросов с одинаковыми параметрами, 
     * например game_id=123&game_id=456&game_id=789
     * 
     * @param string $str строка с параметрами
     * @return array 
     */
    public function parse_query2array(string $str) {
        $arr = array();
        // разрешенные параметры
        $allowParams = ['date_from','date_to','game_id','type'];
        $pairs = explode('&', $str);
      
        foreach ($pairs as $i) {
          list($name,$value) = explode('=', $i, 2);

          if(!in_array($name,$allowParams)) continue;
          
          if( isset($arr[$name]) ) {
            if( is_array($arr[$name]) ) {
              $arr[$name][] = trim($value);
            }
            else {
              $arr[$name] = array($arr[$name], $value);
            }
          }
          else {
            $arr[$name] = trim($value);
          }
        }
        
        if(isset($arr['game_id']) && !is_array($arr['game_id'])) {
            #$game_id = [$arr['game_id']];
            $arr['game_id'] = explode(' ',$arr['game_id']);
        }
        return $arr;
    }

    /**
     * метод возвращает ошибку при вызове несуществующих методов (заглушка)
     */
    public function __call($name, $arguments)
    {
        return response()->json([
            'message' => "Метод {$name} не определен",
        ], 400);
    }
}