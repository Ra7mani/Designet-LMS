<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            :root {
                --v: #7C3AED;
                --va: #A78BFA;
                --vgrad: linear-gradient(135deg, #7C3AED, #A78BFA);
                --vxl: #F3E8FF;
                --vl: #DDD6FE;
                --mint: #D1FAE5;
                --mintd: #059669;
                --rose: #FCE7F3;
                --rosed: #DB2777;
                --sky: #E0F2FE;
                --skyd: #0284C7;
                --yel: #FEF3C7;
                --yeld: #D97706;
                --txt: #1F2937;
                --muted: #6B7280;
                --border: #E5E7EB;
                --sh: 0 4px 12px rgba(31, 41, 55, 0.08);
                --shlift: 0 10px 30px rgba(124, 58, 237, 0.15);
                --rp: 10px;
                --r: 14px;
                --bg: #F9FAFB;
            }

            html.dark {
                --txt: #F3F4F6;
                --muted: #9CA3AF;
                --border: #374151;
                --sh: 0 4px 12px rgba(0, 0, 0, 0.25);
                --shlift: 0 10px 30px rgba(124, 58, 237, 0.25);
                --bg: #0F172A;
                --vxl: #2D1B69;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'DM Sans', 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #F3E8FF 0%, #E0F2FE 100%);
                min-height: 100vh;
                overflow-x: hidden;
                position: relative;
            }

            html.dark body {
                background: linear-gradient(135deg, #1E1B4B 0%, #0F172A 50%, #1A1A2E 100%);
            }

            /* Decorative background elements */
            body::before {
                content: '';
                position: fixed;
                top: -50px;
                right: -100px;
                width: 400px;
                height: 400px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(124, 58, 237, 0.15), transparent);
                pointer-events: none;
                z-index: 0;
            }

            body::after {
                content: '';
                position: fixed;
                bottom: -150px;
                left: -100px;
                width: 350px;
                height: 350px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(167, 139, 250, 0.1), transparent);
                pointer-events: none;
                z-index: 0;
            }

            html.dark body::before {
                background: radial-gradient(circle, rgba(124, 58, 237, 0.25), transparent);
            }

            html.dark body::after {
                background: radial-gradient(circle, rgba(167, 139, 250, 0.15), transparent);
            }

            /* Main container */
            .auth-container {
                min-h-screen;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 24px 16px;
                position: relative;
                z-index: 1;
            }

            /* Logo */
            .auth-logo {
                margin-bottom: 40px;
                animation: fadeInDown 0.6s ease-out;
            }

            .auth-logo a {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
                text-decoration: none;
                color: inherit;
            }

            .auth-logo-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                border-radius: 12px;
                background: var(--vgrad);
                box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3);
                transition: all 0.3s ease;
            }

            .auth-logo a:hover .auth-logo-icon {
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(124, 58, 237, 0.4);
            }

            .auth-logo-icon svg {
                width: 24px;
                height: 24px;
                fill: white;
            }

            .auth-logo-text {
                font-size: 14px;
                font-weight: 600;
                color: var(--muted);
                letter-spacing: 0.5px;
            }

            /* Form card */
            .auth-card {
                width: 100%;
                max-width: 420px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: var(--r);
                border: 1.5px solid rgba(255, 255, 255, 0.5);
                padding: 40px 32px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
                animation: fadeInUp 0.6s ease-out 0.1s both;
            }

            html.dark .auth-card {
                background: rgba(15, 23, 42, 0.8);
                border-color: rgba(124, 58, 237, 0.2);
            }

            /* Form content */
            .auth-form {
                display: flex;
                flex-direction: column;
                gap: 24px;
            }

            /* Links at bottom */
            .auth-footer {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
                margin-top: 24px;
                padding-top: 24px;
                border-top: 1.5px solid var(--border);
            }

            .auth-footer-text {
                font-size: 13px;
                color: var(--muted);
                text-align: center;
            }

            .auth-footer-text a {
                color: var(--v);
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .auth-footer-text a:hover {
                text-decoration: underline;
                color: var(--va);
            }

            /* Animations */
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Input styling */
            flux\:input input {
                font-family: 'DM Sans', sans-serif !important;
            }

            flux\:input input:focus {
                box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1), 0 0 0 1.5px var(--v) !important;
                border-color: var(--v) !important;
            }

            /* Button styling */
            flux\:button[variant="primary"] {
                background: var(--vgrad) !important;
                box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3) !important;
                transition: all 0.3s ease !important;
            }

            flux\:button[variant="primary"]:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 12px 28px rgba(124, 58, 237, 0.4) !important;
            }

            flux\:button[variant="primary"]:active {
                transform: translateY(0) !important;
            }

            /* Responsive */
            @media (max-width: 480px) {
                .auth-card {
                    padding: 32px 24px;
                }

                .auth-logo {
                    margin-bottom: 30px;
                }

                body::before {
                    width: 250px;
                    height: 250px;
                    top: -50px;
                    right: -50px;
                }

                body::after {
                    width: 200px;
                    height: 200px;
                    bottom: -80px;
                    left: -50px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                * {
                    animation: none !important;
                    transition: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-logo">
                <a href="{{ route('home') }}" wire:navigate>
                    <div class="auth-logo-icon">
                        <x-app-logo-icon class="size-6 fill-current" />
                    </div>
                    <span class="auth-logo-text">{{ config('app.name', 'Designet') }}</span>
                </a>
            </div>

            <div class="auth-card">
                <div class="auth-form">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
