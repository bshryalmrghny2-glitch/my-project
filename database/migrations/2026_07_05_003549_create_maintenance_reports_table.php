<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceReportsTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_code'); // كود الجهاز المعطل المربوط بجدول الأجهزة
            $table->string('issue_description'); // وصف العطل (شاشة مكسورة، لا يفتح...)
            $table->string('reporter_name'); // مقدم البلاغ (أستاذ المعمل أو المعيد)
            $table->string('status')->default('قيد الانتظار'); // قيد الانتظار، جاري الإصلاح، تم الإصلاح
            $table->text('repair_notes')->nullable(); // ملاحظات الفني بعد الإصلاح
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_reports');
    }
}