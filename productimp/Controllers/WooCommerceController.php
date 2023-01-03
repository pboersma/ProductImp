<?php
use Automattic\WooCommerce\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;


class productimp_Controllers_WooCommerceController
{
    public function createProduct(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        // if(!$request['product_id']) {
        //     return new WP_Error(
        //         'missing_product',
        //         'Make sure to send in a product id for syncing to WooCommerce',
        //         [
        //             'status' => 400
        //         ]
        //     );
        // }

        $wooCommerceAuthorized = json_decode(get_option('productimp_rest'), true);

        // If the client has not authorized with the Woocommerce API, Return.
        if(!$wooCommerceAuthorized) {
            return new WP_Error(
                'unauthorized',
                'No authorization found for WooCommerce, Please Authorize first.',
                [
                    'status' => 400
                ]
            );
        }

        // Create Woocommerce Client for the rest api calls.
        $woocommerce = new Client(
            'https://boersma.dev/',
            $wooCommerceAuthorized['consumer_key'],
            $wooCommerceAuthorized['consumer_secret'],
            [
              'version' => 'wc/v3',
            ]
        );

        // Make sure the client actually is instantiated
        if(!$woocommerce) {
            return new WP_Error(
                'unauthorized',
                'No authorization found for WooCommerce, Please Authorize first.',
                [
                    'status' => 400
                ]
            );
        }


        $client = new GuzzleClient();
        $productMapping = json_decode($client->request(
            'POST',
            'https://boersma.dev/wp-json/productimp/v1/products/map/get',
            [
                'json' => [
                    'product_id' => 13
                ]
            ]
        )->getBody()->getContents(), true)[0];

        $product =  json_decode($client->request(
            'GET',
            'https://boersma.dev/wp-json/productimp/v1/products/read',
            [
                'json' => [
                    'id' => 13
                ]
            ]
        )->getBody()->getContents(), true)['data'];

        $data = $this->interpretMapping(json_decode($productMapping['map'], true), json_decode($product['product'], true));

        return new WP_REST_Response(
            [
                $woocommerce->post('products', $data)
                // $data
            ], 
            200
        );
    }

    private function checkExists($url)
    {
        $image_type_check = @exif_imagetype($url);//Get image type + check if exists
        if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
            return false;
        } else {
            return true;
        }
    }

    private function interpretMapping($mapping, $product)
    {
        $data = [];

        foreach($mapping as $key => &$value) {
            $data[$value['woocommerce_field_id']] = $product[$value['product_field_id']] ?? null;

            if((bool) preg_match('/\./', $value['product_field_id'])) {
                $selectors = explode(".", $value['product_field_id']);

                if($value['woocommerce_field_id'] === 'images') {
                    foreach($product[$selectors[0]][$selectors[1]] as $key => $image) {
                        if($this->checkExists($image)) {
                            $data['images'][$key]['src'] = $image;
                        }
                    }
                }
            }
        }

        return $data;
    }
}
