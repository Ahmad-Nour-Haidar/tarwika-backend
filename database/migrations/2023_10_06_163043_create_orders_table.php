<?php

use App\Models\User;
use App\static_data\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('total_price');
            $table->integer('total_count');
            $table->enum('status', OrderStatus::toArray())->default(OrderStatus::waiting);
            $table->tinyInteger('persons');
            $table->char('reservation_date_time', 100);
//            $table->char('time', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
