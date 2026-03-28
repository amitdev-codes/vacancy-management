<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CRUDBooster;
use App\Helpers\PaymentLinker;

class PaymentLinkNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'vaars:paymentLinkNotify';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Checks if any payment links has been made if yes then notifies the user.';

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
        //
        PaymentLinker::sendLinkageEmail();
    }
}
