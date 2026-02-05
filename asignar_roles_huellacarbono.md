# Guía: Asignar Roles - Módulo Huella de Carbono

## Paso 1: Abrir Tinker
```bash
php artisan tinker
```

## Paso 2: Ver Usuarios Disponibles
```php
User::select('id', 'nickname', 'email')->get();
```

## Paso 3: Asignar Rol SuperAdmin
```php
// Buscar usuario por email
$user = User::where('email', 'catfished03@gmail.com')->first();

// Buscar rol SuperAdmin
$role = Modules\SICA\Entities\Role::where('slug', 'huellacarbono.superadmin')->first();

// Asignar rol
$user->roles()->attach($role->id);

// Verificar
$user->roles;
```

## Paso 4: Asignar Otros Roles (Opcional)

### Admin
```php
$user = User::where('email', 'OTRO_EMAIL@email.com')->first();
$role = Modules\SICA\Entities\Role::where('slug', 'huellacarbono.admin')->first();
$user->roles()->attach($role->id);
```

### Líder de Unidad
```php
$user = User::where('email', 'LIDER_EMAIL@email.com')->first();
$role = Modules\SICA\Entities\Role::where('slug', 'huellacarbono.leader')->first();
$user->roles()->attach($role->id);

// Asignar unidad productiva al líder
$unit = Modules\HUELLACARBONO\Entities\ProductiveUnit::where('code', 'ECOTURISMO')->first();
$unit->leader_user_id = $user->id;
$unit->save();
```

## Roles Disponibles
- `huellacarbono.superadmin` - SuperAdmin Huella de Carbono
- `huellacarbono.admin` - Admin Huella de Carbono
- `huellacarbono.leader` - Líder de Unidad Productiva

## Rutas de Acceso
- SuperAdmin: `/huellacarbono/superadmin/dashboard`
- Admin: `/huellacarbono/admin/dashboard`
- Líder: `/huellacarbono/lider/dashboard`
- Público: `/huellacarbono/index`





