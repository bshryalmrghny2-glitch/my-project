<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();

            // الربط البرمجي الصحيح والمطابق لـ id جدول الأجهزة
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};