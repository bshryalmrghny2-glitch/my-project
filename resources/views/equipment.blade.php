<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المعامل - جرد الأجهزة والمعدات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Cairo', sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table th { font-weight: 700; color: #5a6a85; }
        .badge-active { background-color: #28a745; color: white; }
        .badge-maintenance { background-color: #ffc107; color: #212529; }
        .badge-out { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold fs-5" href="/booking">🧪 نظام إدارة المعامل والمعدات</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item"><a class="nav-link" href="/booking">لوحة الحجوزات</a></li>
                <li class="nav-item"><a class="nav-link active" href="/equipment">المعامل والأجهزة</a></li>
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

        <div class="col-lg-4">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">تسجيل جهاز جديد</h5>

                    <form action="/equipment/store" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">كود الجهاز (Unique Code):</label>
                            <input type="text" name="equipment_code" class="form-control" placeholder="مثال: EQ-101" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">اسم الجهاز / المعدة:</label>
                            <input type="text" name="name" class="form-control" placeholder="مثال: حاسوب ايمك i7" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">تخصيص المعمل:</label>
                            <select name="lab_name" class="form-select" required>
                                <option value="معمل 1">معمل 1 (الشبكات)</option>
                                <option value="معمل 2">معمل 2 (البرمجيات)</option>
                                <option value="معمل 3">معمل 3 (الذكاء الاصطناعي)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">الحالة التشغيلية المبدئية:</label>
                            <select name="status" class="form-select">
                                <option value="نشط">نشط وجاهز</option>
                                <option value="تحت الصيانة">تحت الصيانة</option>
                                <option value="خارج الخدمة">خارج الخدمة (كهين)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">ملاحظات ومواصفات إضافية:</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="الرامات، المعالج، أو العهدة تابعة لمن..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold text-white shadow-sm mt-2">
                            💾 حفظ الجهاز في الجرد
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card rounded-3 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">سجل جرد الأجهزة والمعامل داخل الكلية</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light text-secondary small">
                                <tr>
                                    <th>كود الجهاز</th>
                                    <th>اسم المعدة</th>
                                    <th>المعمل التابع له</th>
                                    <th>الحالة الفنية</th>
                                    <th>الإجراءات والتحكم بالوقت الفعلي</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6">
                                @forelse($items as $item)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $item->equipment_code }}</td>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td><span class="badge bg-secondary px-2 py-1">{{ $item->lab_name }}</span></td>
                                    <td>
                                        @if($item->status == 'نشط')
                                            <span class="badge badge-active px-2 py-1">نشط ✓</span>
                                        @elseif($item->status == 'تحت الصيانة')
                                            <span class="badge badge-maintenance px-2 py-1">تحت الصيانة 🔧</span>
                                        @else
                                            <span class="badge badge-out px-2 py-1">خارج الخدمة ✗</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/equipment/status/{{ $item->id }}/نشط" class="btn btn-outline-success">نشط</a>
                                            <a href="/equipment/status/{{ $item->id }}/تحت الصيانة" class="btn btn-outline-warning text-dark">صيانة</a>
                                            <a href="/equipment/status/{{ $item->id }}/خارج الخدمة" class="btn btn-outline-danger">إلغاء</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-muted p-4">لا توجد أجهزة أو معدات مسجلة في جرد الكلية حالياً.</td>
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
### Project Developed by:
- Heba Jwan

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
