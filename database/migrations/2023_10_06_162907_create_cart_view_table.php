<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::statement("

        CREATE OR REPLACE VIEW cart_view AS
        WITH cart_data AS (
        SELECT
        carts.id,
        users.id AS user_id,
        items.id AS item_id,
        items.category_id,
        categories.name As category_name,
        items.name,
        items.name_ar,
        items.description,
        items.description_ar,
        items.image,
        items.price,
        carts.size,
        carts.count,
        JSON_UNQUOTE(JSON_EXTRACT(items.price, CONCAT('$.', carts.size))) AS item_price
        FROM
        carts
        INNER JOIN users ON carts.user_id = users.id
        INNER JOIN items ON carts.item_id = items.id
        INNER JOIN categories ON categories.id = items.category_id
        WHERE carts.order_id = 0
        )
    SELECT
    c.id,
    c.user_id,
    c.item_id,
    c.category_id,
    c.category_name,
    c.name,
    c.name_ar,
    c.description,
    c.description_ar,
    size,
    price,
    count,
    item_price,
    (c.item_price * c.count) AS total_price,
    c.image
    -- ,
   -- CASE WHEN f.user_id IS NOT NULL THEN true ELSE false END AS is_favorite
    FROM cart_data AS c
   -- LEFT JOIN favorites AS f ON c.user_id = f.user_id AND c.item_id = f.item_id


        ");

    }

    public function down()
    {
        Schema::dropIfExists('cart_view');
    }
};
