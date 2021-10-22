<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsMissingSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table){
            $table->softDeletes();
        });

        Schema::table('user_social_accounts', function (Blueprint $table){
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table){
            $table->dropSoftDeletes();
        });

        Schema::table('user_social_accounts', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
