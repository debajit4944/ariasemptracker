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
        Schema::create('employees_designations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('employees_id')->unsigned();
            $table->unsignedBiginteger('designations_id')->unsigned();
            $table->timestamp('desg_effect_date')->nullable();

            $table->foreign('employees_id')->references('id')
                 ->on('employees')->onDelete('cascade');
            $table->foreign('designations_id')->references('id')
                ->on('designations')->onDelete('cascade');
                
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_designations');
    }
};
