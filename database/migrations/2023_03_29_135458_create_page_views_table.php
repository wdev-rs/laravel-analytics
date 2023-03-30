<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('laravel-analytics.db_prefix') . 'page_views';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('path')->index();
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->string('referer')->nullable()->index();
            $table->string('county')->nullable()->index();
            $table->string('city')->nullable();
            $table->string('page_model_type')->nullable();
            $table->string('page_model_id')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('laravel-analytics.db_prefix') . 'page_views');
    }
};
