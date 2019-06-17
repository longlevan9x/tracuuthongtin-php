<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableStudentsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('teacher_lead', 100)->nullable();
            $table->string('phone_teacher_lead', 20)->nullable();
            $table->string('teacher_counselor', 100)->nullable();
            $table->string('phone_teacher_counselor', 20)->nullable();
            $table->string('education_time', 20)->nullable();
        });
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
