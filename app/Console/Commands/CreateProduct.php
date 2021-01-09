<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a product from command line';

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
        $name = $this->ask('Product name ?');
        $description = $this->ask('Product description ?');
        price_:
        $price = $this->ask('Product float ?');
        if(!empty($price) && !is_numeric($price)){
            echo "Please provide a numeric input\n";
            goto price_;
        }
        else if(is_numeric($price))
            $price = (float) $price;
            category_: 
        $category_id = $this->ask('Product category id ?');
        if(!empty($category_id)){
            $cat =  Category::find($category_id);
            echo "Please provide a valid category id\n";
            if(!$cat)
                goto category_;
        }

        $product = new Product([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
        ]);
        $product->save();
        echo "Saved -> ".$product->id;

        return 0;
    }
}
