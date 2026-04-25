<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Edu Platform') }}</title>

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}">
        @endisset

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; }
            html, body { min-height: 100%; margin: 0; }
            body {
                font-family: "Cairo", sans-serif;
                -webkit-tap-highlight-color: transparent;
                background: #fffbf7;
                color: #2d2640;
            }

            .page-shell {
                min-height: 100vh;
                padding-bottom: max(88px, calc(env(safe-area-inset-bottom) + 88px));
            }

            .hero-pattern {
                background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
                position: relative;
                overflow: hidden;
                border-radius: 0 0 40px 40px;
            }

            .hero-pattern::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 85% 15%, rgba(255, 255, 255, 0.18) 0%, transparent 50%),
                    radial-gradient(circle at 10% 85%, rgba(236, 72, 153, 0.35) 0%, transparent 50%);
                pointer-events: none;
            }

            .soft-card {
                background: white;
                border: 1px solid rgba(124, 58, 237, 0.08);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            .lb-on {
                background: linear-gradient(135deg, #7c3aed, #ec4899);
                color: white;
            }

            .lb-off {
                background: rgba(124, 58, 237, 0.06);
                color: #94a3b8;
                border: 1px solid rgba(124, 58, 237, 0.15);
            }

            .lb-off:hover {
                background: rgba(124, 58, 237, 0.12);
                color: #7c3aed;
            }

            .lb-card {
                background: white;
                border: 1px solid rgba(124, 58, 237, 0.08);
                border-radius: 14px;
                padding: 14px 18px;
                display: flex;
                align-items: center;
                gap: 14px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            .lb-rank-1 {
                border-color: rgba(251, 191, 36, 0.45);
                background: rgba(254, 249, 195, 0.5);
            }

            .lb-rank-2 {
                border-color: rgba(148, 163, 184, 0.3);
                background: white;
            }

            .lb-rank-3 {
                border-color: rgba(205, 127, 50, 0.35);
                background: rgba(255, 237, 213, 0.4);
            }

            .subject-card {
                cursor: pointer;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .subject-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 32px -8px rgba(161, 196, 253, 0.35);
            }

            .unit-card {
                cursor: pointer;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                background: white;
                border: 1px solid rgba(124, 58, 237, 0.1);
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            }

            .unit-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(124, 58, 237, 0.15);
            }

            .lesson-card {
                cursor: pointer;
                transition: all 0.2s ease;
                background: white;
                border: 1px solid rgba(124, 58, 237, 0.08);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            .lesson-card:hover {
                background: rgba(124, 58, 237, 0.04);
                transform: translateX(4px);
                border-color: rgba(124, 58, 237, 0.2);
            }

            .glow-btn {
                transition: all 0.3s ease;
                background: linear-gradient(135deg, #7c3aed, #ec4899);
                box-shadow: 0 4px 20px rgba(124, 58, 237, 0.3);
                min-height: 52px;
            }

            .glow-btn:hover {
                box-shadow: 0 6px 30px rgba(124, 58, 237, 0.5);
                transform: translateY(-2px);
            }

            @keyframes pulse-ring {
                0%   { transform: scale(1);    opacity: 0.6; }
                70%  { transform: scale(1.55); opacity: 0; }
                100% { transform: scale(1.55); opacity: 0; }
            }
            @keyframes shimmer {
                0%   { left: -80%; }
                100% { left: 130%; }
            }
            @keyframes rocket-bounce {
                0%, 100% { transform: translateX(0)  rotate(-15deg); }
                50%       { transform: translateX(5px) rotate(-15deg); }
            }

            .hero-cta {
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, #6d28d9 0%, #9333ea 45%, #ec4899 100%);
                box-shadow: 0 6px 32px rgba(124, 58, 237, 0.55), 0 2px 8px rgba(0,0,0,0.12);
                min-height: 60px;
                font-size: 1.2rem;
                letter-spacing: 0.02em;
                border: 2px solid rgba(255,255,255,0.25);
                transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
            }
            .hero-cta::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                background: inherit;
                animation: pulse-ring 2.2s ease-out infinite;
                z-index: -1;
            }
            .hero-cta::after {
                content: "";
                position: absolute;
                top: -50%; left: -80%;
                width: 55%; height: 200%;
                background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.35) 50%, transparent 70%);
                animation: shimmer 2.8s ease-in-out infinite;
                pointer-events: none;
            }
            .hero-cta:hover {
                transform: translateY(-4px) scale(1.03);
                box-shadow: 0 12px 48px rgba(124, 58, 237, 0.7), 0 4px 12px rgba(0,0,0,0.15);
                filter: brightness(1.08);
            }
            .hero-cta:active {
                transform: translateY(-1px) scale(0.99);
                box-shadow: 0 5px 20px rgba(124, 58, 237, 0.45);
            }
            .hero-cta .rocket-icon {
                display: inline-block;
                animation: rocket-bounce 1.4s ease-in-out infinite;
                font-style: normal;
            }
            .hero-cta:hover .rocket-icon {
                animation-duration: 0.7s;
            }

            .glass-bottom-nav {
                background: rgba(255, 255, 255, 0.94);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-top: 1px solid rgba(124, 58, 237, 0.1);
                box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.07);
            }

            .fade-in {
                animation: fadeIn 0.4s ease forwards;
            }

            .particle {
                position: absolute;
                border-radius: 50%;
                pointer-events: none;
                animation: float 6s ease-in-out infinite;
            }

            .prose-public {
                color: #475569;
            }

            .prose-public h1,
            .prose-public h2,
            .prose-public h3,
            .prose-public h4 {
                color: #7c3aed;
            }

            .prose-public a {
                color: #ec4899;
            }

            .prose-public strong {
                color: #2d2640;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes float {
                0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
                50% { transform: translateY(-20px) scale(1.1); opacity: 0.6; }
            }

            /* ── Leaderboard avatars ── */
            .lb-avatar {
                width: 44px; height: 44px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.1rem; font-weight: 900; color: white; flex-shrink: 0;
            }

            /* ── Progress bars ── */
            .progress-track {
                height: 5px; background: rgba(0,0,0,0.07);
                border-radius: 99px; overflow: hidden; flex: 1;
            }
            .progress-fill {
                height: 100%; border-radius: 99px; min-width: 4px;
            }

            /* ── Active badge ── */
            .active-badge {
                font-size: 9px; font-weight: 900; padding: 2px 7px;
                border-radius: 99px;
                background: linear-gradient(135deg, #fbbf24, #f59e0b);
                color: white; white-space: nowrap; flex-shrink: 0;
            }

            /* ── User points card ── */
            .user-pts-card {
                margin-top: 14px; padding: 14px 18px;
                background: linear-gradient(135deg, rgba(124,58,237,0.07), rgba(236,72,153,0.07));
                border: 1.5px solid rgba(124,58,237,0.15); border-radius: 18px;
                display: flex; align-items: center; justify-content: space-between;
            }

            /* ── Continue card ── */
            .continue-card {
                display: flex; align-items: center; gap: 14px; background: white;
                border: 1.5px solid rgba(124,58,237,0.15); border-radius: 22px;
                padding: 16px; text-decoration: none; color: inherit;
                box-shadow: 0 4px 20px rgba(124,58,237,0.1); transition: all 0.25s ease;
            }
            .continue-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 32px rgba(124,58,237,0.2);
                border-color: rgba(124,58,237,0.3);
            }

            /* ── Quick access cards ── */
            .quick-card {
                display: flex; flex-direction: column; align-items: center;
                gap: 6px; text-align: center; background: white;
                border: 1.5px solid rgba(124,58,237,0.1); border-radius: 22px;
                padding: 20px 10px 16px; text-decoration: none; color: #2d2640;
                box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.25s ease;
            }
            .quick-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 28px rgba(124,58,237,0.15);
                border-color: rgba(124,58,237,0.25);
            }

            /* ── Featured subject cards ── */
            .feat-sub-card {
                display: block; text-decoration: none; border-radius: 24px;
                padding: 20px 18px; border: 1.5px solid transparent;
                transition: all 0.25s ease;
            }
            .feat-sub-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(0,0,0,0.1);
            }

            /* ── Most visited cards ── */
            .visited-card {
                display: flex; align-items: center; gap: 12px; background: white;
                border: 1px solid rgba(124,58,237,0.08); border-radius: 18px;
                padding: 14px 16px; text-decoration: none; color: inherit;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.2s ease;
            }
            .visited-card:hover {
                border-color: rgba(124,58,237,0.2);
                transform: translateX(-4px);
                box-shadow: 0 4px 16px rgba(124,58,237,0.1);
            }

            /* ── Views badge ── */
            .views-badge {
                display: flex; align-items: center; gap: 4px;
                background: rgba(124,58,237,0.08); color: #7c3aed;
                font-size: 11px; font-weight: 700; padding: 5px 10px;
                border-radius: 99px; white-space: nowrap; flex-shrink: 0;
            }

            /* ── Secondary CTA ── */
            .secondary-cta {
                display: flex; align-items: center; justify-content: center; gap: 8px;
                background: rgba(255,255,255,0.15);
                border: 1.5px solid rgba(255,255,255,0.35);
                color: white; font-weight: 700; font-size: 0.95rem;
                border-radius: 3rem; padding: 12px 24px;
                text-decoration: none; backdrop-filter: blur(4px);
                transition: all 0.25s ease; margin-top: 12px;
            }
            .secondary-cta:hover {
                background: rgba(255,255,255,0.25);
                border-color: rgba(255,255,255,0.5);
                transform: translateY(-2px);
            }
        </style>

        {{-- Arabic digit conversion + MathJax for math expressions (√ ∫ fractions powers) --}}
        <script>
            const _arabicDigits = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            const _arabicSkip   = new Set(['SCRIPT','STYLE','NOSCRIPT','TEXTAREA','INPUT','SELECT','BUTTON','PRE','CODE']);
            let   _mathJaxReady = false;

            function toArabicDigits(str) {
                return str.replace(/[0-9]/g, w => _arabicDigits[+w]);
            }

            // Convert text nodes inside a subtree; skips MathJax output and form elements
            function convertSubtree(root) {
                const walker = document.createTreeWalker(
                    root, NodeFilter.SHOW_TEXT,
                    { acceptNode: node => {
                        let el = node.parentElement;
                        while (el) {
                            if (_arabicSkip.has(el.tagName) || el.closest('mjx-container')) {
                                return NodeFilter.FILTER_REJECT;
                            }
                            el = el.parentElement;
                        }
                        return NodeFilter.FILTER_ACCEPT;
                    }}
                );
                const nodes = [];
                let n;
                while (n = walker.nextNode()) nodes.push(n);
                nodes.forEach(n => { n.nodeValue = toArabicDigits(n.nodeValue); });
            }

            // Initial full-page conversion — called after MathJax finishes its first render
            function applyArabicNumbers() { convertSubtree(document.body); }

            // MutationObserver: handles dynamically added content (AJAX, Livewire, etc.)
            function startDynamicArabicObserver() {
                let _mjxBusy = false;

                new MutationObserver(mutations => {
                    if (_mjxBusy) return;

                    const added = [];
                    mutations.forEach(m => m.addedNodes.forEach(node => {
                        if (node.nodeType !== Node.ELEMENT_NODE) return;
                        const tag = node.tagName || '';
                        // Ignore nodes created by MathJax itself
                        if (tag.startsWith('MJX') || node.closest?.('mjx-container')) return;
                        added.push(node);
                    }));

                    if (!added.length) return;

                    // Let MathJax render any LaTeX in the new content first, then convert digits
                    _mjxBusy = true;
                    const finish = () => { _mjxBusy = false; added.forEach(convertSubtree); };

                    window.MathJax?.typesetPromise
                        ? MathJax.typesetPromise(added).then(finish).catch(finish)
                        : finish();
                }).observe(document.body, { childList: true, subtree: true });
            }

            // Expose globally so any AJAX callback can trigger conversion on a new element
            window.convertSubtreeToArabic = convertSubtree;

            window.MathJax = {
                tex: {
                    inlineMath: [['\\(', '\\)']],
                    displayMath: [['\\[', '\\]']]
                },
                options: {
                    skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'input', 'select']
                },
                startup: {
                    ready() {
                        MathJax.startup.defaultReady();
                        MathJax.startup.promise.then(() => {
                            _mathJaxReady = true;
                            applyArabicNumbers();
                            startDynamicArabicObserver();
                        });
                    }
                }
            };
        </script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

        @stack('head')
    </head>
    <body>
        @php
            $isHomeRoute = request()->routeIs('home');
            $isLessonsRoute = request()->routeIs('lessons.*');
            $isSubjectsRoute = request()->routeIs('subjects.*');
            $isAdminRoute = str_starts_with(request()->path(), 'admin');
            $isLoginRoute = request()->routeIs('login');
        @endphp

        <div class="page-shell">
            <nav
                class="sticky top-0 z-50"
                style="
                    padding-top: max(12px, env(safe-area-inset-top));
                    background: rgba(255, 251, 247, 0.92);
                    backdrop-filter: blur(20px);
                    border-bottom: 1px solid rgba(124, 58, 237, 0.08);
                    box-shadow: 0 1px 12px rgba(0, 0, 0, 0.04);
                "
            >
                <div class="max-w-lg mx-auto px-4 py-2 flex items-center justify-between">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/logo1.png') }}" alt="الشعار" class="w-full h-full object-cover">
                    </div>

                    <h1 class="text-base font-black" style="color: #7c3aed">
                        منصة رحلتك التفاعلية نحو التميز
                    </h1>

                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/logo2.png') }}" alt="الشعار" class="w-full h-full object-cover">
                    </div>
                </div>
            </nav>

            {{ $slot }}
        </div>

        <div
            class="fixed bottom-0 left-0 right-0 z-50"
            style="
                background: rgba(255, 255, 255, 0.94);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-top: 1px solid rgba(124, 58, 237, 0.1);
                box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.07);
                padding-bottom: max(16px, env(safe-area-inset-bottom));
            "
        >
            <div class="max-w-lg mx-auto px-6 pt-3 flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-1" style="text-decoration: none">
                    <div
                        class="w-12 h-9 rounded-2xl flex items-center justify-center"
                        style="{{ $isHomeRoute ? 'background: rgba(124, 58, 237, 0.12)' : '' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $isHomeRoute ? '#7C3AED' : '#94a3b8' }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold" style="color: {{ $isHomeRoute ? '#7c3aed' : '#94a3b8' }}">الرئيسية</span>
                </a>

                <a href="{{ route('lessons.index') }}" class="flex flex-col items-center gap-1" style="text-decoration: none">
                    <div
                        class="w-12 h-9 rounded-2xl flex items-center justify-center"
                        style="{{ $isLessonsRoute || $isSubjectsRoute ? 'background: rgba(124, 58, 237, 0.12)' : '' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ ($isLessonsRoute || $isSubjectsRoute) ? '#7C3AED' : '#94a3b8' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold" style="color: {{ ($isLessonsRoute || $isSubjectsRoute) ? '#7c3aed' : '#94a3b8' }}">دروسي</span>
                </a>

                @auth
                    <a href="{{ url('/admin') }}" class="flex flex-col items-center gap-1" style="text-decoration: none">
                        <div
                            class="w-12 h-9 rounded-2xl flex items-center justify-center"
                            style="{{ $isAdminRoute ? 'background: rgba(124, 58, 237, 0.12)' : '' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $isAdminRoute ? '#7C3AED' : '#94a3b8' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M20 21a8 8 0 1 0-16 0" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold" style="color: {{ $isAdminRoute ? '#7c3aed' : '#94a3b8' }}">المشرفة</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center gap-1" style="text-decoration: none">
                        <div
                            class="w-12 h-9 rounded-2xl flex items-center justify-center"
                            style="{{ $isLoginRoute ? 'background: rgba(124, 58, 237, 0.12)' : '' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $isLoginRoute ? '#7C3AED' : '#94a3b8' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M20 21a8 8 0 1 0-16 0" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold" style="color: {{ $isLoginRoute ? '#7c3aed' : '#94a3b8' }}">المشرفة</span>
                    </a>
                @endauth
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                if (window.lucide) {
                    window.lucide.createIcons();
                }

                // Fallback: if MathJax CDN fails to load, still convert digits and start observer
                setTimeout(() => {
                    if (!_mathJaxReady) { applyArabicNumbers(); startDynamicArabicObserver(); }
                }, 2000);

                document.querySelectorAll('[data-lb-tab]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const tab = button.dataset.lbTab;

                        document.querySelectorAll('[data-lb-tab]').forEach((item) => {
                            item.classList.remove('lb-on');
                            item.classList.add('lb-off');
                        });

                        button.classList.remove('lb-off');
                        button.classList.add('lb-on');

                        document.querySelectorAll('[data-lb-panel]').forEach((panel) => {
                            panel.classList.add('hidden');
                        });

                        document.querySelector(`[data-lb-panel="${tab}"]`)?.classList.remove('hidden');
                    });
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
