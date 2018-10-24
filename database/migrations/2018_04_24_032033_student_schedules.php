<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentSchedules extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('student_schedules', function(Blueprint $table) {
			$table->increments('id')->length(11)->unsigned();
			$table->string('student_code', 15);
			$table->string('schedule_code', 20);
			$table->timestamps();
			$table->unique(['student_code', 'schedule_code']);
			//$table->foreign('student_code')->references('code')->on('students');
			//$table->foreign('schedule_code')->references('code')->on('schedules');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::table('student_schedules', function(Blueprint $table) {
			//
		});
	}
}
