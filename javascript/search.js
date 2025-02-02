let currentQuery = "";
let currentFilters = {};
let currentOrderBy = "publicationDate";
let currentOrderDirection = "ASC";

document.getElementById("searchInput").addEventListener("input", function () {
  currentQuery = this.value;
  searchProducts();
});

function searchProducts() {
  const params = new URLSearchParams({
    query: currentQuery,
    orderBy: currentOrderBy,
    orderDirection: currentOrderDirection,
    ...currentFilters,
  });

  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `../actions/action_search_products.php?${params.toString()}`,
    true
  );
  xhr.onload = function () {
    if (xhr.status === 200) {
      const products = JSON.parse(xhr.responseText);
      displayProducts(products);
    }
  };
  xhr.send();
}

function displayProducts(products) {
  const productGrid = document.getElementById("productGrid");
  productGrid.innerHTML = "";

  if (products.length === 0) {
    productGrid.innerHTML =
      '<div class="no-products">Não foram encontrados produtos.</div>';
  } else {
    products.forEach((product) => {
      const productElement = document.createElement("div");
      productElement.classList.add("product");
      productElement.innerHTML = `
        <a href="../pages/productPage.php?product_id=${product.id}">
          <img src="../${product.imagePath}" alt="Imagem de ${product.name}">
        </a>
        <p>${product.name}</p>
        <p>${product.price.toFixed(2)} €</p>
      `;
      productGrid.appendChild(productElement);
    });
  }
}
