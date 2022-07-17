<?php

class productimp_Controllers_ProductController implements productimp_Controllers_Interfaces_iController
{
    /**
     * NOTE: WILL BE DEPRECATED IN FAVOR OF PAGINATION LOGIC WITHIN FRONTEND
     * List all products that have been imported from Datasource.
     * 
     * @return Array
     */
    public function list(): array
    {
        global $wpdb;

        if (!isset($_GET['productListLimit'])) {
            $productListLimit = 10;
        } else {
            $productListLimit = $_GET['productListLimit'];
        }

        if (isset($_GET['page'])) {
            $pageno = $_GET['page'];
        } else {
            $pageno = 1;
        }

        $offset = ($pageno - 1) * $productListLimit;
        $totalOfProducts = $wpdb->get_var("SELECT COUNT(*) FROM wp_productimp_products");
        $totalOfPages = ceil($totalOfProducts / $productListLimit);

        return [
            "totalPages" => $totalOfPages,
            "products" => $wpdb->get_results("SELECT * FROM wp_productimp_products LIMIT $offset, $productListLimit")
        ];
    }

    public function getAll() {
        global $wpdb;

        return json_encode($wpdb->get_results("SELECT * FROM wp_productimp_products"));
    }
}
