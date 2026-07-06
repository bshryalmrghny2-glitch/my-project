<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    // دالة إنشاء حجز جديد والتحقق من النظام الرئيسي عبر الـ API
    public function createBooking(Request $request)
    {
        // 1. استقبال البيانات المدخلة من الواجهة (رقم القيد، كود الجهاز، والوقت)
        $userId = $request->input('user_id'); 
        $equipmentId = $request->input('equipment_id'); 
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        // 2. الرابط الخاص بنظام صديقاتك الرئيسي (الـ API) للتحقق من الطالب
        // (ملاحظة: هذا الرابط سنقوم بتحديثه لاحقاً بالرابط الفعلي الذي سيعطينه لكِ)
        $mainSystemUrl = "https://uimp-main-university.edu/api/v1/users/" . $userId;
        
        try {
            // إرسال طلب خفي للمنظومة الرئيسية للتحقق من قيد الطالب
            $response = Http::get($mainSystemUrl);

            // 3. التحقق من رد نظام الجامعة الرئيسي
            if ($response->successful()) {
                // إذا كان الطالب مسجل وصحيح، نظامك يوافق على معالجة الطلب
                return response()->json([
                    'success' => true,
                    'message' => 'تم التحقق من حسابك عبر المنظومة الرئيسية بنجاح، وطلب الحجز تحت المعالجة الآن!'
                ], 201);
            } else {
                // إذا رد النظام الرئيسي بأن الطالب غير موجود
                return response()->json([
                    'success' => false,
                    'message' => 'فشل التحقق: رقم القيد هذا غير مسجل في منظومة الجامعة الرئيسية.'
                ], 404);
            }

        } catch (\Exception $e) {
            // في حال كان سيرفر صديقاتك متوقف أو هناك مشكلة في الاتصال
            return response()->json([
                'success' => false,
                'message' => 'عذراً، تعذر الاتصال بسيرفر الجامعة الرئيسي حالياً. الرجاء المحاولة لاحقاً.'
            ], 500);
        }
    }
}