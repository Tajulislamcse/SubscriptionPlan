<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Expired';

    /**
     * Execute the console command.
     */
  
    public function handle()
     {
        $expired = Subscription::where('status', 'active')
            ->whereNotNull('end_at')
            ->where('end_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Subscription expired successfully.");
     }
    
}
