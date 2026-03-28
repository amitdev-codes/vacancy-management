<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers;
use Illuminate\Support\Facades\Storage;
class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaars:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup content related to VAARS & notify in email';
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
        var_dump("backup");
        var_dump(env("DB_USERNAME"));
        //
        //$this->sendEmailAboutLinkage($this->argument('csv_payment_file_id'));
        //PaymentLinker::sendEmailAboutLinkage($this->argument('csv_payment_file_id'));
        $this->backupDatabase();
    }

    private function backupDatabase(){
        //live database backup
        $file_name = "vacancy_live_".\App\Helpers\VAARS::NowObj()->format("ymd_Hi");
        $live_path = "/var/www/backup/db/$file_name";
        $cmd = "mysqldump --defaults-extra-file=/var/www/.sqlpwd -u vacancy vacancy_live > $live_path.sql";
        $result= exec($cmd);
        //compress file
        $cmd = "tar zcf $live_path.tar.gz $live_path.sql";
        $result= exec($cmd);
        
        
        //test database
        //live database backup
        $file_name = "vacancy_test_".\App\Helpers\VAARS::NowObj()->format("ymd_Hi");
        $test_path = "/var/www/backup/db/$file_name";
        $cmd = "mysqldump --defaults-extra-file=/var/www/.sqlpwd -u vacancy vacancy_test > $test_path.sql";
        $result= exec($cmd);
        //compress file
        $cmd = "tar zcf $test_path.tar.gz $test_path.sql";
        $result= exec($cmd);
        exec("rm $test_path.sql");
        
    }

    private function backupFiles(){

    }

    private function backupScript(){
        
    }
}
