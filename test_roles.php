<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(15);
echo "User 15 roles in DB directly:\n";
echo json_encode(DB::table('model_has_roles')->where('model_id', 15)->get());
echo "\n";

echo "User 15 roles via Tinker (without team ID):\n";
echo json_encode($user->roles()->get()->pluck('id'));
echo "\n";

setPermissionsTeamId(2);
$user->unsetRelation('roles');
echo "User 15 roles via Tinker (with team ID 2):\n";
echo json_encode($user->roles()->get()->pluck('id'));
echo "\n";

setPermissionsTeamId(4);
$user->unsetRelation('roles');
echo "User 15 roles via Tinker (with team ID 4):\n";
echo json_encode($user->roles()->get()->pluck('id'));
echo "\n";
