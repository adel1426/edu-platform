<x-layouts.public :title="config('app.name', 'رحلتك التفاعلية نحو التميز')">

    {{-- ══════════════════════════════════════════
         HERO
    ══════════════════════════════════════════ --}}
    <section class="px-4 pb-28 pt-14 hero-pattern">
        <div class="mx-auto max-w-lg text-center relative z-10">
            <h1 class="mb-3 text-4xl leading-tight text-white md:text-5xl">
                رحلتك التفاعلية نحو التميز
            </h1>
            <p class="mx-auto mb-8 max-w-md text-base text-white/80">
                تعلّمي الرياضيات بمتعة، تابعي تقدّمك، واجمعي النقاط في كل خطوة.
            </p>

            @guest
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('register') }}"
                       class="rounded-full px-8 py-3 font-black transition-all hover:opacity-90"
                       style="background:white;color:#7c3aed;text-decoration:none">
                        ابدأ مجاناً 🚀
                    </a>
                    <a href="{{ route('login') }}"
                       class="rounded-full border-2 border-white px-8 py-3 font-black text-white transition-all hover:bg-white/20"
                       style="text-decoration:none">
                        تسجيل الدخول
                    </a>
                </div>
            @else
                <a href="{{ route('subjects.index') }}"
                   class="inline-flex items-center gap-2 rounded-full px-8 py-3 font-black transition-all hover:opacity-90"
                   style="background:white;color:#7c3aed;text-decoration:none">
                    <span>🚀</span><span>واصلي التعلم</span>
                </a>
            @endguest
        </div>
    </section>

    <main class="mx-auto max-w-lg px-4 -mt-16 relative z-10">

        {{-- ══════════════════════════════════════════
             بطاقة الترحيب الشخصية (للمسجّلين فقط)
        ══════════════════════════════════════════ --}}
        @auth
            @php
                $progressPct = $totalLessonsCount > 0
                    ? min(100, round(($completedCount / $totalLessonsCount) * 100))
                    : 0;
                $firstName = mb_strstr(auth()->user()->name, ' ', true) ?: auth()->user()->name;
                $gradeLabel = match(auth()->user()->grade_level) {
                    'first'  => 'الأول متوسط',
                    'second' => 'الثاني متوسط',
                    default  => auth()->user()->grade_level,
                };
                $motivational = match(true) {
                    $progressPct >= 80 => 'رائعة! أنتِ على وشك إتمام المنهج 🏆',
                    $progressPct >= 50 => 'أكثر من نصف الطريق، استمري! ⭐',
                    $progressPct >= 20 => 'تقدّم ملحوظ، واصلي الإنجاز! 💪',
                    default            => 'كل رحلة تبدأ بخطوة، ابدئي الآن! ✨',
                };
            @endphp

            <div class="mb-5 fade-in rounded-3xl bg-white p-6 shadow-xl"
                 style="border: 1.5px solid rgba(124,58,237,0.15)">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <p class="text-lg" style="color:#2d2640">
                            أهلاً <span style="color:#7c3aed">{{ $firstName }}</span>! 👋
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $gradeLabel }}</p>
                    </div>
                    <div class="text-left">
                        <p class="text-2xl" style="color:#7c3aed">{{ $progressPct }}%</p>
                        <p class="text-xs text-slate-400">إنجازك</p>
                    </div>
                </div>

                <div class="progress-track mb-3">
                    <div class="progress-fill"
                         style="width:{{ $progressPct }}%;background:linear-gradient(90deg,#7c3aed,#ec4899)"></div>
                </div>

                <p class="text-xs text-slate-500">{{ $motivational }}</p>
                <p class="text-xs text-slate-400 mt-1">
                    أتممتِ {{ $completedCount }} من {{ $totalLessonsCount }} درس
                </p>
            </div>
        @endauth

        {{-- ══════════════════════════════════════════
             التنقل السريع (Quick Navigation)
        ══════════════════════════════════════════ --}}
        <div class="mb-6 fade-in">
            <h2 class="mb-4 text-lg text-slate-700">وصول سريع</h2>
            <div class="grid grid-cols-3 gap-3">

                <a href="{{ route('subjects.index') }}" class="quick-card" style="text-decoration:none">
                    <span class="text-3xl">📚</span>
                    <span class="text-xs font-black text-slate-700">تصفح المنهج</span>
                    <span class="text-[10px] text-slate-400">الوحدات والدروس</span>
                </a>

                <a href="{{ route('lessons.index') }}" class="quick-card" style="text-decoration:none">
                    <span class="text-3xl">✏️</span>
                    <span class="text-xs font-black text-slate-700">اختبر نفسك</span>
                    <span class="text-[10px] text-slate-400">بنك الأسئلة</span>
                </a>

                @auth
                    <a href="{{ route('my-results') }}" class="quick-card" style="text-decoration:none">
                        <span class="text-3xl">📊</span>
                        <span class="text-xs font-black text-slate-700">نتائجي</span>
                        <span class="text-[10px] text-slate-400">تقدّمي التفصيلي</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="quick-card" style="text-decoration:none">
                        <span class="text-3xl">🔐</span>
                        <span class="text-xs font-black text-slate-700">دخول</span>
                        <span class="text-[10px] text-slate-400">سجّلي دخولك</span>
                    </a>
                @endauth
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             بطاقات المعلومات
        ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-5 fade-in">

            <div class="rounded-3xl bg-white p-6 shadow-lg transition-all hover:shadow-xl"
                 style="border-bottom: 4px solid #7c3aed">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl text-2xl"
                         style="background:rgba(124,58,237,0.08)">📖</div>
                    <h2 class="text-xl text-gray-800">المحتوى التعليمي</h2>
                </div>
                <p class="mb-4 text-sm text-gray-600">
                    وحدات دراسية مرتّبة حسب المنهج السعودي الرسمي، مع شرح مفصّل لكل درس.
                </p>
                <a href="{{ route('subjects.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-black hover:underline"
                   style="color:#7c3aed;text-decoration:none">
                    انتقلي للدراسة
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-lg transition-all hover:shadow-xl"
                 style="border-bottom: 4px solid #ec4899">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl text-2xl"
                         style="background:rgba(236,72,153,0.08)">🔢</div>
                    <h2 class="text-xl text-gray-800">رموز رياضية احترافية</h2>
                </div>
                <p class="mb-4 text-sm text-gray-600">
                    كسور وجذور وأسس بصيغة واضحة. مثال:
                    <span class="font-black" style="color:#ec4899">\( \frac{2}{5} + \sqrt{9} = x^2 \)</span>
                </p>
                <a href="{{ route('lessons.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-black hover:underline"
                   style="color:#ec4899;text-decoration:none">
                    تصفح الدروس
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                </a>
            </div>

            @guest
                <div class="rounded-3xl bg-white p-6 shadow-lg transition-all hover:shadow-xl"
                     style="border-bottom: 4px solid #7c3aed">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl text-2xl"
                             style="background:rgba(124,58,237,0.08)">🏆</div>
                        <h2 class="text-xl text-gray-800">نظام النقاط والإنجاز</h2>
                    </div>
                    <p class="mb-4 text-sm text-gray-600">
                        اكسبي نقاطاً مع كل درس، وتنافسي على لوحة الشرف مع زميلاتك.
                    </p>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-1 text-sm font-black hover:underline"
                       style="color:#7c3aed;text-decoration:none">
                        سجّلي الآن مجاناً
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    </a>
                </div>
            @endguest
        </div>
    </main>

    {{-- Footer --}}
    <footer class="px-4 py-10 text-center">
        <p class="text-xs" style="color:#cbd5e1">جميع الحقوق محفوظة لرحلتك التفاعلية نحو التميز 2026 ©</p>
        <p class="mt-1 text-xs" style="color:#cbd5e1">إعداد: فاطمة الأسمري · مريم الجبري · منى المخلفي</p>
        <p class="mt-0.5 text-xs" style="color:#cbd5e1">إشراف: زينب عسكر الحربي</p>
    </footer>

</x-layouts.public>
