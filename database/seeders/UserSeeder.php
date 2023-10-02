<?php

namespace Database\Seeders;

use App\Core\Domain\Models\Company\CompanyId;
use App\Core\Domain\Models\CompanyPic\CompanyPicId;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\UserId;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 50 ; $i++) {
            $user_id = UserId::generate()->toString();
            $user = [
                'id' => $user_id,
                'name' => 'User '.$i,
                'email' => 'user' . $i . '@gmail.com',
                'no_telp' => '0812345678' . $i,
                'user_type' => 'user',
                'age' => 20 + $i,
                'image_url' => 'https://i.pravatar.cc/150?img=' . $i,
                'password' => Hash::make('User' . $i),
            ];
            DB::table('users')->insert($user);
        }
    }
}
