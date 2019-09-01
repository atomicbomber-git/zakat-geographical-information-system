<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ChangeAdminNameToBaznas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-admin-name-to-baznas:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the admin user\'s name to "Baznas"';

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
        User::query()
            ->where("type", User::ADMINISTRATOR_TYPE)
            ->update(["name" => "Baznas"]);
    }
}
