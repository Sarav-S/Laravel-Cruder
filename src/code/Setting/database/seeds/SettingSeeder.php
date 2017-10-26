<?php

namespace Code\Setting\database\seeds;

use Code\Setting\Model\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Application Name',
            'slug'          => 'app_name',
            'value'         => 'Crud',
            'required'      => 1,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Contact Email Address',
            'slug'          => 'contact_email',
            'value'         => 'me@sarav.co',
            'required'      => 1,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Contact Number',
            'slug'          => 'contact_number',
            'value'         => '1234567890',
            'required'      => 1,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Contact Address',
            'slug'          => 'contact_address',
            'value'         => 'New York',
            'required'      => 1,
            'input_type'    => 'textarea',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Logo',
            'slug'          => 'logo',
            'value'         => '',
            'required'      => 1,
            'input_type'    => 'file',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '1. General Settings',
            'label'         => 'Favicon',
            'slug'          => 'favicon',
            'value'         => '',
            'required'      => 1,
            'input_type'    => 'file',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '2. Social Links',
            'label'         => 'Facebook Page URL',
            'slug'          => 'facebook_page_url',
            'value'         => '',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '2. Social Links',
            'label'         => 'Google Plus Page URL',
            'slug'          => 'google_plus_page_url',
            'value'         => '',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '2. Social Links',
            'label'         => 'Twitter Page URL',
            'slug'          => 'twitter_page_url',
            'value'         => '',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Enable Facebook Social Login',
            'slug'          => 'enable_facebook_login',
            'value'         => 1,
            'required'      => 0,
            'input_type'    => 'checkbox',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Facebook Client ID',
            'slug'          => 'facebook_client_id',
            'value'         => '724197067760899',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Facebook Client Secret',
            'slug'          => 'facebook_client_secret',
            'value'         => '0cead261b59e02055d21773daab42f10',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Enable Google Plus Social Login',
            'slug'          => 'enable_google_login',
            'value'         => 1,
            'required'      => 0,
            'input_type'    => 'checkbox',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Google Plus Client ID',
            'slug'          => 'google_client_id',
            'value'         => '585484113519-lefqaj0odgkofv26d28rlsnuroeg059i.apps.googleusercontent.com',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Google Plus Client Secret',
            'slug'          => 'google_client_secret',
            'value'         => 'E9QyykYjY3fUnPN9QJTCN1Z-',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Enable Twitter Login',
            'slug'          => 'enable_twitter_login',
            'value'         => 1,
            'required'      => 0,
            'input_type'    => 'checkbox',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Twitter Client ID',
            'slug'          => 'twitter_client_id',
            'value'         => 'kINGLui0JRk8zUOC2eMdyeR6D',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);

        Setting::create([
            'heading'       => '3. Social Login',
            'label'         => 'Twitter Secret',
            'slug'          => 'twitter_client_secret',
            'value'         => 'q3K2J9LJNBScugJQvx8a1lORtjV0wrSbrl7CnmAlZTArHRlwu1',
            'required'      => 0,
            'input_type'    => 'text',
            'input_options' => ''
        ]);
    }
}
