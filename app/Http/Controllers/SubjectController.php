<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::query()
            ->where('is_published', true)
            ->withCount([
                'lessons' => fn (Builder $query) => $query->where('is_published', true),
                'units'   => fn (Builder $query) => $query->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('subjects.index', [
            'subjects' => $subjects,
        ]);
    }

    public function show(string $slug): View
    {
        $subject = Subject::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with([
                'units' => fn ($q) => $q
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->with([
                        'lessons' => fn ($q2) => $q2
                            ->where('is_published', true)
                            ->orderBy('created_at'),
                    ]),
            ])
            ->withCount([
                'lessons' => fn (Builder $q) => $q->where('is_published', true),
                'units'   => fn (Builder $q) => $q->where('is_published', true),
            ])
            ->firstOrFail();

        $lessonsWithoutUnit = $subject->lessons()
            ->where('is_published', true)
            ->whereNull('unit_id')
            ->orderBy('created_at')
            ->get();

        $completedLessonIds = auth()->check()
            ? auth()->user()->lessonProgress()->pluck('lesson_id')->toArray()
            : [];

        return view('subjects.show', compact('subject', 'lessonsWithoutUnit', 'completedLessonIds'));
    }
}
