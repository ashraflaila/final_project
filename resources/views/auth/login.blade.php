<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f766e 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 430px;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.2);
        }
        .login-card .card-body {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body">
            <h3 class="mb-4 text-center">تسجيل الدخول</h3>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                    <label for="remember" class="form-check-label">تذكرني</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
            </form>
        </div>
    </div>
</body>
</html>
