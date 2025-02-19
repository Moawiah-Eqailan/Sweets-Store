<html lang="en" dir="ltr">

<head>
    <title>Sweet Store - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        @keyframes floatIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes sweetFade {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .bg-primary {
            background-color: #b1a05a;
        }

        .text-primary {
            color: #b1a05a;
        }

        .border-primary {
            border-color: #b1a05a;
        }

        .custom-background {
            background: linear-gradient(135deg, #b1a05a 0%, #8c7d45 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.8;
        }

        .pattern-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .login-card {
            animation: sweetFade 0.8s ease-out forwards;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .logo-text {
            animation: floatIn 0.6s ease-out forwards;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b1a05a;
        }

        .custom-input {
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            border-color: #b1a05a;
            box-shadow: 0 0 0 3px rgba(177, 160, 90, 0.2);
        }

        .login-button {
            background-color: #b1a05a;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: #968649;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 relative">
    <div class="custom-background"></div>
    <div class="pattern-overlay"></div>
    <header class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center animate-slideIn">
            <div class="flex items-center">
                <h class="navbar-brand" style="font-weight: bold;">Sweet <span class="text-primary"
                        style="color: #fff; font-weight: bold;"> Store</span></h>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12 relative">
        <div class="max-w-md mx-auto login-card rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">
            <div class="text-center py-8 relative overflow-hidden">
                <div class="relative z-10">
                    <i class="fas fa-user-circle text-[#94CA21] text-6xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Login</h2>
                    <p class="text-gray-600 mt-2">Welcome <span class="text-primary"
                            style="color: #b1a05a; font-weight: bold;">Admin</span></p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="px-8 py-6">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color: red;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <p style="color: red;">{{ session('error') }}</p>

                    </div>
                @endif
                <br>
                <div class="mb-6 relative">
                    <input id="email" type="email" name="email" required placeholder="Email Address"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="mb-6 relative">
                    <input id="password" type="password" name="password" required placeholder="Password"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-lock input-icon"></i>
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-[#94CA21] focus:ring-[#94CA21]"
                            style="margin-left: 8px; ">
                        <span class="ml-2 text-gray-600"> Remember Me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-[#94CA21] text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105"
                    style="color: #b1a05a;">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
        </div>
    </main>
</body>

</html>
