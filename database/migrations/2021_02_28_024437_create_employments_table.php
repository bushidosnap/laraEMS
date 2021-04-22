<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('pos_id');
            $table->string('emp_type');
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->boolean('status')->default(1);

            $table->index('user_id');
            $table->index('dept_id');
            $table->index('pos_id');
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
        Schema::dropIfExists('employments');
    }
}
