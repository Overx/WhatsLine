<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para executar as tarefas do sistema.';

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
        \Log::info('Rodou @' . \Carbon\Carbon::now());
    }
}
