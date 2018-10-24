<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentScheduleExams extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('student_schedule_exams', function(Blueprint $table) {
			$table->increments('id')->length(11)->unsigned();
			$table->string('student_code', 15);
			$table->string('schedule_exam_code', 20);
			$table->timestamps();
			$table->unique(['student_code', 'schedule_exam_code']);
			//$table->foreign('student_code')->references('code')->on('students');
			//$table->foreign('schedule_exam_code')->references('code')->on('schedule_exams');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::table('student_schedule_exams', function(Blueprint $table) {
			//
		});
	}
}
