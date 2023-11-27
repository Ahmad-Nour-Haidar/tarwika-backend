<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        DB::statement("
CREATE OR REPLACE VIEW order_details AS
SELECT
    o.id AS order_id,
    o.user_id,
    o.persons,
    o.status,
    ca.count,
    -- c.name_ar AS category_name_ar,
    JSON_UNQUOTE(JSON_EXTRACT(i.price, CONCAT('$.', ca.size))) AS item_price,
    ca.count * JSON_UNQUOTE(JSON_EXTRACT(i.price, CONCAT('$.', ca.size))) AS total_price,
    i.name,
    i.name_ar,
    ca.size,
    c.name AS category_name

FROM orders o
         JOIN carts ca ON o.id = ca.order_id
         JOIN items i ON ca.item_id = i.id
         JOIN categories c ON i.category_id = c.id;
        ");
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
