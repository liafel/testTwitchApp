<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TwitchController;

class getStreamData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:streamdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение и запись данных по стримам в БД';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        #$dataModel = new \App\DataStream;
        $twitchController = new TwitchController;
        $twitchController->getStreams();
    }
}
