<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeLeaderboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_users_ranked_by_points_for_each_grade(): void
    {
        User::factory()->create([
            'name' => 'الأعلى أول',
            'grade_level' => 'first',
            'total_points' => 900,
        ]);

        User::factory()->create([
            'name' => 'الثاني أول',
            'grade_level' => 'first',
            'total_points' => 700,
        ]);

        User::factory()->create([
            'name' => 'الأعلى ثاني',
            'grade_level' => 'second',
            'total_points' => 950,
        ]);

        User::factory()->create([
            'name' => 'بدون نقاط',
            'grade_level' => 'second',
            'total_points' => 0,
        ]);

        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee('الأعلى أول')
            ->assertSee('الثاني أول')
            ->assertSee('الأعلى ثاني')
            ->assertDontSee('بدون نقاط');
    }
}
