<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = ['name','game_id'];

    /**
     * Метод возвращает список добавленных игр
     */
    public function allGames()
    {
        return $this->orderBy('name')->get();
    }
}
