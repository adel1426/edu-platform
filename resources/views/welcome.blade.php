<x-layouts.public :title="config('app.name', 'منصة رحلتك')">

    {{-- ══════════════════════════════════════════
         1. HERO
    ══════════════════════════════════════════ --}}
    <section class="hero-pattern relative px-4 pt-10 pb-16">
        <div style="position:absolute;top:-10%;left:-5%;width:220px;height:220px;background:rgba(255,255,255,0.12);border-radius:50%;filter:blur(40px);pointer-events:none"></div>
        <div style="position:absolute;bottom:-10%;right:-5%;width:180px;height:180px;background:rgba(236,72,153,0.25);border-radius:50%;filter:blur(40px);pointer-events:none"></div>

        <div class="relative z-10 max-w-lg mx-auto fade-in">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-black text-white mb-2 leading-tight">
                        رحلتُكِ نحو التميز ✨
                    </h1>
                    <p class="text-white/80 text-sm font-medium">
                        تعلّمي بمتعة واجمعي النقاط
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center text-3xl"
                     style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3)">
                    👩🏻‍🎓
                </div>
            </div>

            <a href="{{ route('subjects.index') }}"
               class="hero-cta w-full text-white font-bold rounded-3xl flex items-center justify-center gap-3 py-4">
                <i class="rocket-icon">🚀</i>
                <span>ابدئي التعلم</span>
            </a>

            <a href="{{ route('lessons.index') }}" class="secondary-cta w-full justify-center">
                <span>تصفح جميع الدروس</span>
                <i data-lucide="arrow-left" style="width:16px;height:16px"></i>
            </a>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         2. LEADERBOARD  (items 6 · 7 · 15)
    ══════════════════════════════════════════ --}}
    <section class="px-4 py-8" style="background:#fffbf7">
        <div class="max-w-lg mx-auto">

            <div class="flex items-center justify-between mb-1">
                <h2 class="text-xl font-black flex items-center gap-2" style="color:#2d2640">
                    لوحة الشرف <span>🏆</span>
                </h2>
                <span class="text-xs font-semibold px-2 py-1 rounded-full"
                      style="background:rgba(124,58,237,0.08);color:#7c3aed">
                    أعلى 5 طالبات
                </span>
            </div>
            <p class="text-sm mb-5" style="color:#94a3b8">الترتيب بحسب مجموع النقاط المكتسبة</p>

            {{-- Tabs --}}
            <div class="flex gap-2 justify-center mb-5">
                <button type="button" data-lb-tab="first"
                        class="lb-on px-4 py-2.5 rounded-2xl font-bold text-sm transition-all">
                    📘 الأول متوسط
                </button>
                <button type="button" data-lb-tab="second"
                        class="lb-off px-4 py-2.5 rounded-2xl font-bold text-sm transition-all">
                    📗 الثاني متوسط
                </button>
            </div>

            {{-- First grade --}}
            @php $maxFirst = $leaderboard['first']->max('total_points') ?: 1; @endphp
            <div class="space-y-3" data-lb-panel="first">
                @forelse($leaderboard['first'] as $student)
                    @php
                        $i          = $loop->index;
                        $pct        = round(($student->total_points / $maxFirst) * 100);
                        $rankClass  = $i === 0 ? 'lb-rank-1' : ($i === 1 ? 'lb-rank-2' : ($i === 2 ? 'lb-rank-3' : ''));
                        $avatarBg   = match($i) {
                            0       => 'linear-gradient(135deg,#f6d365,#fda085)',
                            1       => 'linear-gradient(135deg,#dde1e7,#94a3b8)',
                            2       => 'linear-gradient(135deg,#f9c784,#c97b2e)',
                            default => 'linear-gradient(135deg,#7c3aed,#ec4899)',
                        };
                        $progressBg = match($i) {
                            0       => 'linear-gradient(90deg,#f6d365,#fda085)',
                            1       => 'linear-gradient(90deg,#cbd5e1,#94a3b8)',
                            2       => 'linear-gradient(90deg,#f9c784,#c97b2e)',
                            default => 'linear-gradient(90deg,#7c3aed,#ec4899)',
                        };
                        $medal      = ['👑','🥈','🥉'][$i] ?? '⭐';
                    @endphp
                    <div class="lb-card {{ $rankClass }}">
                        <div class="lb-avatar" style="background:{{ $avatarBg }}">
                            {{ mb_substr($student->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                <span class="text-base font-black text-slate-800 truncate">{{ $student->name }}</span>
                                @if($i === 0)
                                    <span class="active-badge">⚡ الأكثر نشاطاً</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="progress-track flex-1">
                                    <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $progressBg }}"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-400 whitespace-nowrap">
                                    {{ number_format($student->total_points) }} نقطة
                                </span>
                            </div>
                        </div>
                        <span class="text-xl flex-shrink-0">{{ $medal }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm" style="color:#94a3b8">لا توجد نتائج بعد</div>
                @endforelse
            </div>

            {{-- Second grade --}}
            @php $maxSecond = $leaderboard['second']->max('total_points') ?: 1; @endphp
            <div class="space-y-3 hidden" data-lb-panel="second">
                @forelse($leaderboard['second'] as $student)
                    @php
                        $i          = $loop->index;
                        $pct        = round(($student->total_points / $maxSecond) * 100);
                        $rankClass  = $i === 0 ? 'lb-rank-1' : ($i === 1 ? 'lb-rank-2' : ($i === 2 ? 'lb-rank-3' : ''));
                        $avatarBg   = match($i) {
                            0       => 'linear-gradient(135deg,#f6d365,#fda085)',
                            1       => 'linear-gradient(135deg,#dde1e7,#94a3b8)',
                            2       => 'linear-gradient(135deg,#f9c784,#c97b2e)',
                            default => 'linear-gradient(135deg,#7c3aed,#ec4899)',
                        };
                        $progressBg = match($i) {
                            0       => 'linear-gradient(90deg,#f6d365,#fda085)',
                            1       => 'linear-gradient(90deg,#cbd5e1,#94a3b8)',
                            2       => 'linear-gradient(90deg,#f9c784,#c97b2e)',
                            default => 'linear-gradient(90deg,#7c3aed,#ec4899)',
                        };
                        $medal      = ['👑','🥈','🥉'][$i] ?? '⭐';
                    @endphp
                    <div class="lb-card {{ $rankClass }}">
                        <div class="lb-avatar" style="background:{{ $avatarBg }}">
                            {{ mb_substr($student->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                <span class="text-base font-black text-slate-800 truncate">{{ $student->name }}</span>
                                @if($i === 0)
                                    <span class="active-badge">⚡ الأكثر نشاطاً</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="progress-track flex-1">
                                    <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $progressBg }}"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-400 whitespace-nowrap">
                                    {{ number_format($student->total_points) }} نقطة
                                </span>
                            </div>
                        </div>
                        <span class="text-xl flex-shrink-0">{{ $medal }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-sm" style="color:#94a3b8">لا توجد نتائج بعد</div>
                @endforelse
            </div>

            {{-- item 7: نقاط الطالبة المسجّلة --}}
            @auth
                <div class="user-pts-card">
                    <div>
                        <div class="text-xs mb-0.5" style="color:#94a3b8">نقاطك الحالية</div>
                        <div class="font-black" style="color:#7c3aed">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="text-xl font-black"
                         style="background:linear-gradient(135deg,#7c3aed,#ec4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
                        {{ number_format(auth()->user()->total_points) }} 🏆
                    </div>
                </div>
            @endauth
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         3. أكملي من حيث توقفتِ  (item 13)
    ══════════════════════════════════════════ --}}
    @auth
        @if($lastLesson)
            <section class="px-4 pb-2">
                <div class="max-w-lg mx-auto">
                    <h2 class="text-xl font-black mb-3" style="color:#2d2640">📖 أكملي من حيث توقفتِ</h2>
                    <a href="{{ route('lessons.show', $lastLesson->slug) }}" class="continue-card">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0"
                             style="background:rgba(124,58,237,0.08)">
                            📖
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs mb-0.5" style="color:#94a3b8">واصلي من حيث توقفتِ</div>
                            <div class="font-black text-slate-800 truncate">{{ $lastLesson->title }}</div>
                            <div class="text-xs font-bold mt-0.5" style="color:#7c3aed">
                                {{ $lastLesson->subject->name }}
                            </div>
                        </div>
                        <i data-lucide="arrow-left" class="flex-shrink-0" style="width:20px;height:20px;color:#a78bfa"></i>
                    </a>
                </div>
            </section>
        @endif
    @endauth

    {{-- ══════════════════════════════════════════
         4. وصول سريع  (item 8)
    ══════════════════════════════════════════ --}}
    <section class="px-4 py-8">
        <div class="max-w-lg mx-auto">
            <h2 class="text-xl font-black mb-1" style="color:#2d2640">وصول سريع 🚀</h2>
            <p class="text-sm mb-5" style="color:#94a3b8">اختاري وجهتك مباشرة</p>

            <div class="grid grid-cols-3 gap-3">
                <a href="{{ route('subjects.index') }}" class="quick-card">
                    <span class="text-3xl">📚</span>
                    <span class="text-xs font-black text-slate-700">المواد</span>
                    <span class="text-[10px]" style="color:#94a3b8">الدراسية</span>
                </a>

                <a href="{{ route('lessons.index') }}" class="quick-card">
                    <span class="text-3xl">📖</span>
                    <span class="text-xs font-black text-slate-700">الدروس</span>
                    <span class="text-[10px]" style="color:#94a3b8">كل الدروس</span>
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ url('/admin') }}" class="quick-card">
                            <span class="text-3xl">⚙️</span>
                            <span class="text-xs font-black text-slate-700">المشرفة</span>
                            <span class="text-[10px]" style="color:#94a3b8">لوحة التحكم</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="quick-card">
                            <span class="text-3xl">👤</span>
                            <span class="text-xs font-black text-slate-700">حسابي</span>
                            <span class="text-[10px]" style="color:#94a3b8">ملفي الشخصي</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="quick-card">
                        <span class="text-3xl">🔐</span>
                        <span class="text-xs font-black text-slate-700">دخول</span>
                        <span class="text-[10px]" style="color:#94a3b8">سجّلي دخولك</span>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         5. المواد المتاحة  (item 9)
    ══════════════════════════════════════════ --}}
    @if($featuredSubjects->isNotEmpty())
        <section class="px-4 pb-8">
            <div class="max-w-lg mx-auto">
                <h2 class="text-xl font-black mb-1" style="color:#2d2640">المواد المتاحة 📐</h2>
                <p class="text-sm mb-5" style="color:#94a3b8">اختاري مادتك وابدئي التعلم</p>

                <div class="grid grid-cols-2 gap-4">
                    @foreach($featuredSubjects as $subject)
                        @php $color = $subject->color ?? '#7c3aed'; @endphp
                        <a href="{{ route('subjects.show', $subject->slug) }}"
                           class="feat-sub-card"
                           style="background:{{ $color }}18;border-color:{{ $color }}35">
                            <div class="text-lg font-black mb-1 truncate" style="color:{{ $color }}">
                                {{ $subject->name }}
                            </div>
                            <div class="text-xs font-bold mb-5" style="color:#94a3b8">
                                {{ $subject->lessons_count }} درس متاح
                            </div>
                            <div class="inline-flex items-center gap-1 text-xs font-black" style="color:{{ $color }}">
                                <span>ادخلي</span>
                                <i data-lucide="arrow-left" style="width:12px;height:12px"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════
         6. الأكثر مشاهدة  (item 14)
    ══════════════════════════════════════════ --}}
    @if($topLessons->isNotEmpty())
        <section class="px-4 pb-8">
            <div class="max-w-lg mx-auto">
                <h2 class="text-xl font-black mb-1" style="color:#2d2640">🔥 الأكثر مشاهدة</h2>
                <p class="text-sm mb-5" style="color:#94a3b8">الدروس الأكثر متابعة</p>

                <div class="space-y-3">
                    @foreach($topLessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson->slug) }}" class="visited-card">
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-bold mb-0.5" style="color:#7c3aed">
                                    {{ $lesson->subject->name }}
                                </div>
                                <div class="font-black text-slate-800 truncate">{{ $lesson->title }}</div>
                            </div>
                            <div class="views-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                {{ number_format($lesson->views_count) }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════
         7. CTA ختامي  (item 12)
    ══════════════════════════════════════════ --}}
    <section class="px-4 pb-8">
        <div class="max-w-lg mx-auto rounded-[32px] overflow-hidden px-6 py-12 text-center"
             style="background:linear-gradient(135deg,#7c3aed 0%,#9333ea 50%,#ec4899 100%)">
            <p class="text-white/70 text-sm mb-2">لا تأجلي ما يمكن إنجازه اليوم</p>
            <h2 class="text-2xl font-black text-white mb-2">ابدئي رحلتك نحو التميز</h2>
            <p class="text-white/80 text-sm mb-8">كل درس تتعلمينه يقربك خطوة من هدفك ✨</p>
            <a href="{{ route('subjects.index') }}"
               class="inline-flex items-center gap-3 font-black rounded-3xl px-8 py-4 text-base"
               style="background:white;color:#7c3aed;box-shadow:0 6px 24px rgba(0,0,0,0.15);text-decoration:none">
                <i class="rocket-icon">🚀</i>
                <span>ابدئي الآن</span>
            </a>
        </div>
    </section>

    {{-- Footer credits --}}
    <footer class="px-4 pb-6 text-center">
        <p class="text-xs" style="color:#cbd5e1">إعداد: فاطمة الأسمري · مريم الجبري · منى المخلفي</p>
        <p class="text-xs mt-0.5" style="color:#cbd5e1">إشراف: زينب عسكر الحربي</p>
    </footer>

</x-layouts.public>
