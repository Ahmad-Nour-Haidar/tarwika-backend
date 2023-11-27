

CREATE OR REPLACE VIEW order_details AS
SELECT
    o.id AS order_id,
    o.user_id,
    o.persons,
    o.status,
    ca.count,
 -- c.name_ar AS category_name_ar,
    ca.item_price AS item_price,
    ca.count * ca.item_price AS total_price,
    i.name,
    i.name_ar,
    ca.size,
    c.name AS category_name

FROM orders o
         JOIN carts ca ON o.id = ca.order_id
         JOIN items i ON ca.item_id = i.id
         JOIN categories c ON i.category_id = c.id;
