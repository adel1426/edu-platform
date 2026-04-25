<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectAndLessonCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_subjects_index_shows_only_published_subjects(): void
    {
        $publishedSubject = Subject::create([
            'name' => 'الرياضيات',
            'slug' => 'math',
            'is_published' => true,
        ]);

        Subject::create([
            'name' => 'مخفية',
            'slug' => 'hidden-subject',
            'is_published' => false,
        ]);

        $response = $this->get(route('subjects.index'));

        $response
            ->assertOk()
            ->assertSee($publishedSubject->name)
            ->assertDontSee('مخفية');
    }

    public function test_subject_page_shows_only_published_lessons_with_published_units(): void
    {
        $subject = Subject::create([
            'name' => 'العلوم',
            'slug' => 'science',
            'is_published' => true,
        ]);

        $publishedUnit = Unit::create([
            'subject_id' => $subject->id,
            'title' => 'الوحدة الأولى',
            'slug' => 'unit-1',
            'is_published' => true,
        ]);

        $hiddenUnit = Unit::create([
            'subject_id' => $subject->id,
            'title' => 'الوحدة المخفية',
            'slug' => 'hidden-unit',
            'is_published' => false,
        ]);

        Lesson::create([
            'subject_id' => $subject->id,
            'unit_id' => $publishedUnit->id,
            'title' => 'درس ظاهر',
            'slug' => 'visible-lesson',
            'is_published' => true,
        ]);

        Lesson::create([
            'subject_id' => $subject->id,
            'unit_id' => $hiddenUnit->id,
            'title' => 'درس وحدة مخفية',
            'slug' => 'hidden-unit-lesson',
            'is_published' => true,
        ]);

        Lesson::create([
            'subject_id' => $subject->id,
            'title' => 'درس غير منشور',
            'slug' => 'hidden-lesson',
            'is_published' => false,
        ]);

        $response = $this->get(route('subjects.show', $subject->slug));

        $response
            ->assertOk()
            ->assertSee('درس ظاهر')
            ->assertDontSee('درس وحدة مخفية')
            ->assertDontSee('درس غير منشور');
    }

    public function test_lessons_index_hides_lessons_from_unpublished_subjects(): void
    {
        $publishedSubject = Subject::create([
            'name' => 'اللغة العربية',
            'slug' => 'arabic',
            'is_published' => true,
        ]);

        $hiddenSubject = Subject::create([
            'name' => 'مادة مخفية',
            'slug' => 'hidden',
            'is_published' => false,
        ]);

        Lesson::create([
            'subject_id' => $publishedSubject->id,
            'title' => 'بلاغة',
            'slug' => 'balagha',
            'is_published' => true,
        ]);

        Lesson::create([
            'subject_id' => $hiddenSubject->id,
            'title' => 'درس غير مرئي',
            'slug' => 'invisible-lesson',
            'is_published' => true,
        ]);

        $response = $this->get(route('lessons.index'));

        $response
            ->assertOk()
            ->assertSee('بلاغة')
            ->assertDontSee('درس غير مرئي');
    }
}
