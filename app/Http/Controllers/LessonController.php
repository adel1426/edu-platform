<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class LessonController extends Controller
{
    public function index(): View
    {
        $lessons = Lesson::query()
            ->with(['subject', 'unit'])
            ->where('is_published', true)
            ->whereHas('subject', fn (Builder $query) => $query->where('is_published', true))
            ->where(function (Builder $query): void {
                $query->whereNull('unit_id')
                    ->orWhereHas('unit', fn (Builder $unitQuery) => $unitQuery->where('is_published', true));
            })
            ->latest()
            ->paginate(12);

        return view('lessons.index', [
            'lessons' => $lessons,
        ]);
    }

    public function show(string $slug): View
    {
        $lesson = Lesson::query()
            ->with(['subject', 'unit'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereHas('subject', fn (Builder $query) => $query->where('is_published', true))
            ->where(function (Builder $query): void {
                $query->whereNull('unit_id')
                    ->orWhereHas('unit', fn (Builder $unitQuery) => $unitQuery->where('is_published', true));
            })
            ->firstOrFail();

        // زيادة عداد المشاهدات بشكل ذري
        $lesson->increment('views_count');

        // تسجيل تقدم الطالبة المسجّلة
        if (auth()->check()) {
            $progress = LessonProgress::firstOrCreate([
                'user_id'   => auth()->id(),
                'lesson_id' => $lesson->id,
            ]);
            if (! $progress->wasRecentlyCreated) {
                $progress->touch();
            }
        }

        $relatedLessons = Lesson::query()
            ->where('subject_id', $lesson->subject_id)
            ->whereKeyNot($lesson->id)
            ->where('is_published', true)
            ->whereHas('subject', fn (Builder $query) => $query->where('is_published', true))
            ->where(function (Builder $query): void {
                $query->whereNull('unit_id')
                    ->orWhereHas('unit', fn (Builder $unitQuery) => $unitQuery->where('is_published', true));
            })
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('lessons.show', [
            'lesson'        => $lesson,
            'publicUrl'     => route('lessons.show', $lesson->slug),
            'relatedLessons' => $relatedLessons,
            'videoEmbedUrl' => $this->getYoutubeEmbedUrl($lesson->video_url),
        ]);
    }

    private function getYoutubeEmbedUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $parts = parse_url($url);
        $host  = $parts['host'] ?? null;
        $path  = $parts['path'] ?? '';

        if ($host === 'youtu.be') {
            $videoId = trim($path, '/');

            return filled($videoId) ? "https://www.youtube.com/embed/{$videoId}" : null;
        }

        if (in_array($host, ['www.youtube.com', 'youtube.com', 'm.youtube.com'], true)) {
            parse_str($parts['query'] ?? '', $query);

            if (! empty($query['v'])) {
                return "https://www.youtube.com/embed/{$query['v']}";
            }

            if (str_starts_with($path, '/embed/')) {
                return $url;
            }
        }

        return null;
    }
}
