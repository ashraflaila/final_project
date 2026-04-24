<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واجهة الطالب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); min-height: 100vh; }
        .shell { max-width: 1180px; margin: 40px auto; }
        .hero { background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%); color: white; border-radius: 24px; padding: 30px; box-shadow: 0 18px 40px rgba(59, 130, 246, 0.18); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 24px; }
        .card-box { background: white; border-radius: 20px; padding: 22px; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08); }
        .metric { font-size: 2rem; font-weight: 800; color: #1e3a8a; }
        .table thead th { border-top: 0; white-space: nowrap; }
        .badge-soft { display: inline-block; padding: 0.35rem 0.7rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
        .badge-enrolled { background: #dbeafe; color: #1d4ed8; }
        .badge-available { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="container shell">
        <div class="hero d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">واجهة الطالب</h1>
                <p class="mb-0">مرحبًا {{ $student->name ?? 'Student' }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light">تسجيل الخروج</button>
            </form>
        </div>

        <div class="grid">
            <div class="card-box">
                <div class="text-muted mb-2">الكورسات المسجل بها</div>
                <div class="metric">{{ $coursesCount }}</div>
            </div>
            <div class="card-box">
                <div class="text-muted mb-2">الكورسات النشطة</div>
                <div class="metric">{{ $activeCoursesCount }}</div>
            </div>
            <div class="card-box">
                <div class="text-muted mb-2">إجمالي الدروس</div>
                <div class="metric">{{ $lessonsCount }}</div>
            </div>
        </div>

        <div class="card-box mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">إدارة تسجيلاتي في الكورسات</h2>
                <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-primary">تحديث</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>المدرس</th>
                            <th>السعر</th>
                            <th>نوع الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $enrolledRows = $latestCourses->map(function ($course) {
                                return ['course' => $course, 'state' => 'enrolled'];
                            });
                            $availableRows = $availableCourses->map(function ($course) {
                                return ['course' => $course, 'state' => 'available'];
                            });
                            $allRows = $enrolledRows->concat($availableRows);
                        @endphp

                        @forelse($allRows as $row)
                            @php $course = $row['course']; @endphp
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ optional($course->teacher)->name ?? '-' }}</td>
                                <td>{{ $course->price }}</td>
                                <td>
                                    @if($row['state'] === 'enrolled')
                                        <span class="badge-soft badge-enrolled">مسجل</span>
                                    @else
                                        <span class="badge-soft badge-available">متاح للتسجيل</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row['state'] === 'enrolled')
                                        <form action="{{ route('student.courses.unenroll', $course) }}" method="POST" onsubmit="return confirm('هل تريد إلغاء التسجيل من هذا الكورس؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">إلغاء التسجيل</button>
                                        </form>
                                    @else
                                        <form action="{{ route('student.courses.enroll', $course) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">سجل في الكورس</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد كورسات متاحة أو مسجل بها حاليًا.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
