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
                'lessons' => fn ($query) => $query
                    ->where('is_published', true)
                    ->where(function (Builder $lessonQuery): void {
                        $lessonQuery->whereNull('unit_id')
                            ->orWhereHas('unit', fn (Builder $unitQuery) => $unitQuery->where('is_published', true));
                    })
                    ->orderByDesc('created_at'),
            ])
            ->firstOrFail();

        return view('subjects.show', [
            'subject' => $subject,
        ]);
    }
}
