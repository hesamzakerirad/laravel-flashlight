<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashlightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashlight_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 40)->nullable();
            $table->text('address')->nullable();
            $table->string('method', 20)->nullable();
            $table->text('headers')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('requested_at')->current();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flashlight_logs');
    }
}
