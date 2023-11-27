<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement(
            'CREATE OR REPLACE VIEW favorite_user AS
        SELECT
           users.id AS user_id,
            items.*
                FROM favorites
         INNER JOIN users ON favorites.user_id = users.id
         INNER JOIN items ON favorites.item_id = items.id'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('favorite_user_view');
    }
};
