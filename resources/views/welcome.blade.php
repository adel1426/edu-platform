<x-layouts.public :title="config('app.name', 'رحلتك التفاعلية نحو التميز')">

    {{-- ══════════════════════════════════════════
         HERO
    ══════════════════════════════════════════ --}}
    <section class="px-4 pb-24 pt-14 hero-pattern">
        <div class="mx-auto max-w-lg text-center relative z-10">
            <h1 class="mb-4 text-4xl font-extrabold leading-tight text-white md:text-5xl">
                رحلتك التفاعلية نحو التميز
            </h1>
            <p class="mx-auto mb-8 max-w-md text-lg text-white/80">
                رحلتك التفاعلية نحو التميز في الرياضيات للمرحلة المتوسطة.
                ابدأ الآن وتحدَّ قدراتك!
            </p>

            @guest
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                       class="rounded-full px-8 py-3 font-bold transition-all hover:opacity-90"
                       style="background:white;color:#7c3aed;text-decoration:none">
                        ابدأ مجاناً
                    </a>
                    <a href="{{ route('login') }}"
                       class="rounded-full border-2 border-white px-8 py-3 font-bold text-white transition-all hover:bg-white/20"
                       style="text-decoration:none">
                        تسجيل الدخول
                    </a>
                </div>
            @else
                <a href="{{ route('subjects.index') }}"
                   class="inline-flex items-center gap-2 rounded-full px-8 py-3 font-bold transition-all hover:opacity-90"
                   style="background:white;color:#7c3aed;text-decoration:none">
                    <span>🚀</span>
                    <span>واصلي التعلم</span>
                </a>
            @endguest
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         CARDS  (overlap hero bottom with -mt-10)
    ══════════════════════════════════════════ --}}
    <main class="mx-auto max-w-lg px-4 -mt-10">
        <div class="grid grid-cols-1 gap-6">

            {{-- بطاقة ١: المحتوى التعليمي --}}
            <div class="rounded-3xl bg-white p-8 shadow-xl transition-all hover:shadow-2xl"
                 style="border-bottom: 4px solid #7c3aed">
                <div class="mb-4 text-4xl">📚</div>
                <h2 class="mb-3 text-2xl font-bold text-gray-800">المحتوى التعليمي</h2>
                <p class="mb-6 text-gray-600">
                    استعرضي الوحدات الدراسية الموسَّعة حسب المنهج السعودي الرسمي.
                </p>
                <a href="{{ route('subjects.index') }}"
                   class="inline-block font-bold hover:underline"
                   style="color:#7c3aed;text-decoration:none">
                    انتقلي للدراسة ←
                </a>
            </div>

            {{-- بطاقة ٢: بنك الأسئلة --}}
            <div class="rounded-3xl bg-white p-8 shadow-xl transition-all hover:shadow-2xl"
                 style="border-bottom: 4px solid #ec4899">
                <div class="mb-4 text-4xl">✏️</div>
                <h2 class="mb-3 text-2xl font-bold text-gray-800">بنك الأسئلة</h2>
                <p class="mb-6 text-gray-600">
                    آلاف الأسئلة التفاعلية مع تصحيح فوري لتعزيز مهاراتك الرياضية.
                </p>
                <a href="{{ route('lessons.index') }}"
                   class="inline-block font-bold hover:underline"
                   style="color:#ec4899;text-decoration:none">
                    ابدئي التدريب الآن ←
                </a>
            </div>

            {{-- بطاقة ٣: مستوى الإنجاز --}}
            <div class="rounded-3xl bg-white p-8 shadow-xl transition-all hover:shadow-2xl"
                 style="border-bottom: 4px solid #7c3aed">
                <div class="mb-4 text-4xl">📊</div>
                <h2 class="mb-3 text-2xl font-bold text-gray-800">مستوى الإنجاز</h2>

                @auth
                    @php
                        $progressPct = $totalLessonsCount > 0
                            ? min(100, round(($completedCount / $totalLessonsCount) * 100))
                            : 0;
                    @endphp
                    <p class="mb-4 text-gray-600">
                        لقد أتممتِ
                        <span class="font-bold" style="color:#7c3aed">{{ $completedCount }}</span>
                        درساً بنجاح!
                    </p>
                    <div class="w-full rounded-full bg-gray-200" style="height:10px">
                        <div class="rounded-full transition-all"
                             style="height:10px;width:{{ $progressPct }}%;background:linear-gradient(90deg,#7c3aed,#ec4899)"></div>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">{{ $progressPct }}% من إجمالي الدروس</p>
                @else
                    <p class="mb-6 text-gray-600">
                        سجّلي دخولك لمتابعة تقدّمك والحصول على أوسمة التميز.
                    </p>
                    <a href="{{ route('login') }}"
                       class="font-bold hover:underline"
                       style="color:#7c3aed;text-decoration:none">
                        سجّلي دخولك ←
                    </a>
                @endauth
            </div>
        </div>

        
    </main>

    {{-- Footer --}}
    <footer class="px-4 py-10 text-center">
        <p class="text-xs" style="color:#cbd5e1">جميع الحقوق محفوظة لرحلتك التفاعلية نحو التميز 2026 ©</p>
        <p class="mt-1 text-xs" style="color:#cbd5e1">إعداد: فاطمة الأسمري · مريم الجبري · منى المخلفي</p>
        <p class="mt-0.5 text-xs" style="color:#cbd5e1">إشراف: زينب عسكر الحربي</p>
    </footer>

</x-layouts.public>
