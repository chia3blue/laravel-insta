<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function run(): void
    {
        $this->user->name = 'Administrator';
        $this->user->email = 'admin@gmail.com';
        $this->user->password = Hash::make('admin12345');
        $this->user->role_id = User::ADMIN_ROLE_ID;
        $this->user->save();
    }
}
