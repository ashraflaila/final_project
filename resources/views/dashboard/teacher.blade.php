<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واجهة المدرس</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); min-height: 100vh; }
        .shell { max-width: 1180px; margin: 40px auto; }
        .hero { background: linear-gradient(135deg, #0f766e 0%, #10b981 100%); color: white; border-radius: 24px; padding: 30px; box-shadow: 0 18px 40px rgba(5, 150, 105, 0.18); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 24px; }
        .card-box { background: white; border-radius: 20px; padding: 22px; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08); }
        .metric { font-size: 2rem; font-weight: 800; color: #064e3b; }
        .table thead th { border-top: 0; white-space: nowrap; }
        .badge-soft { display: inline-block; padding: 0.35rem 0.7rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container shell">
        <div class="hero d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">واجهة المدرس</h1>
                <p class="mb-0">مرحبًا {{ $teacher->name ?? 'Teacher' }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light">تسجيل الخروج</button>
            </form>
        </div>

        <div class="grid">
            <div class="card-box">
                <div class="text-muted mb-2">عدد الكورسات</div>
                <div class="metric">{{ $coursesCount }}</div>
            </div>
            <div class="card-box">
                <div class="text-muted mb-2">الكورسات النشطة</div>
                <div class="metric">{{ $activeCoursesCount }}</div>
            </div>
            <div class="card-box">
                <div class="text-muted mb-2">عدد الدروس</div>
                <div class="metric">{{ $lessonsCount }}</div>
            </div>
        </div>

        <div class="card-box mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">كل الكورسات التي تديرها</h2>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-success">تحديث</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>عدد الطلاب</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($managedCourses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->price }}</td>
                                <td>
                                    <span class="badge-soft {{ ($course->status ?? 'Inactive') === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ $course->status }}
                                    </span>
                                </td>
                                <td>{{ $course->students_count }}</td>
                                <td>
                                    <a href="{{ route('teacher.courses.students', $course) }}" class="btn btn-sm btn-outline-success">إدارة الطلاب</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد كورسات لإدارتها حاليًا.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
