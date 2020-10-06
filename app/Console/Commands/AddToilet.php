<?php

namespace App\Console\Commands;

use App\Models\Toilet;
use Illuminate\Console\Command;

class AddToilet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toilet:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a toilet';

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
        $toilet = Toilet::create(['name' => $this->argument('name')]);
        $this->info("Added toilet \n Name: {$toilet->name} \n Id: {$toilet->id} \n Secret: {$toilet->secret}");
        return 0;
    }
}
