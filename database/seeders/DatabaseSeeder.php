<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем статусы
        Status::create(['name' => 'На рассмотрении']);
        Status::create(['name' => 'Решено']);
        Status::create(['name' => 'Отклонено']);

        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'lastname' => 'Системы',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '+7 (999) 123-45-67',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Создаем тестового пользователя
        User::create([
            'name' => 'Иван',
            'lastname' => 'Петров',
            'middlename' => 'Сергеевич',
            'login' => 'user1',
            'email' => 'user1@example.com',
            'phone' => '+7 (999) 765-43-21',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}