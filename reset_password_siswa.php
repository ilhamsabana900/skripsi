<?php
use App\Models\User;

$users = User::where('role', 'siswa')->get();
foreach ($users as $user) {
    $user->password = $user->username . 'MAN'; // password plain text
    $user->save();
}
echo "Password siswa berhasil direset ke format NIS+MAN (plain text)\n";
