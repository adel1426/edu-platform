<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_lesson_page_can_be_rendered_by_slug(): void
    {
        $subject = Subject::create([
            'name' => 'الرياضيات',
            'slug' => 'mathematics',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'subject_id' => $subject->id,
            'title' => 'الجبر الخطي',
            'slug' => 'linear-algebra',
            'content' => '<p>محتوى الدرس</p>',
            'video_url' => 'https://www.youtube.com/watch?v=abc123xyz99',
            'points_reward' => 15,
            'is_published' => true,
        ]);

        $relatedLesson = Lesson::create([
            'subject_id' => $subject->id,
            'title' => 'المتجهات',
            'slug' => 'vectors',
            'content' => '<p>درس إضافي</p>',
            'is_published' => true,
        ]);

        $response = $this->get(route('lessons.show', $lesson->slug));

        $response
            ->assertOk()
            ->assertSee('الجبر الخطي')
            ->assertSee('الرياضيات')
            ->assertSee('https://www.youtube.com/embed/abc123xyz99', false)
            ->assertSee(route('lessons.show', $lesson->slug))
            ->assertSee($relatedLesson->title);
    }

    public function test_unpublished_lesson_page_returns_not_found(): void
    {
        $subject = Subject::create([
            'name' => 'العلوم',
            'slug' => 'science',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'subject_id' => $subject->id,
            'title' => 'درس مخفي',
            'slug' => 'hidden-lesson',
            'is_published' => false,
        ]);

        $this->get(route('lessons.show', $lesson->slug))
            ->assertNotFound();
    }

    public function test_lesson_page_returns_not_found_when_subject_is_unpublished(): void
    {
        $subject = Subject::create([
            'name' => 'التاريخ',
            'slug' => 'history',
            'is_published' => false,
        ]);

        $lesson = Lesson::create([
            'subject_id' => $subject->id,
            'title' => 'العصور الوسطى',
            'slug' => 'middle-ages',
            'is_published' => true,
        ]);

        $this->get(route('lessons.show', $lesson->slug))
            ->assertNotFound();
    }
}
