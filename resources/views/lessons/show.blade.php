<x-layouts.public :title="$lesson->title . ' - ' . config('app.name', 'Edu Platform')" :meta-description="\Illuminate\Support\Str::limit(strip_tags((string) $lesson->content), 160)">
    @push('head')
        <meta property="og:title" content="{{ $lesson->title }}">
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags((string) $lesson->content), 160) }}">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ $publicUrl }}">
    @endpush

    <section class="mx-auto max-w-lg px-4 py-8">
        <div class="fade-in mb-6 flex items-center justify-between gap-4">
            <a href="{{ route('subjects.show', $lesson->subject->slug) }}" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-slate-500 transition hover:bg-violet-50 hover:text-violet-600">
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                <span>رجوع</span>
            </a>

            <button
                type="button"
                class="rounded-xl bg-violet-50 px-4 py-2 text-sm font-bold text-violet-600 transition hover:bg-violet-100"
                onclick="navigator.clipboard.writeText(@js($publicUrl)); this.textContent = 'تم نسخ الرابط'; setTimeout(() => this.textContent = 'نسخ الرابط', 1800)"
            >
                نسخ الرابط
            </button>
        </div>

        <article class="fade-in overflow-hidden rounded-[28px] bg-white shadow-sm ring-1 ring-violet-100">
            <header class="hero-pattern px-6 py-8 text-white">
                <div class="relative z-10">
                    <div class="mb-4 flex flex-wrap gap-2 text-xs">
                        <span class="rounded-full bg-white/20 px-3 py-1 font-bold">{{ $lesson->subject->name }}</span>
                        @if ($lesson->unit)
                            <span class="rounded-full bg-white/20 px-3 py-1 font-bold">{{ $lesson->unit->title }}</span>
                        @endif
                        <span class="rounded-full bg-white/20 px-3 py-1 font-bold">{{ $lesson->points_reward }} نقطة</span>
                    </div>

                    <h1 class="text-3xl font-black leading-tight">{{ $lesson->title }}</h1>
                    <p class="mt-3 text-sm text-white/90">رابط الدرس: <span dir="ltr">{{ $publicUrl }}</span></p>
                </div>
            </header>

            <div class="space-y-8 px-5 py-6">
                @if ($videoEmbedUrl)
                    <section>
                        <h2 class="mb-4 text-xl font-black text-slate-800">فيديو الدرس</h2>
                        <div class="overflow-hidden rounded-2xl border border-violet-100 bg-slate-950">
                            <div class="aspect-video">
                                <iframe
                                    class="h-full w-full"
                                    src="{{ $videoEmbedUrl }}"
                                    title="{{ $lesson->title }}"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    </section>
                @elseif ($lesson->video_url)
                    <section>
                        <h2 class="mb-4 text-xl font-black text-slate-800">رابط الفيديو</h2>
                        <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener noreferrer" class="glow-btn inline-flex items-center gap-2 rounded-2xl px-5 py-3 font-black text-white">
                            <span>فتح الفيديو</span>
                            <i data-lucide="play-circle" class="h-5 w-5"></i>
                        </a>
                    </section>
                @endif

                <section>
                    <h2 class="mb-4 text-xl font-black text-slate-800">شرح الدرس</h2>

                    @if (filled($lesson->content))
                        <div class="prose-public rounded-2xl border border-violet-100 bg-violet-50/40 p-5">
                            {!! $lesson->content !!}
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-violet-200 bg-violet-50/40 px-4 py-6 text-slate-500">
                            لم يتم إضافة شرح لهذا الدرس بعد.
                        </div>
                    @endif
                </section>

                @if ($relatedLessons->isNotEmpty())
                    <section>
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <h2 class="text-xl font-black text-slate-800">دروس ذات صلة</h2>
                            <span class="text-sm text-slate-500">{{ $lesson->subject->name }}</span>
                        </div>

                        <div class="grid gap-4">
                            @foreach ($relatedLessons as $relatedLesson)
                                <a href="{{ route('lessons.show', $relatedLesson->slug) }}" class="unit-card rounded-2xl p-4">
                                    <div class="mb-2 inline-flex rounded-full bg-pink-50 px-3 py-1 text-xs font-bold text-pink-600">
                                        {{ $relatedLesson->points_reward }} نقطة
                                    </div>

                                    <h3 class="text-lg font-black text-slate-800">{{ $relatedLesson->title }}</h3>
                                    <p class="mt-2 text-sm text-slate-500">
                                        {{ \Illuminate\Support\Str::limit(strip_tags((string) $relatedLesson->content), 90) ?: 'افتح الدرس لقراءة التفاصيل.' }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </article>
    </section>
</x-layouts.public>
