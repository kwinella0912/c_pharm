<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Minimum 8 characters will be validated at the model/controller level
            $table->timestamps(); // Created_at and Updated_at columns
        });
    }

    // public function down()
    // {
    //     Schema::dropIfExists('users');
    // }
};
