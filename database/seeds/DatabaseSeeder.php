<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::query()->create([
            'name' => 'user',
            'email' => 'moerain@qq.com',
            'password' => password_hash('123', PASSWORD_DEFAULT),
        ]);

        for ($i = 1;$i <= 3;$i++) {
            \App\Models\Tag::query()->create([
                'name' => "tag-$i",
            ]);
            App\Models\Post::query()->create([
                'title' => "Post-$i",
                'content' => "#### Post Title \n\n post content",
                'createdAt' => (2021 - $i) . '-01-01',
            ]);
            App\Models\Comment::query()->create([
                'postId' => $i,
                'content' => "##### Comment Title \n\n comment content",
                'userName' => "guest-$i",
                'userEmail' => "guest$i@mail.com",
            ]);
        }

        App\Models\Post::query()->find(1)->tags()->sync([1, 3]);
        App\Models\Post::query()->find(2)->tags()->sync([2]);

    }

}
