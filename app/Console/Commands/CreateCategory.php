<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a category from command line';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Category name ?');
        category_: 
        $category_id = $this->ask('Parent category id ?');
        if(!empty($category_id)){
            $cat =  Category::find($category_id);
            echo "Please provide a valid parent category id\n";
            if(!$cat)
                goto category_;
        }

        $category = new Category([
            'name' => $name,
            'parent_category_id' => $category_id,
        ]);
        $category->save();
        echo "Saved -> ".$category->id;

        return 0;
    }
}
