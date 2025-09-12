<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Login (Fallback)</title>
</head>

<body style="font-family:system-ui;margin:2rem;max-width:420px">
    <h1>ログイン（職員ID）※フォールバック</h1>

    @if ($errors->any())
        <div style="padding:.5rem;color:#b91c1c;background:#fee2e2;border-radius:.5rem;margin:.5rem 0">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.employee') }}" style="display:grid;gap:.75rem">
        @csrf

        <label>職員ID
            <input name="employee_id" value="{{ old('employee_id') }}" {{-- ★ 失敗時に値を復元 --}} required
                autocomplete="username" style="width:100%;padding:.5rem">
        </label>
        @error('employee_id')
            <div style="color:#b91c1c;font-size:.9rem">{{ $message }}</div>
        @enderror

        <label>パスワード
            <input name="password" type="password" required autocomplete="current-password"
                style="width:100%;padding:.5rem">
        </label>
        @error('password')
            <div style="color:#b91c1c;font-size:.9rem">{{ $message }}</div>
        @enderror

        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログイン状態を保持</label>

        <button type="submit" style="padding:.6rem 1rem">ログイン</button>
    </form>
</body>

</html>
