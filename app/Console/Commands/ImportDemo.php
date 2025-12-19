<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ImportDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will import demo on your script!';

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
        $this->info('Importing Demo...');

        Artisan::call('db:seed --class=SettingsTableSeeder');

        $dir = base_path().'/storage/framework/sessions';
        foreach (glob("$dir/*") as $file) {
            unlink($file);
        }
        ini_set('max_execution_time', 200);
        $file = public_path().'/democontent.zip';

        if (!File::exists($file)) {
            Flash::warning('Demo content zip file not found!');
            return;
        }

        $this->info('Extracting demo contents...');
        try {
            $zip = new ZipArchive;
            $zipped = $zip->open($file);
            $path = public_path();
            if ($zipped) {
                $extract = $zip->extractTo($path);
                $zip->close();
                if ($extract) {
                    $this->info('Demo data imported successfully!');
                }
            }
        } catch (\Exception $e) {
            Session::flash('delete', $e->getMessage());
        }
    }
}
