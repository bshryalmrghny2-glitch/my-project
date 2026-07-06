<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabSystemController extends Controller
{
    // ==========================================
    // 1. لوحة التحكم وحجوزات المعامل والمعدات (تاريخ ووقت معاً)
    // ==========================================
    public function showBooking()
    {
        $bookings = DB::table('lab_bookings')->orderBy('created_at', 'desc')->get();
        return view('booking', compact('bookings'));
    }

    public function showBookings()
    {
        return $this->showBooking();
    }

    public function storeBooking(Request $request)
    {
        // التحقق الدقيق من التواريخ والأوقات لضمان منطقية المدخلات
        $request->validate([
            'teacher_id'   => 'required',
            'booking_type' => 'required',
            'target_name'  => 'required',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'start_time'   => 'required',
            'end_time'     => 'required'
        ]);

        DB::table('lab_bookings')->insert([
            'teacher_id'   => $request->teacher_id,
            'booking_type' => $request->booking_type,
            'target_name'  => $request->target_name,
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'status'       => 'قيد الانتظار',
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        return redirect('/booking')->with('success', 'تم تقديم طلب الحجز بنجاح وبانتظار الاعتماد!');
    }

    public function updateStatus($id, $status)
    {
        DB::table('lab_bookings')->where('id', $id)->update([
            'status'     => $status,
            'updated_at' => now()
        ]);

        return redirect('/booking')->with('success', 'تم تحديث حالة الحجز بنجاح!');
    }

    // ==========================================
    // 2. جرد وإدارة المعامل والأجهزة
    // ==========================================
    public function showEquipment()
    {
        $items = DB::table('equipment')->orderBy('lab_name', 'asc')->get();
        return view('equipment', compact('items'));
    }

    public function storeEquipment(Request $request)
    {
        $request->validate([
            'equipment_code' => 'required|unique:equipment,equipment_code',
            'name'           => 'required',
            'lab_name'       => 'required'
        ]);

        DB::table('equipment')->insert([
            'equipment_code' => $request->equipment_code,
            'name'           => $request->name,
            'lab_name'       => $request->lab_name,
            'status'         => $request->status ?? 'نشط',
            'notes'          => $request->notes,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/equipment')->with('success', 'تم إضافة الجهاز الجديد بنجاح!');
    }

    public function updateEquipmentStatus($id, $status)
    {
        DB::table('equipment')->where('id', $id)->update([
            'status'     => $status,
            'updated_at' => now()
        ]);

        return redirect('/equipment')->with('success', 'تم تحديث حالة الجهاز بنجاح!');
    }

    // ==========================================
    // 3. نظام طلبات الصيانة الفنية والربط الذكي
    // ==========================================
    public function showMaintenance()
    {
        $reports = DB::table('maintenance_reports')->orderBy('created_at', 'desc')->get();
        return view('maintenance', compact('reports'));
    }

    public function storeMaintenance(Request $request)
    {
        $request->validate([
            'equipment_code'    => 'required',
            'issue_description' => 'required',
            'reporter_name'     => 'required'
        ]);
        DB::table('maintenance_reports')->insert([
            'equipment_code'    => $request->equipment_code,
            'issue_description' => $request->issue_description,
            'reporter_name'     => $request->reporter_name,
            'status'            => 'قيد الانتظار',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('equipment')
            ->where('equipment_code', $request->equipment_code)
            ->update([
                'status'     => 'تحت الصيانة',
                'updated_at' => now()
            ]);

        return redirect('/maintenance')->with('success', 'تم تسجيل بلاغ الصيانة بنجاح!');
    }

    public function updateMaintenanceStatus($id, $status)
    {
        $report = DB::table('maintenance_reports')->where('id', $id)->first();

        if ($report) {
            DB::table('maintenance_reports')->where('id', $id)->update([
                'status'     => $status,
                'updated_at' => now()
            ]);

            if ($status == 'تم الإصلاح') {
                DB::table('equipment')
                    ->where('equipment_code', $report->equipment_code)
                    ->update([
                        'status'     => 'نشط',
                        'updated_at' => now()
                    ]);
            }
        }

        return redirect('/maintenance')->with('success', 'تم تحديث حالة طلب الصيانة بنجاح!');
    }

    // ==========================================
    // 4. لوحة التقارير والإحصائيات الشاملة والحية
    // ==========================================
    public function showReports()
    {
        $total_equipments  = DB::table('equipment')->count();
        $active_equipments = DB::table('equipment')->where('status', 'نشط')->count();
        $maintenance_count = DB::table('equipment')->where('status', 'تحت الصيانة')->count();
        $total_bookings    = DB::table('lab_bookings')->count();

        $efficiency_rate = $total_equipments > 0 
            ? round(($active_equipments / $total_equipments) * 100) 
            : 0;

        $lab_summary = DB::table('equipment')
            ->select('lab_name', 
                DB::raw('count(*) as total'),
                DB::raw('SUM(case when status = "نشط" then 1 else 0 end) as active'),
                DB::raw('SUM(case when status = "تحت الصيانة" then 1 else 0 end) as maintenance')
            )
            ->groupBy('lab_name')
            ->get();

        return view('reports', compact(
            'total_equipments', 
            'active_equipments', 
            'maintenance_count', 
            'total_bookings', 
            'efficiency_rate',
            'lab_summary'
        ));
    }
}