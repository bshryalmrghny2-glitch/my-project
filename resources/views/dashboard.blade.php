<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم فني المعمل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center text-dark">لوحة إدارة الطلبات (خاص بفني المعمل)</h2>
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>رقم قيد الطالب (الموثق بالـ API)</th>
                            <th>كود المعدة/المعمل</th>
                            <th>وقت البدء</th>
                            <th>الحالة الحالية</th>
                            <th>الإجراءات والأزرار</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>22218087</td>
                            <td>EQ-MIC01</td>
                            <td>2026-07-05 10:00</td>
                            <td><span class="badge bg-warning text-dark">قيد الانتظار</span></td>
                            <td>
                                <button class="btn btn-sm btn-success mx-1">موافقة ✅</button>
                                <button class="btn btn-sm btn-danger mx-1">رفض ❌</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ### Project Developed by:
- Heba Jwan
</body>
</html>