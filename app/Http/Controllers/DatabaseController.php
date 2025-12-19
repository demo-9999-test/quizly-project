<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;


class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:database.manage', ['only' => ['importdemo','importdatabase','resetdatabase','databaseBackup','databaseupdate','genrate','download','removepublic','createfile','addcontent']]);
    }

    // demo import code start
    public function importdemo()
    {
        return view('admin.support.import');
    }

    public function importdatabase()
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        Artisan::call('import:demo');
        return redirect()->back()->with('success', 'Demo Imported successfully.');
    }

    public function resetdatabase()
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        Artisan::call('demo:reset');
        return redirect()->back()->with('success', 'Demo Imported successfully.');
    }
    // demo import code end


    // database backup code start
    public function databaseBackup()
    {
        return view('admin.support.databse-backup');
    }

    public function databaseupdate(Request $request)
    {
        $env_update = DotenvEditor::setKeys([
            'DUMP_BINARY_PATH' => $request->DUMP_BINARY_PATH,
        ]);
        $env_update->save();
        return redirect()->back()->with('success', 'Path Imported successfully.');
    }

    public function genrate(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        Artisan::call('database:backup');
        return redirect()->back()->with('success', 'Generate successfully.');
    }

    public function download(Request $request, $filename)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        if (! $request->hasValidSignature()) {
            return back()->with('delete','Download Link is invalid or expired !');
        }
        $filePath = storage_path().'/app/'.config('app.name').'/'.$filename;
        $fileContent = file_get_contents($filePath);
        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
        return $response;
    }
    // database backup code end

    // remove public code start
    public function removepublic()
    {
        $contents = @file_get_contents(base_path().'/'.'.htaccess');
        $destinationPath=@file_get_contents(resource_path().'/'.'views/admin/support/htaccess.php');
        return view('admin.support.remove_public', compact('contents', 'destinationPath'));
    }

    public function addcontent()
    {

        if(config('app.demolock') == 1){
            if(!file_exists(base_path().'/'.'.htaccess')) {
                $destinationPath=base_path(). '/' .'.htaccess';
                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');
            }
            if(file_exists(base_path().'/'.'.htaccess')) {
                $destinationPath=base_path(). '/' .'.htaccess';
                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');
            }
            return back()->with('success','Update Successfully');
        }
        return back()->with('delete','You can\'t update in Demo');

    }

    public function createfile()
    {

        if(config('app.demolock') == 1){
            if(!file_exists(base_path().'/'.'.htaccess')) {
                $destinationPath=base_path(). '/' .'.htaccess';
                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');
            }
            return back()->with('success','Update Successfully');
        }
        return back()->with('delete','You can\'t update in Demo');

    }
    // remove public code end
}
