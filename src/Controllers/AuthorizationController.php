<?php
namespace ProductImp\Controllers;

class AuthorizationController
{
  /**
   * GenerateAuthKey function generates an authentication URL for the user to obtain a WooCommerce API key.
   *
   * The function creates an endpoint URL, sets up the required parameters for the authentication request, 
   * builds a query string from these parameters, and redirects the user to the authentication URL.
   *
   * @return void
   */
  public function generateAuthKey()
  {
    $ntwcwp_current_url = "https://$_SERVER[HTTP_HOST]";
    
    $params = [
      'app_name' => 'Product Imp',
      'scope' => 'read_write',
      'user_id' => get_current_user_id(),
      'return_url' => $ntwcwp_current_url . '/wp-admin/admin.php?page=productimp_product_import',
      'callback_url' => $ntwcwp_current_url . '/wp-json/productimp/v1/authorization/store'
    ];

    $authentication_url = $ntwcwp_current_url . '/wc-auth/v1/authorize?' . http_build_query($params);

    return $authentication_url;
  }

  /**
   * StoreAuthKey function stores the authentication key details in the WordPress options table.
   *
   * The function retrieves the input data as a JSON object, checks if the required fields exist, 
   * and stores the data as a JSON string in the WordPress options table.
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