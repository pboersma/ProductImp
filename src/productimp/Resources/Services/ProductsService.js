import axios from 'axios'

export function getAllProducts() {
    let productList = [];
    axios
    .get("/wp-json/ntwcwppi/v1/products/list", {
      params: {
        productListLimit: self.productListLimit,
        page: self.currentPage,
      },
    })
    .then(function (response) {
      productList = response.data.products;
      // self.totalPages = response.data.totalPages;

      // // Empty Product List before Insertion.
      // self.products = [];

      // response.data.products.map(function (value, key) {
      //   let productData = JSON.parse(value.data);
      //   // Set Data Source ID in Data of Product.
      //   productData["data_source_id"] = value.data_source_id;

      //   self.products.push(productData);
      // });

      // Re-enable actions after call is done.
      // self.disableActions = false;
    })
    .catch(function (error) {
      console.log(error);
    });

    return productList;
}