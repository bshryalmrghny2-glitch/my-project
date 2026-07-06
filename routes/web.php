<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabSystemController;

// مسار الصفحة الرئيسية: يحول المستخدم تلقائياً إلى لوحة الحجوزات
Route::get('/', function () { 
    return redirect('/booking'); 
});

// ==========================================
// 1. مسارات لوحة التحكم وحجوزات المعامل
// ==========================================
Route::get('/booking', [LabSystemController::class, 'showBooking']);
Route::post('/booking/store', [LabSystemController::class, 'storeBooking']); // تم التعديل والإضافة هنا
Route::get('/booking/status/{id}/{status}', [LabSystemController::class, 'updateStatus']);

// ==========================================
// 2. مسارات جرد وإدارة الأجهزة والمعدات
// ==========================================
Route::get('/equipment', [LabSystemController::class, 'showEquipment']);
Route::post('/equipment/store', [LabSystemController::class, 'storeEquipment']);
Route::get('/equipment/status/{id}/{status}', [LabSystemController::class, 'updateEquipmentStatus']);

// ==========================================
// 3. مسارات نظام طلبات الصيانة الفنية والربط الخلفي
// ==========================================
Route::get('/maintenance', [LabSystemController::class, 'showMaintenance']);
Route::post('/maintenance/store', [LabSystemController::class, 'storeMaintenance']);
Route::get('/maintenance/status/{id}/{status}', [LabSystemController::class, 'updateMaintenanceStatus']);

// ==========================================
// 4. مسار لوحة التقارير والإحصائيات الشاملة
// ==========================================
Route::get('/reports', [LabSystemController::class, 'showReports']);