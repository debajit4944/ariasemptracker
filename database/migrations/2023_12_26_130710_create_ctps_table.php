<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ctps', function (Blueprint $table) {
            $table->id();
            $table->string('base');
            $table->string('pli');
            $table->string('ca');
            $table->string('ma');
            $table->string('other_allowance');
            $table->string('total_ctp');
            $table->unsignedBiginteger('employee_id')->unsigned();
            $table->timestamp('ctp_effect_date');
            $table->string('file')->nullable();
            // define foreign key
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctps');
    }
};
