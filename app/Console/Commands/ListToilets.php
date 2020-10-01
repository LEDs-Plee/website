<?php

namespace App\Console\Commands;

use App\Models\ToiletStatus;
use Illuminate\Console\Command;

class ListToilets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toilet:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all toilets';

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
     * @return int
     */
    public function handle()
    {
        $toilets = ToiletStatus::all();
        $this->info('Toilets: ');
        foreach ($toilets as $toilet) {
            $this->info("Name: {$toilet->name} \n Id: {$toilet->id} \n Secret: {$toilet->secret}");
        }
        return 0;
    }
}
