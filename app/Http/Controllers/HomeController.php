<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredSubjects = Subject::query()
            ->where('is_published', true)
            ->withCount(['lessons' => fn (Builder $q) => $q->where('is_published', true)])
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $topLessons = Lesson::query()
            ->with('subject')
            ->where('is_published', true)
            ->where('views_count', '>', 0)
            ->whereHas('subject', fn (Builder $q) => $q->where('is_published', true))
            ->orderByDesc('views_count')
            ->limit(4)
            ->get();

        $lastLesson = null;
        if (auth()->check()) {
            $lastProgress = LessonProgress::where('user_id', auth()->id())
                ->with([
                    'lesson' => fn ($q) => $q->where('is_published', true)
                        ->with(['subject' => fn ($sq) => $sq->where('is_published', true)]),
                ])
                ->orderByDesc('updated_at')
                ->first();

            if ($lastProgress?->lesson?->subject) {
                $lastLesson = $lastProgress->lesson;
            }
        }

        return view('welcome', [
            'leaderboard' => [
                'first'  => $this->getLeaderboardFor('first'),
                'second' => $this->getLeaderboardFor('second'),
            ],
            'featuredSubjects' => $featuredSubjects,
            'topLessons'       => $topLessons,
            'lastLesson'       => $lastLesson,
        ]);
    }

    private function getLeaderboardFor(string $gradeLevel)
    {
        return User::query()
            ->where('grade_level', $gradeLevel)
            ->where('total_points', '>', 0)
            ->orderByDesc('total_points')
            ->orderBy('name')
            ->limit(5)
            ->get(['name', 'username', 'total_points']);
    }
}
