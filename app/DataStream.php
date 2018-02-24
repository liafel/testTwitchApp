<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


class DataStream extends Model
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = ['stream_id','game_id','service','viewers'];

    protected $table = 'data';

    /**
     * Метод возвращает данные для API по заданным параметрам
     * @param array $where 
     * @return array
     */
    public function getData($where)
    {
        switch ($where['type']) {
            case 'streams':
                $query = $this->selectRaw("game_id,stream_id")->groupBy('game_id','stream_id');
            break;
            
            case 'viewers':
                $query = $this->selectRaw("game_id,sum(viewers) viewers")->groupBy('game_id');
            break;

            default:
            break;
        }
        // проверка на дату
        if(!empty($where['date_from']) && !empty($where['date_to'])) {
            $query->whereBetween('created_at',[$where['date_from'],$where['date_to']]);
        } elseif(!empty($where['date_from']) && empty($where['date_to'])) {
            $query->whereDate('created_at','>=',$where['date_from']);
        } elseif(empty($where['date_from']) && !empty($where['date_to'])) {
            $query->whereDate('created_at','<=',$where['date_to']);
        }
        // проверка на ID игры
        if(isset($where['game_id']) && is_array($where['game_id'])) {
            $query->whereIn('game_id',$where['game_id']);
        }
        $return = $query->get();
        #$return = $query->toSql();
        return $return;
    }
}
