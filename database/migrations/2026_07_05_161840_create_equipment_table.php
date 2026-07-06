<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
  public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id(); // معرف رقمي فريد وتلقائي
            $table->string('equipment_code', 20)->unique(); // كود الجهاز أو الباركود
            $table->string('name'); // اسم الجهاز
            $table->string('model')->nullable(); // موديل الجهاز
            $table->string('category')->nullable(); // الفئة
            $table->string('lab_name'); // اسم المعمل أو مكانه
            $table->enum('status', ['Available', 'Booked', 'Maintenance'])->default('Available'); // حالة الجهاز
            $table->text('notes')->nullable(); // ملاحظات
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
