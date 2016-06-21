<?php

class UsuarioTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->delete();
        
        User::create([
            'nome' => 'admin',
            'email' => 'denis302010@gmail.com',
            'password' => Hash::make('senhaforte'),
            'status' => 1
        ]);
    }
}