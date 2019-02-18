<?php
use Illuminate\Database\Seeder;
use App\Model\Tag;

class TagTableSeeder extends Seeder
{
    public function run(){
        Tag::truncate();
        factory(Tag::Class,5)->create();
    }
}