<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Database\Seeder;

class MemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // サンプルユーザーを取得（存在しない場合は作成）
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // サンプルメモデータを作成
        $memos = [
            [
                'title' => 'PHP',
                'body' => 'PHPは、Hypertext Preprocessorの略です。',
            ],
            [
                'title' => 'HTML',
                'body' => 'HTMLは、Hypertext Markup Languageの略です。',
            ],
            [
                'title' => 'CSS',
                'body' => "CSSは、\nCascading Style Sheets\nの略です。",
            ],
            [
                'title' => '混在',
                'body' => "Test123 てすとアイウエオｱｲｳｴｵ\n漢字！ＡＢＣ ａｂｃ １２３   😊✨",
            ],
        ];

        foreach ($memos as $memo) {
            Memo::create([
                'user_id' => $user->id,
                'title' => $memo['title'],
                'body' => $memo['body'],
            ]);
        }
    }
}
