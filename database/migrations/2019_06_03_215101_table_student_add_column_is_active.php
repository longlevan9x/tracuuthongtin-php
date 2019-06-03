<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableStudentAddColumnIsActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if (Schema::hasTable('students')) {
		    Schema::table('students', function(Blueprint $table) {
		    	$table->tinyInteger('is_active')->nullable()->default(0);
		    });
	    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
