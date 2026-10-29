<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun awal. WAJIB ganti password sebelum dipakai di hosting.
        User::updateOrCreate(
            ['email' => 'admin@jimpitan.test'],
            ['name' => 'Admin RT', 'password' => 'password', 'role' => 'admin', 'aktif' => true],
        );
        User::updateOrCreate(
            ['email' => 'petugas@jimpitan.test'],
            ['name' => 'Petugas Ronda', 'password' => 'password', 'role' => 'petugas', 'aktif' => true],
        );

        Setting::current();

        // Data contoh hanya untuk pengembangan lokal.
        if (app()->environment('local') && Warga::count() === 0) {
            $contoh = [
                ['Budi Santoso', '12'], ['Siti Rahayu', '7'], ['Hendra Wijaya', '21'],
                ['Dewi Lestari', '3'], ['Ani Nuraini', '5'], ['Joko Mulyono', '9'],
            ];

            foreach ($contoh as [$nama, $rumah]) {
                $warga = Warga::create(['kode_warga' => 'TMP'.uniqid(), 'nama' => $nama, 'no_rumah' => $rumah, 'status' => 'aktif']);
                $warga->update(['kode_warga' => Warga::kodeDariId($warga->id)]);
            }
        }
    }
}
