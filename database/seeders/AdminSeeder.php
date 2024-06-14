<?php

namespace Database\Seeders;

use App\Helpers\EncryptionHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * The EncryptionHelper instance.
     *
     * @var \App\Helpers\EncryptionHelper
     */
    protected $encryptionHelper;

    /**
     * Create a new seeder instance.
     *
     * @param  \App\Helpers\EncryptionHelper  $encryptionHelper
     * @return void
     */
    public function __construct(EncryptionHelper $encryptionHelper)
    {
        $this->encryptionHelper = $encryptionHelper;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enkripsi password
        $encryptedPassword = $this->encryptionHelper->enkrip('12');

        // Insert some stuff
        DB::table('tb_users')->insert(
            array(
                'full_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => $encryptedPassword
            )
        );
    }
}
