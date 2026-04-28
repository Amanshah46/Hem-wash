<?php

namespace App\Livewire\Installer;

use App\Classes\Requirement;
use App\ExpenseHelper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Attributes\Layout;
use Livewire\Component;
class InstallApp extends Component
{
    public $extensions,$directories,$errormessage,$page,$step=1,$requirement_satisfied =false;
    public $host='localhost',$port=3306,$username,$password,$name,$dberror =true,$license_code,$client_name;
    
    #[Layout('components.layouts.install-layout')]
    public function render()
    {
        return view('livewire.installer.install-app');
    }

    //Check if install file is found, if not redirect
    public function mount()
    {
        $installFile = File::exists(base_path('install'));
        if (!$installFile) {
            return redirect('');
        }
    }

    //check server requirements
    public function hasLocal()
    {
       
        $license = new ExpenseHelper();
        if($license->check_local_license_exist() === true){
            return true;
        }
        return false;
    }

    //check server requirements
    public function checkLicense()
    {

        $license = new ExpenseHelper();

        $verified = $license->activate_license($this->license_code,$this->client_name);

        return true;
    }

    //check server requirements
    public function checkRequirementsServer()
    {
        $requirement = new Requirement();
        $this->extensions = $requirement->extensions();
        $this->directories = $requirement->directories();
        $this->requirement_satisfied = $requirement->satisfied();
        if($this->requirement_satisfied == true)
        {
            return true;
        }
        return false;
    }

    //test database connection
    public function checkDatabase()
    {
        $this->dberror = true;
        $this->validate([
            'host'  => 'required',
            'port'  => 'required|numeric',
            'username'  => 'required',
            'name'  => 'required'
        ]);
        $error =false;
        try{
            $connection = mysqli_connect($this->host,$this->username,$this->password,$this->name,$this->port);
        }
        catch(\Exception $e)
        {
            $error = $e->getMessage();
        }
        if($error == false)
        {
            $this->step = 4;
            $this->dberror = false;
        }
        else{
            $this->dberror = true;
        }
        $this->errormessage = $error;
        if(!$error)
        {
            return true;
        }
    }

    //install : run db migrations
    public function startInstallation()
    {
        if(!$this->hasLocal()) 
        return;
        if(!$this->step == 4)
        return;
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $this->host,
            'database.connections.mysql.port' => $this->port,
            'database.connections.mysql.database' => $this->name,
            'database.connections.mysql.username' => $this->username,
            'database.connections.mysql.password' => $this->password
        ]);
        $editor = DotenvEditor::setKeys([
            'DB_HOST'   => $this->host,
            'DB_PORT'   => $this->port,
            'DB_DATABASE'   => $this->name,
            'DB_USERNAME'   => $this->username,
            'DB_PASSWORD'   => $this->password
        ]);
        $editor->save();
        DB::reconnect('mysql');
        DB::getPdo('mysql');
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        File::delete(base_path('install'));
        $this->step = 5;
        Auth::loginUsingId(1);
        return true;
    }

    //auto login admin user and redirect to dashboard
    public function goToDashboard()
    {
        Auth::loginUsingId(1);
        return redirect()->route('admin.dashboard');
    }
}