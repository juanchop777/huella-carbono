<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\SICA\Entities\Role;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;

class ResetHuellaLiderPassword extends Command
{
    protected $signature = 'huellacarbono:reset-lider {email=juan@gmail.com} {password=Lider2025}';

    protected $description = 'Restablece contraseña de un usuario y le asigna rol Líder Huella de Carbono (ej: Juan Valenzuela)';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No existe un usuario con email: {$email}");
            return 1;
        }

        $user->password = Hash::make($password);
        $user->save();
        $this->info("✓ Contraseña actualizada para: {$user->email}");

        $role = Role::where('slug', 'huellacarbono.leader')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
            $this->info('✓ Rol Líder asignado.');
        }

        // Asignar a una unidad sin líder (primera activa que no tenga líder)
        $unitWithoutLeader = ProductiveUnit::where('is_active', true)->whereNull('leader_user_id')->first();
        if ($unitWithoutLeader) {
            $unitWithoutLeader->leader_user_id = $user->id;
            $unitWithoutLeader->save();
            $this->info("✓ Asignado como líder de la unidad: {$unitWithoutLeader->name}");
        } else {
            $this->warn('No hay unidades sin líder. Asigna a Juan desde SuperAdmin → Unidades → Asignar líder.');
        }

        $this->newLine();
        $this->info('╔═══════════════════════════════════════════════════════╗');
        $this->info('║  Usuario listo para entrar como Líder                 ║');
        $this->info('╠═══════════════════════════════════════════════════════╣');
        $this->info("║  Email:    {$email}");
        $this->info("║  Password: {$password}");
        $this->info('╚═══════════════════════════════════════════════════════╝');
        $this->newLine();

        return 0;
    }
}
