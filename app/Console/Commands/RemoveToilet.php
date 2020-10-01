<?php

namespace App\Console\Commands;

use App\Models\ToiletStatus;
use Illuminate\Console\Command;

class RemoveToilet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toilet:remove {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a toilet';

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
        $toilet = ToiletStatus::findOrFail($this->argument('id'));
        $this->info("Deleted toilet: \n Name: {$toilet->name} \n Id: {$toilet->id} \n Secret: {$toilet->secret}");
        $toilet->delete();
        return 0;
    }
}
