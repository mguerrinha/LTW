function toggleDropdown() {
  const sortOptions = document.querySelector(".sort-options");
  if (sortOptions) {
    sortOptions.classList.toggle("show");
  }
}

function hideDropdown() {
  const sortOptions = document.querySelector(".sort-options");
  if (sortOptions) {
    sortOptions.classList.remove("show");
  }
}

function sortProducts(orderBy, orderDirection) {
  hideDropdown();

  currentOrderBy = orderBy;
  currentOrderDirection = orderDirection;

  searchProducts();
}

document.addEventListener("click", function (event) {
  const sortButton = document.querySelector(".sort-button");
  const sortOptions = document.querySelector(".sort-options");

  if (sortButton && sortOptions) {
    if (
      !sortButton.contains(event.target) &&
      !sortOptions.contains(event.target)
    ) {
      hideDropdown();
    }
  }
});
