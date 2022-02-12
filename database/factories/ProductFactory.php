<?php
	
	namespace Database\Factories;
	
	use App\Models\User;
	use App\Models\Product;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Str;
	
	class ProductFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 *
		 * @return array
		 */
		public function definition()
		{
			return [
				'name' => $this->faker->word,
				'description' => $this->faker->paragraph(1),
				'quantity' => $this->faker->numberBetween(1, 10),
				'status' => $this->faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
				'image' => $this->faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
				'seller_id' => User::all()->random()->id,
				// User::inRandomOrder()->first()->id
			];
		}
	}
