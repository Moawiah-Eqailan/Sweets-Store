<head>

    <title>BATPARTS</title>
    <link href="{{ asset('images/BATPARTS.jpg') }}" type="image/x-icon" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94CA21;
        }

        .custom-shape {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #94CA21 0%, #7ba91b 100%);
            clip-path: polygon(0 0, 100% 0, 100% 80%, 0% 100%);
            z-index: -1;
        }

        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394CA21' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 relative">
    <div class="custom-shape"></div>

    <header class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center animate-slideIn">
            <div class="flex items-center">
                <i class="fas fa-cog text-white text-4xl animate-spin" style="margin: 5px;"></i>
                <h class="navbar-brand" style="font-weight: bold;">BAT<span class="text-primary" style="color: #fff; font-weight: bold;">PARTS</span></h>
            </div>

        </div>
    </header>

    <main class="container mx-auto px-4 py-8 relative">
        <div class="max-w-2xl mx-auto login-card rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">
            <div class="text-center py-6 relative overflow-hidden">
                <div class="relative z-10">
                    <i class="fas fa-user-plus text-[#94CA21] text-6xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                    <p class="text-gray-600 mt-2">Join BAT<span class="text-primary" style="color:  #94CA21; font-weight: bold;">PARTS</span></p>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="px-8 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <div class="relative">
                    <input id="name" type="text" name="name" required placeholder="Full Name"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-user input-icon"></i>
                </div>

                <div class="relative">
                    <input id="email" type="email" name="email" required placeholder="Email Address"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="relative">
                    <input id="phone" type="tel" name="phone" required placeholder="Phone Number"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-phone input-icon"></i>
                </div>

                <div class="relative">
                    <input id="address" type="text" name="address" required placeholder="Address"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-map-marker-alt input-icon"></i>
                </div>

                <div class="relative">
                    <input id="postcode" type="text" name="postcode" required placeholder="Postcode"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-map-pin input-icon"></i>
                </div>

                <div class="relative">
                    <input id="state" type="text" name="state" required placeholder="State"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-map input-icon"></i>
                </div>

                <div class="relative">
                    <select id="city" name="city" class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300 custom-select appearance-none">
                        <option value="" disabled selected>Select your city</option>
                        <option value="Amman">Amman</option>
                        <option value="Zarqa">Zarqa</option>
                        <option value="Irbid">Irbid</option>
                        <option value="Aqaba">Aqaba</option>
                        <option value="Madaba">Madaba</option>
                        <option value="Jerash">Jerash</option>
                        <option value="Ajloun">Ajloun</option>
                        <option value="Karak">Karak</option>
                        <option value="Tafilah">Tafilah</option>
                        <option value="Maan">Maan</option>
                        <option value="Balqa">Balqa</option>
                        <option value="Mafraq">Mafraq</option>
                    </select>
                    <i class="fas fa-city input-icon"></i>
                </div>

                <div class="relative">
                    <input id="password" type="password" name="password" required placeholder="Password"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-lock input-icon"></i>
                </div>

                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm Password"
                        class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 focus:border-[#94CA21] focus:ring-2 focus:ring-[#94CA21] focus:ring-opacity-50 transition-all duration-300">
                    <i class="fas fa-lock input-icon"></i>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="md:col-span-2 flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-[#94CA21] hover:underline transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Already have an account?
                    </a>

                    <button type="submit" class="bg-[#94CA21] text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105" style="color: #94CA21;">
                        <i class="fas fa-user-plus mr-2"></i>Register
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>