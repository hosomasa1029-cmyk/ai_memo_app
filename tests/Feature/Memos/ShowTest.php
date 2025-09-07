<?php

namespace Tests\Feature\Memos;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_memo_show_page_displays_correct_memo(): void
    {
        $user = User::factory()->create();
        $memo = Memo::factory()->create([
            'user_id' => $user->id,
            'title' => 'テストメモ',
            'body' => "これはテストメモです。\n改行も含みます。",
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('memos.show', $memo));

        $response->assertOk();
        $response->assertSee('テストメモ');
        $response->assertSee('これはテストメモです。');
        $response->assertSee('改行も含みます。');
        $response->assertSee($memo->created_at->format('Y年m月d日'));
    }

    public function test_unauthorized_user_cannot_view_memo(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $memo = Memo::factory()->create([
            'user_id' => $owner->id,
        ]);

        $response = $this
            ->actingAs($otherUser)
            ->get(route('memos.show', $memo));

        $response->assertForbidden();
    }

    public function test_unauthenticated_user_cannot_view_memo(): void
    {
        $memo = Memo::factory()->create();

        $response = $this->get(route('memos.show', $memo));

        $response->assertRedirect(route('login'));
    }
}
