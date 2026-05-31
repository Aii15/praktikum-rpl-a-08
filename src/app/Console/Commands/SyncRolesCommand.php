<?php

namespace App\Console\Commands;
/* command untuk sinkronisasi data role dari sumber eksternal */

use Illuminate\Console\Command;
use App\Models\User;

class SyncRolesCommand extends Command
{
    protected $signature = 'roles:sync {--dry-run}';
    protected $description = 'Sync legacy users.role column from pivot roles (primary role)';

    public function handle(): int
    {
        $dry = $this->option('dry-run');
        $users = User::with('roles')->get();
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();
        foreach ($users as $user) {
            $primary = $user->roles->pluck('name')->first();
            $old = $user->role ?? null;
            if ($primary !== $old) {
                $this->info("User {$user->id} ({$user->email}): {$old} -> {$primary}\n");
                if (! $dry) {
                    $user->role = $primary;
                    $user->save();
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->line('');
        $this->info('Done.');
        return 0;
    }
}
