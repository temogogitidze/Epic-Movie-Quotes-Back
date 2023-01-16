<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->json('name');
			$table->json('genre');
			$table->json('director');
			$table->json('description');
			$table->string('release_date');
			$table->string('budget');
			$table->string('thumbnail');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('movies');
	}
};
