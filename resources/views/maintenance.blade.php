<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المعامل - طلبات الصيانة الفنية</title>
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
                <li class="nav-item"><a class="nav-link" href="/booking">لوحة الحجوزات</a></li>
                <li class="nav-item"><a class="nav-link" href="/equipment">المعامل والأجهزة</a></li>
                <li class="nav-item"><a class="nav-link active" href="/maintenance">طلبات الصيانة</a></li>
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
        
        <div class="col-lg-4">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">إرسال بلاغ عطل فني</h5>
                    
                    <form action="/maintenance/store" method="POST">
                        @csrf 
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">كود الجهاز المعطل:</label>
                            <input type="text" name="equipment_code" class="form-control" placeholder="مثال: EQ-101" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">اسم مقدم البلاغ (المعيد/الفني):</label>
                            <input type="text" name="reporter_name" class="form-control" placeholder="اسم مهندس المعمل" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">وصف تفصيلي للعطل الفني:</label>
                            <textarea name="issue_description" class="form-control" rows="3" placeholder="اكتبي هنا طبيعة المشكلة (مثلاً: الشاشة لا تستجيب، عطل في كرت الشبكة...)" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 fw-bold text-white shadow-sm mt-2">
                            🚨 إرسال الطلب لمهندسي الصيانة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card rounded-3 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">سجل تتبع وإدارة عمليات الصيانة</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                         <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th>كود الجهاز</th>
                                    <th>وصف العطل</th>
                                    <th>مقدم البلاغ</th>
                                    <th>الحالة التشغيلية</th>
                                    <th>إجراءات الفني والمشرف</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6">
                                @forelse($reports as $report)
                                <tr>
                                    <td class="fw-bold text-danger">{{ $report->equipment_code }}</td>
                                    <td class="text-wrap" style="max-width: 200px;">{{ $report->issue_description }}</td>
                                    <td class="small fw-semibold text-secondary">{{ $report->reporter_name }}</td>
                                    <td>
                                        @if($report->status == 'قيد الانتظار')
                                            <span class="badge bg-danger px-2 py-1">قيد الانتظار ⏳</span>
                                        @elseif($report->status == 'جاري الإصلاح')
                                            <span class="badge bg-warning text-dark px-2 py-1">جاري الإصلاح 🛠️</span>
                                        @else
                                            <span class="badge bg-success px-2 py-1">تم الإصلاح بنجاح ✓</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($report->status == 'قيد الانتظار')
                                                <a href="/maintenance/status/{{ $report->id }}/جاري الإصلاح" class="btn btn-warning text-dark fw-bold">بدء الإصلاح</a>
                                            @endif
                                            
                                            @if($report->status != 'تم الإصلاح')
                                                <a href="/maintenance/status/{{ $report->id }}/تم الإصلاح" class="btn btn-success fw-bold">تم الإصلاح ✓</a>
                                            @else
                                                <span class="text-muted small">مكتمل ومؤرشف</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-muted p-4">لا توجد بلاغات أو طلبات صيانة نشطة حالياً.</td>
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