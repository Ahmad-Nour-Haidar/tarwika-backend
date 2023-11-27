<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // relationships
            $table->foreignIdFor(Category::class)
                ->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->char('name', 100);
            $table->char('name_ar', 100)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('description');
            $table->text('description_ar');
            $table->string('price')->nullable();
            $table->char('image')->default('image');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('items');
    }
};
