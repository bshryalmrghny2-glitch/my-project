<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20); // الرقم الوظيفي لعضو هيئة التدريس أو الموظف (مثال: emp-2026)
            $table->string('booking_type');    // نوع الحجز: (معمل) أو (جهاز)
            $table->string('resource_name');   // اسم المعمل أو الجهاز المحدد
            $table->dateTime('start_time');    // تاريخ ووقت بداية الحجز
            $table->dateTime('end_time');      // تاريخ ووقت نهاية الحجز
            $table->string('status')->default('قيد الانتظار'); // حالة الطلب الافتراضية في المنظومة
            $table->timestamps();              // حقول توقيت الإنشاء والتحديث تلقائياً (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_bookings');
    }
}