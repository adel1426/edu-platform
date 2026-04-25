<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class MyResultsController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        $completedLessonIds = $user->lessonProgress()->pluck('lesson_id')->toArray();

        $subjects = Subject::query()
            ->where('is_published', true)
            ->with([
                'units' => fn ($q) => $q
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->with([
                        'lessons' => fn ($q2) => $q2
                            ->where('is_published', true)
                            ->select('id', 'unit_id', 'subject_id', 'title', 'slug', 'points_reward'),
                    ]),
            ])
            ->withCount([
                'lessons' => fn (Builder $q) => $q->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->get()
            ->each(function ($subject) {
                $subject->setAttribute(
                    'lessonsWithoutUnit',
                    $subject->lessons()
                        ->where('is_published', true)
                        ->whereNull('unit_id')
                        ->select('id', 'unit_id', 'subject_id', 'title', 'slug', 'points_reward')
                        ->get()
                );
            });

        $totalLessonsCount = $subjects->sum('lessons_count');
        $completedCount    = count($completedLessonIds);

        $recentProgress = $user->lessonProgress()
            ->with([
                'lesson' => fn ($q) => $q
                    ->select('id', 'title', 'slug', 'subject_id')
                    ->with(['subject:id,name,slug']),
            ])
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get()
            ->filter(fn ($p) => $p->lesson?->subject);

        return view('my-results', compact(
            'user',
            'subjects',
            'completedLessonIds',
            'totalLessonsCount',
            'completedCount',
            'recentProgress'
        ));
    }
}
