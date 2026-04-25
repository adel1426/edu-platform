<x-layouts.public :title="$subject->name . ' - ' . config('app.name', 'Edu Platform')">
    <section class="mx-auto max-w-lg px-4 py-8">
        <div class="fade-in mb-8">
            <div class="mb-3 flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('subjects.index') }}" class="transition hover:text-violet-600">المواد</a>
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                <span>{{ $subject->name }}</span>
            </div>

            <h1 class="text-3xl font-black text-slate-800">{{ $subject->name }}</h1>
            <p class="mt-3 leading-7 text-slate-600">
                {{ $subject->description ?: 'عرض جميع الدروس المنشورة المرتبطة بهذه المادة.' }}
            </p>
        </div>

        @if ($subject->lessons->isEmpty())
            <div class="soft-card rounded-3xl px-6 py-14 text-center text-slate-500">
                لا توجد دروس منشورة في هذه المادة حتى الآن.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($subject->lessons as $index => $lesson)
                    <a href="{{ route('lessons.show', $lesson->slug) }}" class="lesson-card block rounded-2xl p-4 fade-in">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-100 font-black text-violet-600">
                                {{ $index + 1 }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg font-black text-slate-800">{{ $lesson->title }}</h2>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                    @if ($lesson->unit)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 font-bold text-slate-600">{{ $lesson->unit->title }}</span>
                                    @endif
                                    <span class="rounded-full bg-violet-50 px-3 py-1 font-bold text-violet-600">{{ $lesson->points_reward }} نقطة</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags((string) $lesson->content), 95) ?: 'افتح الدرس لعرض الشرح الكامل.' }}</p>
                            </div>

                            <i data-lucide="arrow-left-circle" class="h-5 w-5 flex-shrink-0 text-violet-400"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.public>
