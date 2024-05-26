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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('client_id');
            $table->string('nomer')->length(10);
            $table->date('pay_data');
            $table->decimal('psum', $precision = 10, $scale = 2);
            $table->boolean('status');
            $table->string('typ_doc')->length(30);
            $table->string('metod')->length(30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
