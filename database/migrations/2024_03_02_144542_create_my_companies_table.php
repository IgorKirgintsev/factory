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
        Schema::create('my_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inn')->length('20');
            $table->string('director');
            $table->string('adress');
            $table->string('email');
            $table->string('bank');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_companies');
    }
};
