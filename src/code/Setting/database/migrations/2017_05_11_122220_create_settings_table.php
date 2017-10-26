<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table){
            $table->increments('id');
            $table->string('heading');
            $table->string('label');
            $table->string('slug');
            $table->string('value');
            $table->tinyInteger('required')->default(0);
            $table->text('help_text')->nullable();
            $table->string('input_type')->nullable();
            $table->string('input_options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
