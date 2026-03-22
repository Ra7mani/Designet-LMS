@props([
    'title',
    'description',
    'icon' => '🔐',
])

<div class="auth-header">
    <div class="auth-header-icon">{{ $icon }}</div>
    <h1 class="auth-header-title">{{ $title }}</h1>
    <p class="auth-header-description">{{ $description }}</p>
</div>

<style>
    .auth-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        text-align: center;
        animation: fadeIn 0.5s ease-out;
    }

    .auth-header-icon {
        font-size: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(167, 139, 250, 0.1));
        border: 2px solid var(--vl);
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.1s both;
    }

    .auth-header-title {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: 800;
        color: var(--txt);
        margin: 0;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--v), var(--va));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .auth-header-description {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
        max-width: 320px;
        line-height: 1.5;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    html.dark .auth-header-icon {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(167, 139, 250, 0.1));
    }
</style>
