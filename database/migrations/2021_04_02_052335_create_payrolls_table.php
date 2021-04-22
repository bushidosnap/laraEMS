<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('payroll_name');
            $table->unsignedBigInteger('employment_id');
            $table->bigInteger('rate')->nullable();
            $table->bigInteger('hours_worked');
            $table->bigInteger('overtime')->nullable();
            $table->bigInteger('benefit_deduction')->nullable();
            $table->bigInteger('other_deduction')->nullable();
            $table->timestamps();

            $table->index('employment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
