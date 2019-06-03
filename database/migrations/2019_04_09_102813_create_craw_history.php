<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawHistory extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::create('crawl_histories', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('total_record')->default(0);
            $table->double('time', 15, 2)->default(0);
            $table->string('type', '20')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('craw_history');
    }
}
