<x-layouts.public :title="'الدروس - ' . config('app.name', 'Edu Platform')">
    <section class="mx-auto max-w-lg px-4 py-8">
        <div class="fade-in mb-8 text-center">
            <h1 class="text-3xl font-black text-slate-800">جميع الدروس</h1>
            <p class="mt-2 text-slate-500">تصفحي الدروس المنشورة واخترِي ما يناسبك.</p>
        </div>

        @if ($lessons->isEmpty())
            <div class="soft-card rounded-3xl px-6 py-14 text-center text-slate-500">
                لا توجد دروس منشورة حتى الآن.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($lessons as $index => $lesson)
                    <a href="{{ route('lessons.show', $lesson->slug) }}" class="lesson-card block rounded-2xl p-4 fade-in">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-100 font-black text-violet-600">
                                {{ $lessons->firstItem() + $index }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg font-black text-slate-800">{{ $lesson->title }}</h2>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                    <span class="rounded-full bg-pink-50 px-3 py-1 font-bold text-pink-600">{{ $lesson->subject->name }}</span>
                                    @if ($lesson->unit)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 font-bold text-slate-600">{{ $lesson->unit->title }}</span>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags((string) $lesson->content), 95) ?: 'افتح الدرس لعرض الشرح الكامل.' }}</p>
                            </div>

                            <i data-lucide="arrow-left-circle" class="h-5 w-5 flex-shrink-0 text-violet-400"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-violet-100">
                {{ $lessons->links() }}
            </div>
        @endif
    </section>
</x-layouts.public>
