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
        DB::statement("
        CREATE OR REPLACE VIEW items_view AS
SELECT
    items.id AS item_id,
    items.name AS item_name,
    items.name_ar AS item_name_ar,
    items.description,
    items.description_ar,
    items.price,
    items.image AS item_image,
    items.created_at AS item_created_at,
    items.updated_at AS item_updated_at,
    categories.id AS category_id,
    categories.name AS category_name
FROM
    items
JOIN
    categories ON items.category_id = categories.id;
");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('items_view');
    }
};
