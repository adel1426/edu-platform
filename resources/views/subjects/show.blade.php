<x-layouts.public :title="$subject->name . ' - ' . config('app.name', 'Edu Platform')">
    <section class="mx-auto max-w-lg px-4 py-8">

        {{-- Breadcrumb + Title --}}
        <div class="fade-in mb-6">
            <div class="mb-3 flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('subjects.index') }}" class="transition hover:text-violet-600">المواد</a>
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                <span class="font-bold text-slate-700">{{ $subject->name }}</span>
            </div>
            <h1 class="text-3xl font-black text-slate-800">{{ $subject->name }}</h1>
            @if ($subject->description)
                <p class="mt-3 leading-7 text-slate-600">{{ $subject->description }}</p>
            @endif
        </div>

        {{-- Stats bar --}}
        <div class="fade-in mb-6 soft-card rounded-2xl px-5 py-4">
            <div class="flex items-center gap-6 text-sm">
                @if ($subject->units_count > 0)
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100">
                            <i data-lucide="layers" class="h-4 w-4 text-violet-600"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800">{{ $subject->units_count }}</p>
                            <p class="text-xs text-slate-500">وحدة</p>
                        </div>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-pink-100">
                        <i data-lucide="book-open" class="h-4 w-4 text-pink-600"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800">{{ $subject->lessons_count }}</p>
                        <p class="text-xs text-slate-500">درس</p>
                    </div>
                </div>
                @auth
                    @php
                        $allLessonIds = $subject->units->flatMap(fn ($u) => $u->lessons->pluck('id'))
                            ->merge($lessonsWithoutUnit->pluck('id'))
                            ->toArray();
                        $totalDone = count(array_intersect($allLessonIds, $completedLessonIds));
                        $totalAll  = count($allLessonIds);
                        $overallPct = $totalAll > 0 ? round(($totalDone / $totalAll) * 100) : 0;
                    @endphp
                    <div class="flex flex-1 items-center gap-3">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100">
                            <i data-lucide="trending-up" class="h-4 w-4 text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-500">إنجازك الكلي</p>
                                <p class="text-xs font-black text-green-600">{{ $overallPct }}%</p>
                            </div>
                            <div class="progress-track mt-1">
                                <div class="progress-fill bg-gradient-to-r from-green-400 to-emerald-500" style="width: {{ $overallPct }}%"></div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Units with lessons --}}
        @foreach ($subject->units as $unitIndex => $unit)
            @php
                $unitLessonIds  = $unit->lessons->pluck('id')->toArray();
                $completedCount = count(array_intersect($unitLessonIds, $completedLessonIds));
                $totalCount     = count($unitLessonIds);
                $progress       = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
            @endphp

            <div class="unit-card fade-in mb-5 overflow-hidden rounded-3xl">
                {{-- Unit header --}}
                <div class="border-b border-violet-100 bg-gradient-to-l from-violet-50 to-pink-50 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-600 font-black text-white text-sm">
                                {{ $unitIndex + 1 }}
                            </div>
                            <div>
                                <h2 class="font-black text-slate-800">{{ $unit->title }}</h2>
                                <p class="text-xs text-slate-500">{{ $totalCount }} درس</p>
                            </div>
                        </div>
                        @auth
                            <span class="text-sm font-black text-violet-600">{{ $progress }}%</span>
                        @endauth
                    </div>

                    @auth
                        <div class="mt-3">
                            <div class="progress-track">
                                <div class="progress-fill bg-gradient-to-r from-violet-500 to-pink-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    @endauth
                </div>

                {{-- Lessons list --}}
                @if ($unit->lessons->isNotEmpty())
                    <div class="divide-y divide-violet-50/60">
                        @foreach ($unit->lessons as $lessonIndex => $lesson)
                            @php $done = in_array($lesson->id, $completedLessonIds); @endphp
                            <a href="{{ route('lessons.show', $lesson->slug) }}" class="lesson-card flex items-center gap-4 p-4">
                                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl font-black text-sm
                                    {{ $done ? 'bg-green-100 text-green-600' : 'bg-violet-100 text-violet-600' }}">
                                    @if ($done)
                                        <i data-lucide="check" class="h-4 w-4"></i>
                                    @else
                                        {{ $lessonIndex + 1 }}
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-black text-slate-800 leading-snug">{{ $lesson->title }}</h3>
                                    <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                        <span class="rounded-full bg-violet-50 px-3 py-1 font-bold text-violet-600">
                                            {{ $lesson->points_reward }} نقطة
                                        </span>
                                        @if ($done)
                                            <span class="rounded-full bg-green-50 px-3 py-1 font-bold text-green-600">مكتمل</span>
                                        @endif
                                    </div>
                                </div>
                                <i data-lucide="arrow-left-circle" class="h-5 w-5 flex-shrink-0 text-violet-400"></i>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="p-4 text-center text-sm text-slate-400">لا توجد دروس في هذه الوحدة بعد.</p>
                @endif
            </div>
        @endforeach

        {{-- Lessons without a unit --}}
        @if ($lessonsWithoutUnit->isNotEmpty())
            <div class="unit-card fade-in mb-5 overflow-hidden rounded-3xl">
                <div class="border-b border-slate-100 bg-gradient-to-l from-slate-50 to-slate-100 p-4">
                    <h2 class="font-black text-slate-700">دروس إضافية</h2>
                    <p class="text-xs text-slate-500 mt-1">{{ $lessonsWithoutUnit->count() }} درس</p>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach ($lessonsWithoutUnit as $index => $lesson)
                        @php $done = in_array($lesson->id, $completedLessonIds); @endphp
                        <a href="{{ route('lessons.show', $lesson->slug) }}" class="lesson-card flex items-center gap-4 p-4">
                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl font-black text-sm
                                {{ $done ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-600' }}">
                                @if ($done)
                                    <i data-lucide="check" class="h-4 w-4"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-black text-slate-800 leading-snug">{{ $lesson->title }}</h3>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                    <span class="rounded-full bg-violet-50 px-3 py-1 font-bold text-violet-600">
                                        {{ $lesson->points_reward }} نقطة
                                    </span>
                                    @if ($done)
                                        <span class="rounded-full bg-green-50 px-3 py-1 font-bold text-green-600">مكتمل</span>
                                    @endif
                                </div>
                            </div>
                            <i data-lucide="arrow-left-circle" class="h-5 w-5 flex-shrink-0 text-violet-400"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Empty state --}}
        @if ($subject->units->isEmpty() && $lessonsWithoutUnit->isEmpty())
            <div class="soft-card rounded-3xl px-6 py-14 text-center text-slate-500">
                لا توجد دروس منشورة في هذه المادة حتى الآن.
            </div>
        @endif

    </section>
</x-layouts.public>
