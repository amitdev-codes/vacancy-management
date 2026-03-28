<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\UploadErpDataHelper;


class UploadErpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload_data:erp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload data from file uploaded by ftp.';

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
        UploadErpDataHelper::upload_data();
    }
}
