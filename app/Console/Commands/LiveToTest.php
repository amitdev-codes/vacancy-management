<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Helpers;
use Illuminate\Support\Facades\Storage;

class LiveToTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaars:livetotest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Live databaset to test database';
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
        //$this->backupDatabase();
        $this->updatePassword();
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
        $test = env("DB_DATABASE_TEST","vacancy_test");
        $file_name = "vacancy_test_".\App\Helpers\VAARS::NowObj()->format("ymd_Hi");
        $test_path = "/var/www/backup/db/$file_name";
        $cmd = "mysqldump --defaults-extra-file=/var/www/.sqlpwd -u vacancy vacancy_test > $test_path.sql";
        $result= exec($cmd);
        //compress file
        $cmd = "tar zcf $test_path.tar.gz $test_path.sql";
        $result= exec($cmd);
        exec("rm $test_path.sql");
        
        //import live backup into test-database
        $cmd = "mysql --defaults-extra-file=/var/www/.sqlpwd -u vacancy vacancy_dev < $live_path.sql";
        exec($cmd);
    }
    
    private function updatePassword(){
        return;
        $pwd = "$2y$10$fJBeNOAuBXfze73EW.I2ueRvhkCW.0uvdmnoJtUfODW8jKGDr6Z6.";
        DB::connection('mysql_test')->query(DB::raw("UPDATE cms_users set password='$pwd' WHERE id = '1'"));
        DB::connection('mysql_test')
            ->update("cms_users")
            ->set("password",$pwd)
            ->where("id","=","1")
            ->toSql();
        
    }
    
    private function importToTestDatabase(){
        
    }

    private function backupFiles(){

    }

    private function backupScript(){
        
    }
}
