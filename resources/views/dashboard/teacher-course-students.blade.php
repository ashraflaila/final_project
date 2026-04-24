<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة طلاب الكورس</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); min-height: 100vh; }
        .shell { max-width: 1100px; margin: 40px auto; }
        .card-box { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08); }
    </style>
</head>
<body>
    <div class="container shell">
        <div class="card-box">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1">الطلاب المسجلون في الكورس</h1>
                    <div class="text-muted">{{ $course->title }}</div>
                </div>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">رجوع</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ trim(($student->name ?? '') . ' ' . ($student->last_name ?? '')) }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->status }}</td>
                                <td>
                                    <form action="{{ route('teacher.courses.students.destroy', [$course, $student]) }}" method="POST" onsubmit="return confirm('هل تريد حذف الطالب من هذا الكورس؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف من الكورس</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا يوجد طلاب مسجلون في هذا الكورس.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
