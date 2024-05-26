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
        Schema::create('morders', function (Blueprint $table) {
            $table->id();
            $table->integer('mproduct_id');
            $table->string('byname');
            $table->string('adress');
            $table->string('telefon');
            $table->string('email');
            $table->text('info');
            $table->string('nomer')->length(10);
            $table->date('order_data');
            $table->decimal('tsum', $precision = 10, $scale = 2);
            $table->decimal('bysum', $precision = 10, $scale = 2);
            $table->string('status')->length(10);
            $table->date('redy_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('morders');
    }
};
