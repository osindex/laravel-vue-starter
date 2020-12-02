<?php

use Illuminate\Database\Seeder;

class FakerData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addContent();
    }
    /**
     * Add some content
     */
    public function addContent(): void
    {
        // \DB::table('categories')->truncate();
        \DB::table('categories')->delete();
        \DB::statement('ALTER TABLE `categories` AUTO_INCREMENT = 1;');
        factory(\App\Models\Category::class, 4)->create(['parent_id' => null]);
        foreach (range(3, 4) as $p) {
            factory(\App\Models\Category::class, 2)->create(['parent_id' => $p]);
        }
        \DB::table('articles')->delete();
        factory(\App\Models\Article::class, 40)->create();

        \DB::table('users')->truncate();
        \DB::table('depts')->truncate();
        \DB::table('dept_user')->truncate();
        factory(\App\Models\User::class, 15)->create();
        factory(\App\Models\Dept::class, 10)->create();
    }
}
