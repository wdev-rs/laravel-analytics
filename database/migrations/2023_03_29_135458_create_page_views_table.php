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
            $table->string('session_id')->index();
            $table->string('path')->index();
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->string('referer')->nullable()->index();
            $table->string('county')->nullable()->index();
            $table->string('city')->nullable();
            $table->string('page_model_type')->nullable();
            $table->string('page_model_id')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();

            $table->index(['page_model_type', 'page_model_id']);
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
