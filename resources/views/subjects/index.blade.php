<x-layouts.public :title="'المواد - ' . config('app.name', 'Edu Platform')">
    <section class="mx-auto max-w-lg px-4 py-8">
        <div class="fade-in mb-8 text-center">
            <h1 class="text-3xl font-black text-slate-800">اختاري موادك</h1>
            <p class="mt-2 text-slate-500">اضغطي على المادة لاستكشاف الوحدات والدروس المنشورة.</p>
        </div>

        @if ($subjects->isEmpty())
            <div class="soft-card rounded-3xl px-6 py-14 text-center text-slate-500">
                لا توجد مواد منشورة حتى الآن.
            </div>
        @else
            <div class="grid gap-4">
                @foreach ($subjects as $index => $subject)
                    <a
                        href="{{ route('subjects.show', $subject->slug) }}"
                        class="subject-card rounded-3xl p-6 fade-in"
                        style="{{ $index % 2 === 0
                            ? 'background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); border: 1px solid rgba(255,255,255,.6); box-shadow: 0 12px 24px -8px rgba(255,154,158,.5);'
                            : 'background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); border: 1px solid rgba(255,255,255,.6); box-shadow: 0 12px 24px -8px rgba(161,196,253,.5);' }}"
                    >
                        <div class="mb-4 flex items-center justify-between gap-4">
                            <div class="text-4xl">{{ $index % 2 === 0 ? '📚' : '🎓' }}</div>
                            <span class="rounded-full bg-white/60 px-3 py-1 text-xs font-bold text-slate-700">{{ $subject->lessons_count }} درس</span>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800">{{ $subject->name }}</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-700">
                            {{ \Illuminate\Support\Str::limit((string) $subject->description, 130) ?: 'افتحي المادة لعرض الدروس المنشورة الخاصة بها.' }}
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.public>
