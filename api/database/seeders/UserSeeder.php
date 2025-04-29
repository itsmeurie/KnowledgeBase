<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Office;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $users = [
            [
                "username" => "danieltejano",
                "email" => null,
                "password" => Hash::make("password"),
                "role" => "Admin",
                "team_id" => 1,
            ],
            [
                "username" => "test",
                "email" => null,
                "password" => Hash::make("password123"),
                "role" => "Admin",
                "team_id" => 2,
            ],
            [
                "username" => "uriepogi",
                "email" => null,
                "password" => Hash::make("Urie12345"),
                "role" => "Admin",
                "team_id" => 3,
            ],
            [
                "username" => "joncarlo",
                "email" => null,
                "password" => Hash::make("carlo12345"),
                "role" => "Admin",
                "team_id" => 3,
            ],
        ];

        $office_ids = Office::select("id")->get()->pluck("id");
        $team_id = config("permission.column_names.team_foreign_key");

        foreach ($users as $user) {
            $new_user = User::create([
                "username" => $user["username"],
                "email" => $user["email"],
                "email_verified_at" => now(),
                "password" => $user["password"],
                "team_id" => $user["team_id"],
            ]);

            // $new_user->assignRole($user['role']);
            $role = Role::where("name", $user["role"])->first();
            $insert = [];
            if ($user["role"] == config("mitd.superman")) {
                foreach ($office_ids as $office_id) {
                    $insert[] = [
                        "role_id" => $role->id,
                        "model_type" => "App\Models\User",
                        "model_id" => $new_user->id,
                        "$team_id" => $office_id,
                    ];
                }
                # code...
            } else {
                $insert[] = [
                    "role_id" => $role->id,
                    "model_type" => "App\Models\User",
                    "model_id" => $new_user->id,
                    "$team_id" => $user["office_id"],
                ];
            }
            DB::table("model_has_roles")->insert($insert);
        }
    }
}
