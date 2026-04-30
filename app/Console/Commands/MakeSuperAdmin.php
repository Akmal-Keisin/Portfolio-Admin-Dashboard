<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

#[Signature('make:super-admin {--default}')]
#[Description('Create only one super admin')]
class MakeSuperAdmin extends Command
{

    protected $signature = 'make:super-admin {--default : Use default credentials}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn("--- You are going to make super admin ---");
        $this->warn("Please make sure your credentials are secure");

        $useDefaultCredentials = $this->option('default');
        $name = '';
        $username = '';
        $password = '';

        if ($useDefaultCredentials) {
            $this->warn("You are going to use default credentials, please change the password after you are logged in");

            $name = config('app.default_super_admin.name');
            $username = config('app.default_super_admin.username');
            $password = config('app.default_super_admin.password');

            $this->info("Default name: $name");
            $this->info("Default username: $username");
            $this->info("Default password: $password");

            if ($this->confirm("Are you sure want to use this default credentials?")) {
                $this->info("Saving...");
                new Admin([
                    'name' => $name,
                    'username' => $username,
                    'password' => Hash::make($password)
                ])->save();

                $this->info("Finish...");
                return 1;
            }

            $this->info("Canceling...");
            return 0;
        } else {

            $name = trim($this->ask("Name"));
            $username = trim($this->ask("Username"));
            $password = trim($this->secret("Password"));

            if ($this->confirm("Do you want to see your credentials to make sure?")) {
                $this->info("Default name: $name");
                $this->info("Default username: $username");
                $this->info("Default password: $password");
            }

            if ($this->confirm("Are you sure want to proceed with this credentials?")) {
                $this->info("Saving...");
                new Admin([
                    'name' => $name,
                    'username' => $username,
                    'password' => Hash::make($password)
                ])->save();

                $this->info("Finish...");
                return 1;
            } else {
                $this->info("Canceling...");
                return 0;
            }
        }
    }
}
