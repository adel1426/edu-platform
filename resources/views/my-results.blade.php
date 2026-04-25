<x-layouts.public :title="'نتائجي - ' . config('app.name')">
    <section class="mx-auto max-w-lg px-4 py-8">

        {{-- ══════════════════════════════════════════
             الرأس + الإنجاز الكلي
        ══════════════════════════════════════════ --}}
        @php
            $overallPct = $totalLessonsCount > 0
                ? min(100, round(($completedCount / $totalLessonsCount) * 100))
                : 0;
            $gradeLabel = match($user->grade_level) {
                'first'  => 'الأول متوسط',
                'second' => 'الثاني متوسط',
                default  => $user->grade_level ?? '—',
            };
            $motivational = match(true) {
                $overallPct >= 80 => 'رائعة! أنتِ على وشك إتمام المنهج 🏆',
                $overallPct >= 50 => 'أكثر من نصف الطريق، استمري! ⭐',
                $overallPct >= 20 => 'تقدّم ملحوظ، واصلي الإنجاز! 💪',
                default           => 'كل رحلة تبدأ بخطوة، ابدئي الآن! ✨',
            };
        @endphp

        <div class="fade-in mb-6">
            <h1 class="text-3xl text-slate-800 mb-1">📊 نتائجي</h1>
            <p class="text-slate-500 text-sm">مرحباً <span class="font-black" style="color:#7c3aed">{{ $user->name }}</span> — {{ $gradeLabel }}</p>
        </div>

        {{-- بطاقة الإنجاز الكلي --}}
        <div class="fade-in mb-6 rounded-3xl p-6 text-white overflow-hidden relative"
             style="background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%)">
            <div class="absolute inset-0" style="background:radial-gradient(circle at 85% 15%, rgba(255,255,255,0.15) 0%, transparent 50%)"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white/80 text-sm mb-1">الإنجاز الكلي للمنهج</p>
                        <p class="text-5xl font-black">{{ $overallPct }}%</p>
                    </div>
                    <div class="text-left">
                        <p class="text-white/80 text-xs mb-1">الدروس المكتملة</p>
                        <p class="text-3xl font-black">{{ $completedCount }}<span class="text-lg text-white/70">/{{ $totalLessonsCount }}</span></p>
                    </div>
                </div>
                <div class="w-full rounded-full mb-3" style="height:8px;background:rgba(255,255,255,0.25)">
                    <div class="rounded-full h-full" style="width:{{ $overallPct }}%;background:white"></div>
                </div>
                <p class="text-white/90 text-sm">{{ $motivational }}</p>
            </div>
        </div>

        {{-- إحصائيات سريعة --}}
        <div class="fade-in mb-6 grid grid-cols-3 gap-3">
            <div class="soft-card rounded-2xl p-4 text-center">
                <p class="text-2xl font-black" style="color:#7c3aed">{{ $completedCount }}</p>
                <p class="text-xs text-slate-500 mt-1">درس مكتمل</p>
            </div>
            <div class="soft-card rounded-2xl p-4 text-center">
                <p class="text-2xl font-black" style="color:#ec4899">{{ number_format($user->total_points) }}</p>
                <p class="text-xs text-slate-500 mt-1">نقطة مكتسبة</p>
            </div>
            <div class="soft-card rounded-2xl p-4 text-center">
                <p class="text-2xl font-black" style="color:#7c3aed">{{ $subjects->count() }}</p>
                <p class="text-xs text-slate-500 mt-1">مادة دراسية</p>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             آخر النشاطات
        ══════════════════════════════════════════ --}}
        @if ($recentProgress->isNotEmpty())
            <div class="fade-in mb-6">
                <h2 class="text-xl text-slate-800 mb-3">🕐 آخر النشاطات</h2>
                <div class="space-y-3">
                    @foreach ($recentProgress as $progress)
                        <a href="{{ route('lessons.show', $progress->lesson->slug) }}"
                           class="visited-card" style="text-decoration:none">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl"
                                 style="background:rgba(124,58,237,0.08)">
                                <i data-lucide="check-circle" class="h-5 w-5" style="color:#7c3aed"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-black text-slate-800 truncate text-sm">{{ $progress->lesson->title }}</p>
                                <p class="text-xs mt-0.5" style="color:#7c3aed">{{ $progress->lesson->subject->name }}</p>
                            </div>
                            <i data-lucide="arrow-left-circle" class="h-5 w-5 flex-shrink-0 text-violet-300"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════════
             التقدم بالمادة (Subject Breakdown)
        ══════════════════════════════════════════ --}}
        <h2 class="fade-in text-xl text-slate-800 mb-4">📚 التقدم بالمواد</h2>

        @forelse ($subjects as $subject)
            @php
                $subjectLessons = $subject->units->flatMap(fn ($u) => $u->lessons->pluck('id'))
                    ->merge($subject->lessonsWithoutUnit->pluck('id'))
                    ->toArray();
                $subjectCompleted = count(array_intersect($subjectLessons, $completedLessonIds));
                $subjectTotal     = count($subjectLessons);
                $subjectPct       = $subjectTotal > 0 ? round(($subjectCompleted / $subjectTotal) * 100) : 0;
            @endphp

            <div class="unit-card fade-in mb-5 overflow-hidden rounded-3xl">

                {{-- رأس المادة --}}
                <div class="p-5 border-b border-violet-100" style="background:linear-gradient(135deg,rgba(124,58,237,0.05),rgba(236,72,153,0.05))">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <h3 class="text-lg text-slate-800">{{ $subject->name }}</h3>
                        <span class="text-sm font-black" style="color:{{ $subjectPct >= 100 ? '#16a34a' : '#7c3aed' }}">
                            {{ $subjectPct >= 100 ? '✅ مكتملة' : $subjectPct . '%' }}
                        </span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill"
                             style="width:{{ $subjectPct }}%;background:linear-gradient(90deg,#7c3aed,#ec4899)"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">{{ $subjectCompleted }} من {{ $subjectTotal }} درس</p>
                </div>

                {{-- الوحدات --}}
                @foreach ($subject->units as $unit)
                    @php
                        $unitIds       = $unit->lessons->pluck('id')->toArray();
                        $unitCompleted = count(array_intersect($unitIds, $completedLessonIds));
                        $unitTotal     = count($unitIds);
                        $unitPct       = $unitTotal > 0 ? round(($unitCompleted / $unitTotal) * 100) : 0;
                    @endphp
                    <div class="border-b border-violet-50/60 px-5 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="flex h-7 w-7 items-center justify-center rounded-lg text-xs font-black text-white flex-shrink-0"
                                     style="background:{{ $unitPct >= 100 ? '#16a34a' : '#7c3aed' }}">
                                    @if($unitPct >= 100)
                                        ✓
                                    @else
                                        {{ $loop->index + 1 }}
                                    @endif
                                </div>
                                <span class="text-sm font-black text-slate-700">{{ $unit->title }}</span>
                            </div>
                            <span class="text-xs font-black" style="color:#7c3aed">{{ $unitCompleted }}/{{ $unitTotal }}</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill"
                                 style="width:{{ $unitPct }}%;background:{{ $unitPct >= 100 ? '#16a34a' : 'linear-gradient(90deg,#7c3aed,#ec4899)' }}"></div>
                        </div>
                    </div>
                @endforeach

                {{-- دروس بدون وحدة --}}
                @if ($subject->lessonsWithoutUnit->isNotEmpty())
                    @php
                        $freeIds       = $subject->lessonsWithoutUnit->pluck('id')->toArray();
                        $freeCompleted = count(array_intersect($freeIds, $completedLessonIds));
                        $freeTotal     = count($freeIds);
                        $freePct       = $freeTotal > 0 ? round(($freeCompleted / $freeTotal) * 100) : 0;
                    @endphp
                    <div class="px-5 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-black text-slate-600">دروس إضافية</span>
                            <span class="text-xs font-black" style="color:#94a3b8">{{ $freeCompleted }}/{{ $freeTotal }}</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill"
                                 style="width:{{ $freePct }}%;background:{{ $freePct >= 100 ? '#16a34a' : 'linear-gradient(90deg,#94a3b8,#7c3aed)' }}"></div>
                        </div>
                    </div>
                @endif

                {{-- رابط الانتقال للمادة --}}
                <a href="{{ route('subjects.show', $subject->slug) }}"
                   class="flex items-center justify-center gap-2 py-3 text-sm font-black transition-colors hover:bg-violet-50"
                   style="color:#7c3aed;text-decoration:none;border-top:1px solid rgba(124,58,237,0.08)">
                    <span>متابعة التعلم</span>
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                </a>
            </div>
        @empty
            <div class="soft-card rounded-3xl px-6 py-14 text-center text-slate-500">
                لا توجد مواد منشورة حتى الآن.
            </div>
        @endforelse

    </section>
</x-layouts.public>
