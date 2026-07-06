<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المعامل - لوحة التقارير والإحصائيات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Cairo', sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); }
        .card-stat { border: none; border-right: 5px solid; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .border-primary-custom { border-right-color: #0d6efd !important; }
        .border-success-custom { border-right-color: #28a745 !important; }
        .border-warning-custom { border-right-color: #ffc107 !important; }
        .border-info-custom { border-right-color: #17a2b8 !important; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold fs-5" href="/booking">🧪 نظام إدارة المعامل والمعدات</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link" href="/booking">لوحة الحجوزات</a></li>
                <li class="nav-item"><a class="nav-link" href="/equipment">المعامل والأجهزة</a></li>
                <li class="nav-item"><a class="nav-link" href="/maintenance">طلبات الصيانة</a></li>
                <li class="nav-item"><a class="nav-link active" href="/reports">التقارير والإحصائيات</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-bold text-dark">📊 مؤشرات الأداء والتقارير الحية للكلية</h4>
        <span class="badge bg-dark px-3 py-2 fw-semibold">تحديث فوري تلقائي</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stat border-primary-custom rounded-3 bg-white p-3">
                <div class="text-secondary small fw-bold">إجمالي الأجهزة بالجرد</div>
                <div class="fs-2 fw-bold text-primary mt-1">{{ $total_equipments }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat border-success-custom rounded-3 bg-white p-3">
                <div class="text-secondary small fw-bold">أجهزة نشطة وجاهزة</div>
                <div class="fs-2 fw-bold text-success mt-1">{{ $active_equipments }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat border-warning-custom rounded-3 bg-white p-3">
                <div class="text-secondary small fw-bold">أجهزة معطلة / صيانة</div>
                <div class="fs-2 fw-bold text-warning mt-1">{{ $maintenance_count }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat border-info-custom rounded-3 bg-white p-3">
                <div class="text-secondary small fw-bold">إجمالي طلبات الحجز</div>
                <div class="fs-2 fw-bold text-info mt-1">{{ $total_bookings }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card rounded-3 shadow-sm bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">🎯 معدل جاهزية المعامل</h5>
                <p class="text-muted small">يقيس هذا المؤشر النسبة المئوية للأجهزة المستقرة والصالحة للاستخدام الفوري من قبل الطلاب حالياً.</p>
<div class="text-center my-4">
                    <span class="fs-1 fw-bold text-dark">{{ $efficiency_rate }}%</span>
                    <div class="text-secondary small fw-semibold">كفاءة تشغيلية عامة</div>
                </div>

                <div class="progress" style="height: 20px;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         style="width: {{ $efficiency_rate }}%;"
                         aria-valuenow="{{ $efficiency_rate }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <div class="mt-3 text-center small text-secondary">
                    @if($efficiency_rate >= 80)
                        <span class="text-success fw-bold">✓ وضع البنية التحتية ممتاز ومستقر</span>
                    @elseif($efficiency_rate >= 50)
                        <span class="text-warning fw-bold">⚠️ تنبيه: توجد أجهزة تحتاج صيانة سريعة</span>
                    @else
                        <span class="text-danger fw-bold">🚨 خطر: أكثر من نصف أجهزة الكلية خارج الخدمة!</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card rounded-3 shadow-sm bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">🏢 كشف جرد الأجهزة الموزعة حسب المختبرات</h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th>اسم المختبر / المعمل</th>
                                <th>إجمالي الأجهزة</th>
                                <th>النشط منها</th>
                                <th>تحت الصيانة</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @forelse($lab_summary as $summary)
                            <tr>
                                <td class="fw-bold text-dark">{{ $summary->lab_name }}</td>
                                <td class="fw-semibold text-primary">{{ $summary->total }}</td>
                                <td><span class="badge bg-success-subtle text-success px-2 py-1">{{ $summary->active }}</span></td>
                                <td><span class="badge bg-warning-subtle text-warning px-2 py-1">{{ $summary->maintenance }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-muted p-4">لا توجد أجهزة مسجلة وموزعة داخل قاعدة البيانات حتى الآن.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
