function applyFilters() {
  const categories = Array.from(
    document.querySelectorAll('input[name="category"]:checked')
  ).map((cb) => cb.value);
  const states = Array.from(
    document.querySelectorAll('input[name="state"]:checked')
  ).map((cb) => cb.value);
  const priceMin = document.getElementById("priceMin").value;
  const priceMax = document.getElementById("priceMax").value;

  currentFilters = {
    categories: categories.join(","),
    states: states.join(","),
    price_min: priceMin,
    price_max: priceMax,
  };

  searchProducts();
}

function clearFilters() {
  document
    .querySelectorAll('input[name="category"]:checked')
    .forEach((cb) => (cb.checked = false));
  document
    .querySelectorAll('input[name="state"]:checked')
    .forEach((cb) => (cb.checked = false));
  document.getElementById("priceMin").value = "";
  document.getElementById("priceMax").value = "";

  currentFilters = {};

  searchProducts();
}

document.addEventListener("click", function (event) {
  const filterButton = document.querySelector(".filter-button");
  const filterOptions = document.querySelector(".filter-options");
  const sortOptions = document.querySelector(".sort-options");

  if (filterButton && filterOptions) {
    if (
      !filterButton.contains(event.target) &&
      !filterOptions.contains(event.target)
    ) {
      filterOptions.classList.remove("show");
    }
  }

  if (sortOptions) {
    const sortButton = document.querySelector(".sort-button");
    if (
      sortButton &&
      !sortButton.contains(event.target) &&
      !sortOptions.contains(event.target)
    ) {
      sortOptions.classList.remove("show");
    }
  }
});

const filterButton = document.querySelector(".filter-button");
const filterOptions = document.querySelector(".filter-options");

if (filterButton && filterOptions) {
  filterButton.addEventListener("click", function (event) {
    event.stopPropagation();
    filterOptions.classList.toggle("show");
    const sortOptions = document.querySelector(".sort-options");
    if (sortOptions) {
      sortOptions.classList.remove("show");
    }
  });

  filterOptions.addEventListener("click", function (event) {
    event.stopPropagation();
  });
}
