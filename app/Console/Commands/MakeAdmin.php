<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Attribue le rôle admin à un utilisateur existant';




    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilisateur non trouvé.");
            return;
        }

        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->sync([$adminRole->id]);

        $this->info("L'utilisateur {$user->email} est maintenant admin !");
    }
}
