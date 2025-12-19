<?php

namespace App\Console\Commands;
use App\Models\Blog;
use Illuminate\Support\Facades\Session;
use Illuminate\Console\Command;

class DemoReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will reset your demo !';

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
        try {
            $this->info('Demo is resetting...');
            Session::flush();
            Blog::truncate();
            $dir_session = base_path().'/storage/framework/sessions';
            foreach (glob("$dir_session/*") as $file) {
                unlink($file);
            }
            $leave_files = array('index.php');
            $dir0 = public_path() . '/images/blog';
            foreach (glob("$dir0/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }
            $this->info('Demo Reset Successfully !');
        } catch (\Exception $e) {
            die('Database connection is not OK check .env file for more....');
        }

    }
}
