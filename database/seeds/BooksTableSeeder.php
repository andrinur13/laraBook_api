<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('books')->insert(
            [
                'title' => 'Mastering Linux Security and Hardening',
                'slug' => 'mastering-linux-security-and-hardening',
                'description' => 'A comprehensive guide to mastering the art of preventing your Linux system from getting compromised',
                'author' => 'Donald A. Tevault',
                'publisher' => 'Packtpub',
                'cover' => 'mastering-linux-security-and-hardening.png',
                'price' => 125000,
                'weight' => 0.5,
                'status' => 'PUBLISH'
            ]
        );
    }
}
