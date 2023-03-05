<?php

namespace App\Console\Commands;

use App\Models\Washer;
use Illuminate\Console\Command;

class UpdateWashers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'washer:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update washers states from API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach(Washer::all() as $washer) {
            $washer->updateState();
        }
    }
}
