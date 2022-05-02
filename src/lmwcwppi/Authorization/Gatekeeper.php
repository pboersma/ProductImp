<?php

class productimp_Authorization_Gatekeeper {

  public function generateAuthKey()
  {
    $ntwcwp_current_url = "https://$_SERVER[HTTP_HOST]";

    $endpoint = '/wc-auth/v1/authorize';

    $params = [
      'app_name' => 'NT Woocommerce Product Importer', // Auto Generated name for package.
      'scope' => 'read_write',
      'user_id' => 1, // Current Logged in Userid
      'return_url' => $ntwcwp_current_url,
      'callback_url' => $ntwcwp_current_url . '/wp-json/ntwcwppi/v1/gatekeeper/store' //Callback URL for storing data.
    ];

    $authentication_url = $ntwcwp_current_url . $endpoint . '?' . http_build_query($params);

    exit(wp_redirect($authentication_url));
  }

  /**
   * Function for Saving Authorization data from WooCommerce Rest API.
   * 
   * @return void
   */
  public function storeAuthKey()
  {
    $requiredFields = ['key_id', 'user_id', 'consumer_key', 'consumer_secret', 'key_permissions'];
    $input = json_decode(file_get_contents('php://input'), true);
    $dataToStore = [];

    foreach ($input as $key => $value) {
      if (in_array($key, $requiredFields)) {
        $dataToStore[$key] = $value;
      }
    }

    // Skip storing the credentials to avoid clutter.
    if (empty($dataToStore)) {
      exit;
    }

    add_option("productimp_rest", json_encode($dataToStore));
  }


  public function isAuthorized()
  {
    $wooCommerceAuthorized = get_option("productimp_rest");

    // If no Access token is present, Return Unauthorized error.
    if(!$wooCommerceAuthorized) {
      return [
        'status' => 401,
        'message' => 'Please authorize the plugin with WooCommerce.'
      ];
    }

    return [
      'status' => 200,
      'message' => 'Authorized'
    ];
  }
  
}