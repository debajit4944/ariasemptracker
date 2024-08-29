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
        Schema::create('employees_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('employees_id')->unsigned();
            $table->unsignedBiginteger('leaves_id')->unsigned();
            $table->float('no_of_days');
            $table->integer('year');
            $table->string('dates');
            $table->integer('approved');
            $table->string('file')->nullable();
            
            $table->foreign('employees_id')->references('id')
                 ->on('employees')->onDelete('cascade');
            $table->foreign('leaves_id')->references('id')
                ->on('leaves')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_leaves');
    }
};
