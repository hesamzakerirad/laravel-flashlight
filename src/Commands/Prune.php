<?php 

namespace HesamRad\Flashlight\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Prune extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashlight:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes old logs from database to maintain a lighter log table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Flashlight is pruning old logs...');

        try {
            $result = $this->prune();

            $this->info('✅ Flashlight has successfully pruned Flashlight logs.');
            $this->info("✅ $result records were removed from storage.");
        }

        catch (\Throwable $e) {
            $this->warn('❌ Whoops! Something went wrong with pruning process!');
            $this->warn('❌ ' . $e->getMessage());
        }
    }

    /**
     * Pruen old Flashlight logs.
     *
     * @return int
     */
    protected function prune()
    {
        return DB::table(config('flashlight.logs_table_name'))
            ->where('requested_at', '<', now()->subDays(config('flashlight.prune_period')))
            ->delete();
    }
}