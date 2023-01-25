<?php

namespace Database\Seeders;

use App\Models\Articles;
use App\Models\User;
use App\Models\Conferences;
use Illuminate\Database\Seeder;
use App\Models\ConferenceCategories;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = \App\Models\Admin\Admins::where('role', "administrator")->count();
        if ($users == 0) {

            \App\Models\Admin\Admins::create([
                'name' => "Admin",
                'role' => "administrator",
                'email' => env('DEFAULT_EMAIL'),
                'password' => bcrypt(env('DEFAULT_PASSWORD'))
            ]);
        }


        // for ($i = 0; $i <= 10; $i++) {
        //     User::create([
        //         'name' => "Mohamed" . $i,
        //         'qualification' => "ماجستير علوم",
        //         'email' => "mohamed" . $i . "@gmail.com",
        //         'phone' => "010" . rand(10000000, 99999999),
        //         'country_code' => "+20",
        //         'email_verified_at' => now(),
        //         'password' => bcrypt(env('DEFAULT_PASSWORD'))
        //     ]);
        // }

        // ConferenceCategories::create([
        //     'name' => "شهادة حضور ( بدون تقديم بحث )",
        //     'price' => 20
        // ]);

        // Conferences::create([
        //     'category' => 1,
        //     'user_id' => 1
        // ]);

        // Payment::create([
        //     'amount' => 20,
        //     'currency' => "USD",
        //     'source'  => 'PayPal',
        //     'payment_id' => "#927KDN3LAS23HSDN",
        //     'status'   => 'APPROVED',
        //     'payment_by' => 1,
        //     'for_conference' => 1,
        // ]);




    }
}
