<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name ?? 'App' }} | {{ $title ?? 'Login' }}</title>

    <!-- Favicon -->
    <link href="{{ $setting->logo ? asset('storage/' . $setting->logo) : asset('niceadmin/img/laravel.png') }}"
        rel="icon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#cde49e', // Matches the soft green in the screenshot
                            greenHover: '#b8d88e',
                            greenText: '#2e3a1f',
                            lightGray: '#f6f7f9',
                            darkGray: '#1e1e1e',
                            bgGray: '#e5e7eb'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 selection:bg-brand-green selection:text-brand-greenText">

    <!-- Main Mobile-like Container -->
    <div class="w-full max-w-[400px] h-full min-h-[750px] bg-white rounded-[48px] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] p-8 relative flex flex-col justify-between overflow-hidden">
        
        <!-- Subtle Top Notch Simulation -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-[120px] h-[30px] bg-[#f0f2f5] rounded-b-[20px]"></div>

        <div class="pt-6">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-12">
                <!-- Avatar / Logo -->
                <div class="w-12 h-12 rounded-full overflow-hidden bg-brand-lightGray shadow-inner p-1">
                    @if ($setting->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="w-full h-full object-cover rounded-full">
                    @else
                        <div class="w-full h-full bg-brand-darkGray rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($setting->app_name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Right Icons -->
                <div class="flex space-x-3">
                    <div class="w-10 h-10 rounded-full border border-gray-100 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <div class="w-10 h-10 rounded-full border border-gray-100 flex items-center justify-center text-gray-400 relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <div class="absolute top-2 right-2 w-2 h-2 bg-red-400 rounded-full border border-white"></div>
                    </div>
                </div>
            </div>

            <!-- Welcome Text -->
            <div class="mb-10 text-center">
                <h1 class="text-[32px] font-bold text-brand-darkGray tracking-tight leading-tight mb-2">{{ $setting->login_title ?? 'Welcome Back' }}</h1>
                <p class="text-gray-400 text-sm font-medium">Please enter your details to sign in</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="bg-brand-lightGray rounded-[24px] p-1 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center px-4 py-3">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input id="email" name="email" type="email" required
                            value="{{ old('email') ?? ($email ?? '') }}"
                            class="bg-transparent border-none outline-none w-full text-brand-darkGray font-medium placeholder-gray-400"
                            placeholder="Email address">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="bg-brand-lightGray rounded-[24px] p-1 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center px-4 py-3 relative">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input id="password" name="password" type="password" required
                            value="{{ old('password') ?? ($password ?? '') }}"
                            class="bg-transparent border-none outline-none w-full text-brand-darkGray font-medium placeholder-gray-400 pr-10"
                            placeholder="Password">
                        
                        <!-- Toggle Password -->
                        <button type="button" id="togglePassword" class="absolute right-4 text-gray-400 hover:text-brand-darkGray transition-colors outline-none">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between px-2 pt-2">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5 mr-2 bg-brand-lightGray border-none rounded-md group-hover:bg-gray-200 transition-colors">
                            <input id="remember" name="remember" type="checkbox" value="on"
                                {{ old('remember') ? 'checked' : (isset($remember) && $remember ? 'checked' : '') }}
                                class="peer opacity-0 absolute inset-0 cursor-pointer w-full h-full z-10">
                            <svg class="w-3 h-3 text-brand-darkGray opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Remember me</span>
                    </label>
                </div>
                
                <div class="pt-8">
                    <!-- Submit Button styled like the play button in the shot -->
                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 rounded-[24px] text-lg font-bold text-brand-greenText bg-brand-green hover:bg-brand-greenHover shadow-[0_10px_20px_-10px_rgba(205,228,158,0.6)] focus:outline-none focus:ring-4 focus:ring-brand-green/30 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer section in the card -->
        <div class="text-center pb-4 pt-8 border-t border-gray-100 mt-8">
            <p class="text-xs text-gray-400 font-medium">
                {{ $setting->copyright ?? '© ' . date('Y') . ' All rights reserved.' }}
            </p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            if (isPassword) {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        });

        // Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#1e1e1e',
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-gray-100'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        let flashSuccess = "{{ session('success') ?? '' }}";
        if (flashSuccess) {
            Toast.fire({ icon: "success", title: flashSuccess });
        }

        let flashError = "{{ session('error') ?? '' }}";
        let errors = @json($errors->all());

        if (flashError) {
            Toast.fire({ icon: "error", title: flashError });
        } else if (errors.length > 0) {
            Toast.fire({ icon: "error", title: errors[0] });
        }
    </script>
</body>
</html>
