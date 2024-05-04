<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Db::table("notification_infos")->insert([
            [
                'type'=>'battery','title'=>'Your total typed photos yesterday are ','body'=>'You definitely went beast mode yesterday with the amount of photos you typed!'
            ],[
                'type'=>'achievement','title'=>'You reached ','body'=>'You got to 5700 types and have reached level typeRookie!'
            ]
        ]);
    }
}
