<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS order_invoice_lines');

        DB::statement(<<<'SQL'
            CREATE VIEW order_invoice_lines AS
            SELECT
                orders.id AS order_id,
                CONCAT('FAC-', LPAD(orders.id, 6, '0')) AS invoice_number,
                COALESCE(payments.updated_at, orders.updated_at, orders.created_at) AS invoice_date,
                orders.status AS order_status,
                orders.total_amount AS order_total,
                users.name AS customer_name,
                users.username AS customer_username,
                users.email AS customer_email,
                users.phone AS customer_phone,
                addresses.street AS shipping_street,
                addresses.city AS shipping_city,
                addresses.zip_code AS shipping_zip_code,
                payments.payment_method AS payment_method,
                payments.status AS payment_status,
                order_items.id AS line_id,
                products.title AS product_title,
                COALESCE(sizes.size, 'Unica') AS product_size,
                order_items.quantity AS quantity,
                order_items.price AS unit_price,
                (order_items.quantity * order_items.price) AS line_total
            FROM orders
            INNER JOIN users ON users.id = orders.user_id
            INNER JOIN order_items ON order_items.order_id = orders.id
            INNER JOIN products ON products.id = order_items.product_id
            LEFT JOIN sizes ON sizes.id = order_items.size_id
            LEFT JOIN payments ON payments.order_id = orders.id
            LEFT JOIN addresses ON addresses.id = payments.shipping_address
        SQL);
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS order_invoice_lines');
    }
};
