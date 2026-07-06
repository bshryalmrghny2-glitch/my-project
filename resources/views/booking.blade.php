<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المعامل - لوحة الحجوزات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Cairo', sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold fs-5" href="/booking">🧪 نظام إدارة المعامل والمعدات</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link active" href="/booking">لوحة الحجوزات</a></li>
                <li class="nav-item"><a class="nav-link" href="/equipment">المعامل والأجهزة</a></li>
                <li class="nav-item"><a class="nav-link" href="/maintenance">طلبات الصيانة</a></li>
                <li class="nav-item"><a class="nav-link" href="/reports">التقارير والإحصائيات</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success fw-bold shadow-sm mb-4">
            ✨ {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
<<<<<<< HEAD

=======

>>>>>>> 8649acdb3d6bfe1800e414f64a2aeba17f373075
        <div class="col-lg-4">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">طلب حجز (معمل / معدة)</h5>

                    <form action="/booking/store" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">الرقم الوظيفي:</label>
                            <input type="text" name="teacher_id" class="form-control" placeholder="أدخلي الرقم الوظيفي للمحاضر" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">نوع الحجز:</label>
                            <select name="booking_type" class="form-select" required>
                                <option value="حجز معمل">حجز معمل كامل</option>
                                <option value="حجز معدة">حجز معدة / جهاز معين</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">اسم المعمل أو كود المعدة:</label>
                            <input type="text" name="target_name" class="form-control" placeholder="مثال: معمل 1 أو كود الجهاز" required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">تاريخ البدء:</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">تاريخ الانتهاء:</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">وقت البدء:</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">وقت الانتهاء:</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold text-white shadow-sm mt-2">
                            🗓️ إرسال طلب الحجز الشامل
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card rounded-3 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">سجل طلبات الحجوزات والمواعيد</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th>الرقم الوظيفي</th>
                                    <th>نوع الحجز</th>
                                    <th>المعمل / المعدة</th>
                                    <th>الفترة الزمنية (التاريخ)</th>
                                    <th>التوقيت اليومي (الوقت)</th>
                                    <th>الحالة</th>
                                    <th>التحكم</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6">
                                @forelse($bookings as $booking)
                                <tr>
                                    <td class="fw-bold text-secondary">{{ $booking->employee_id }}</td>
                                    <td>
                                        <span class="badge {{ $booking->booking_type == 'حجز معمل' ? 'bg-info text-dark' : 'bg-secondary text-white' }} px-2 py-1">
                                            {{ $booking->booking_type }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-primary">{{ $booking->resource_name }}</td>
                                    <td class="small fw-semibold text-dark">
                                        من: {{ $booking->start_time }} <br> إلى: {{ $booking->end_time }}
                                    </td>
                                    <td class="small text-muted fw-semibold">
                                        من: {{ $booking->start_time }} <br> إلى: {{ $booking->end_time }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'مقبول')
                                            <span class="badge bg-success px-2 py-1">مقبول ✓</span>
                                        @elseif($booking->status == 'مرفوض')
                                            <span class="badge bg-danger px-2 py-1">مرفوض ✗</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2 py-1">قيد الانتظار ⏳</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/booking/status/{{ $booking->id }}/مقبول" class="btn btn-outline-success">قبول</a>
                                            <a href="/booking/status/{{ $booking->id }}/مرفوض" class="btn btn-outline-danger">رفض</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-muted p-4">لا توجد طلبات حجز مسجلة حالياً في النظام.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
