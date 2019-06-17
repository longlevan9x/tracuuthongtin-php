<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_code',15);
            $table->string('semester',50)->nullable()->comment('hoc ky');
            $table->string('name_subject')->comment('Tên môn học');
            $table->string('code_class')->comment('Mã lớp');
            $table->integer('credit')->nullable()->default(0)->comment('Tín chỉ');
            $table->float('mark_average', 3)->default(0)->nullable();
            $table->float('mark_training', 3)->default(0)->nullable()->comment('Điểm rèn luyện');
            $table->float('mark_exam', 3)->default(0)->nullable();
            $table->float('mark_exam2', 3)->default(0)->nullable();
            $table->float('mark_average_subject', 3)->default(0)->nullable()->comment('Điểm trung bình thường kỳ');
            $table->string('coefficient1')->nullable();
            $table->string('coefficient2')->nullable();
            $table->string('mark_practice')->nullable();
            $table->string('degree')->nullable();
            $table->string('exam_foul')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->unique(['student_code', 'name_subject']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
