<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; }
        .hero { max-width: 860px; margin: 70px auto; background: white; border-radius: 24px; padding: 36px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
        .title { font-size: 2rem; font-weight: 800; color: #0f172a; }
        .subtitle { color: #475569; }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="title">واجهة المستخدم</div>
                    <div class="subtitle">مرحبًا {{ $user->first_name ?? 'User' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">تسجيل الخروج</button>
                </form>
            </div>
            <p class="mb-0">هذا الحساب لا يملك واجهة متخصصة بعد. إذا كان من المفترض أن يكون طالبًا أو مدرسًا، اربطه بسجل مناسب داخل `users.actor_type` و`users.actor_id`.</p>
        </div>
    </div>
</body>
</html>
