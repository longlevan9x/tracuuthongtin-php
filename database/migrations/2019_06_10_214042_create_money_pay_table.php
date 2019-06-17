<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_code', 15);
	        $table->string('code_money', 100);
	        $table->string('content')->nullable();
	        $table->integer('number')->nullable()->default(0)->comment('stt');
	        $table->integer('credit')->nullable()->default(0)->comment('Tín chỉ');
	        $table->string('money', 20)->default(0)->comment('Số tiền ');
	        $table->string('money_paid', 20)->default(0)->comment('Đã nộp ');
	        $table->string('money_deduct', 20)->default(0)->comment('Khấu trừ ');
	        $table->string('money_pay', 20)->default(0)->comment('Công nợ ');
	        $table->string('status', 20)->default(0);
            $table->timestamps();
			$table->unique(['student_code', 'code_money', 'content', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_pay');
    }
}
