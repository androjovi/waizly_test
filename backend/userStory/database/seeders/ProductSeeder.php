<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motorcycleList = [
            ['name_product' => 'Honda ADV 160', 'price_product' => 39000000, 'image_product' => '7c0267e23c1e4f708a18e0fe7e0820a2_606x402.jpg'],
            ['name_product' => 'Honda Beat', 'price_product' => 17000000, 'image_product' => '62d63cda2ad347858d16ab13f08592f9_606x402.jpg'],
            ['name_product' => 'Honda PCX', 'price_product' => 43000000, 'image_product' => 'fe134044cec94d6d85f70e08fe31967f_606x402.jpg'],
            ['name_product' => 'Yamaha NMAX', 'price_product' => 32000000, 'image_product' => '3a9f6f5981544bb5a656987c7023e948_606x402.jpg'],
            ['name_product' => 'Yamaha YZF R15', 'price_product' => 36000000, 'image_product' => 'eb8c2a4a996441639f6593aafa09b3e9_606x402.jpg'],
            ['name_product' => 'Honda Vario 125', 'price_product' => 21000000, 'image_product' => 'bdda241624004fa09bd27d743ea2ec33_606x402.jpg'],
            ['name_product' => 'Vespa Sprint', 'price_product' => 51000000, 'image_product' => 'a30584a32b424b838701fdb8ec468974_606x402.jpg'],
            ['name_product' => 'Kawasaki KLX 150', 'price_product' => 39000000, 'image_product' => 'd894037ffb9a419f87e12a4127a0ba6f_606x402.jpg'],
            ['name_product' => 'Yamaha XSR 155', 'price_product' => 36000000, 'image_product' => 'c07f7b57336c41479d6ba0ccd29ba4ca_606x402.jpg'],
            ['name_product' => 'Honda CBR100RR', 'price_product' => 100000000, 'image_product' => 'a454c3984dfb44cb8534fb8dd2fbd32f_606x402.jpg'],
            ['name_product' => 'Honda NC750X', 'price_product' => 50000000, 'image_product' => '1d398ddf2cab450c9762d6bb0060d319_606x402.jpg'],
            ['name_product' => 'Honda Revo', 'price_product' => 16000000, 'image_product' => '40158363aaee42b59d835cc399613916_606x402.jpg'],
            ['name_product' => 'Honda Beat Street', 'price_product' => 17000000, 'image_product' => '908328852d184b558a1e53746090f4d8_606x402.jpg'],
            ['name_product' => 'Honda Genio', 'price_product' => 18000000, 'image_product' => 'b87c7d5916ba42509ac2f6788524e0fa_606x402.jpg'],
            ['name_product' => 'Honda Supra X 125', 'price_product' => 18000000, 'image_product' => '539fef023d21471fae33ddf8c400ab42_606x402.jpg'],
            ['name_product' => 'Honda CB150', 'price_product' => 20000000, 'image_product' => 'a3de2121134b4eb9b7499724a51b6889_606x402.jpg'],
            ['name_product' => 'Honda Scoopy', 'price_product' => 21000000, 'image_product' => 'b1e5e939fab446919ee105dd5283918b_606x402.jpg'],
            ['name_product' => 'Honda PCX160', 'price_product' => 21000000, 'image_product' => 'fe134044cec94d6d85f70e08fe31967f_606x402.jpg'],
            ['name_product' => 'Honda CB150X', 'price_product' => 24000000, 'image_product' => '05a7bf619ae44701a87beec3980efc58_606x402.jpg'],
            ['name_product' => 'Yamaha CRF150L', 'price_product' => 12000000, 'image_product' => '92723ac551514edaa530470557f19697_606x402.jpg'],
        ];
        $faker = Faker::create();
        foreach($motorcycleList as $k){
            DB::table('product')->insert([
                'code_product' => $faker->streetName(),
                'name_product' => $k['name_product'],
                'description_product' => $faker->text($maxNbChars = 200),
                'price_product' => $k['price_product'],
                'image_product' => $k['image_product'],
                'flag' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
