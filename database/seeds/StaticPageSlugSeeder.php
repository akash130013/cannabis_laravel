<?php

use Illuminate\Database\Seeder;

class StaticPageSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('static_pages')->truncate();
        $data = [
            //for user
            ["name" => "Terms & Conditions" , "slug" => 'terms-conditions'  , 'content' => '' , 'panel'=>'user'],
            ["name" => "Privacy policy"     , "slug" => 'privacy-policy'    , 'content' => '' , 'panel'=>'user'],
            ["name" => "FAQ"                , "slug" => 'faq'               , 'content' => '' , 'panel'=>'user'],
            ["name" => "Help"               , "slug" => 'help'              , 'content' => '' , 'panel'=>'user'],
            ["name" => "About us"           , "slug" => 'about-us'          , 'content' => '' , 'panel'=>'user'],
            ["name" => "Contact Us"         , "slug" => 'contact-us'        , 'content' => '' , 'panel'=>'user'],
            //For Store Panel
            ["name" => "Terms & Conditions" , "slug" => 'terms-conditions'  , 'content' => '' , 'panel'=>'store'],
            ["name" => "Privacy policy"     , "slug" => 'privacy-policy'    , 'content' => '' , 'panel'=>'store'],
            ["name" => "FAQ"                , "slug" => 'faq'               , 'content' => '' , 'panel'=>'store'],
            ["name" => "Help"               , "slug" => 'help'              , 'content' => '' , 'panel'=>'store'],
            ["name" => "About us"           , "slug" => 'about-us'          , 'content' => '' , 'panel'=>'store'],
            ["name" => "Contact Us"         , "slug" => 'contact-us'        , 'content' => '' , 'panel'=>'store'],
        ];
        DB::table('static_pages')->insert($data);
    }
}
