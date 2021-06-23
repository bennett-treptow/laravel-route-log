<?php
namespace LaravelRouteLog\Commands;

use Illuminate\Console\Command;
use LaravelRouteLog\Logger\LoggerInterface;

class ClearRouteLogCommand extends Command {
    protected $signature = 'clear:route-logs {--days=30} {--all}';

    public function handle(){
        if($this->option('all')){
            app(LoggerInterface::class)->clearAll();
            $this->info('Successfully cleared all route logs.');
        } else {
            $days = $this->option('days');
            $startDate = now()->subDays($days);
            $endDate = now();

            app(LoggerInterface::class)->clear($startDate, $endDate);
            $this->info('Successfully cleared all route logs created between '.$startDate->format('Y-m-d').' and '.$endDate->format('Y-m-d'));
        }
    }
}