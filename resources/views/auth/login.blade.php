<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Ravenclaw Library</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;

            background: #F2EDE3;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #3F4438;
        }

        /* ===== LOGIN CONTAINER ===== */

        .login-box {
            width: 100%;
            max-width: 410px;
            padding: 38px 36px;

            background: #F8F4EC;
            border: 1px solid #DCCDBB;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(90, 70, 54, 0.10);
        }

        /* ===== BRAND ===== */

        .login-brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-mark {
            width: 58px;
            height: 58px;
            margin: 0 auto 17px;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 18px;
            background: #6F8060;
            color: #FFFDF8;

            font-size: 1.6rem;
            font-weight: 700;
        }

        h1 {
            margin: 0 0 9px;
            color: #526747;
            font-size: 1.75rem;
            font-weight: 750;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            margin: 0;
            color: #8A7768;
            font-size: 0.94rem;
            line-height: 1.6;
        }

        /* ===== ERROR MESSAGE ===== */

        .error-message {
            margin-bottom: 20px;
            padding: 12px 14px;

            border: 1px solid #E3C0C7;
            border-radius: 9px;
            background: #F5DDE1;
            color: #8F5967;

            font-size: 0.88rem;
            line-height: 1.5;
        }

        /* ===== FORM ===== */

        .form-group {
            margin-bottom: 19px;
        }

        label {
            display: block;
            margin-bottom: 8px;

            color: #5A4636;
            font-size: 0.9rem;
            font-weight: 650;
        }

        input {
            display: block;
            width: 100%;
            padding: 13px 14px;

            border: 1px solid #D2C1AE;
            border-radius: 10px;
            background: #FFFDF8;
            color: #3F4438;

            font-family: inherit;
            font-size: 0.95rem;
            outline: none;

            transition: border-color 0.2s ease,
                        box-shadow 0.2s ease;
        }

        input::placeholder {
            color: #A09282;
        }

        input:focus {
            border-color: #B87586;
            box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.13);
        }

        /* ===== LOGIN BUTTON ===== */

        .login-button {
            width: 100%;
            margin-top: 8px;
            padding: 13px 16px;

            border: none;
            border-radius: 10px;
            background: #6F8060;
            color: #FFFDF8;

            font-family: inherit;
            font-size: 0.96rem;
            font-weight: 700;
            cursor: pointer;

            transition: background 0.2s ease,
                        transform 0.2s ease;
        }

        .login-button:hover {
            background: #5F7053;
            transform: translateY(-1px);
        }

        .login-button:focus-visible {
            outline: 3px solid #B87586;
            outline-offset: 3px;
        }

        /* ===== FOOTER ===== */

        .login-footer {
            margin: 25px 0 0;
            padding-top: 18px;

            border-top: 1px solid #E8DED2;
            color: #8A7768;

            text-align: center;
            font-size: 0.8rem;
            line-height: 1.6;
        }

        /* ===== SMALL SCREENS ===== */

        @media (max-width: 480px) {
            .login-box {
                padding: 30px 23px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <main class="login-box">

        <div class="login-brand">

            <h1>Ravenclaw Library</h1>

            <p class="login-subtitle">
                Administrator sign in
            </p>
        </div>

        @if ($errors->any())
            <div class="error-message" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Log in
            </button>
        </form>

        <p class="login-footer">
            Ravenclaw Library · Administrator Access
        </p>

    </main>

</body>
</html>
