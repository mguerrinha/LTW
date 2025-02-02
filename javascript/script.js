/* Scripts about the shoppingList, WishList pages and Comments*/

function addFavProduct(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/add_wishlist.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      addNotification("success", "Product added to the wish list");
    } else if (request.status === 409) {
      addNotification("warning", "This product is already in your wish list!");
    } else {
      addNotification("error", "Failed to add product to wish list!");
    }
  };
  request.onerror = function () {
    addNotification("warning", "Failed to Connect");
  };
  request.send(data);
}

function addProductToCart(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/add_shoppinglist.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      addNotification("success", "Product added to the shopping cart!");
    } else if (request.status === 409) {
      addNotification("warning", "Product already on the shopping cart!");
    } else {
      addNotification("error", "Failed to add the product!");
    }
  };
  request.onerror = function () {
    addNotification("warning", "Failed to Connect");
  };
  request.send(data);
}

function removeFavProduct(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_wishlist.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      console.log(request.responseText);
      document.querySelector(`.wishlist-item[data-id='${id}']`).remove();
    } else {
      console.error("Erro ao remover dos favoritos:", request.statusText);
    }
  };
  request.onerror = function () {
    console.error("Erro de conexão");
  };
  request.send(data);
}

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".remove-from-shopping-list").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      removeProductFromCart(productId);
    });
  });

  function removeProductFromCart(id) {
    const request = new XMLHttpRequest();
    request.open("POST", "../CRUD/delete_shoppinglist.php", true);
    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );

    const data = "id=" + id;

    request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
        console.log(request.responseText);
        document.querySelector(`.shopping-item[data-id='${id}']`).remove();
        updateCheckoutArea();
      } else {
        console.error(
          "Erro ao remover do carrinho de compras:",
          request.statusText
        );
      }
    };
    request.onerror = function () {
      console.error("Erro de conexão");
    };
    request.send(data);
  }

  function updateCheckoutArea() {
    const cartItems = document.querySelectorAll(".shopping-item");
    const cartDetails = document.querySelector(".cart-details");
    const checkoutArea = document.querySelector(".checkout-area");
    const totalPriceElement = document.querySelector("#total");
    const numProductsElement = document.querySelector("#num_products");
    const totalPriceInput = document.querySelector('input[name="total_price"]');
    const numItemsInput = document.querySelector('input[name="num_items"]');
    const productInputs = document.querySelector(".product-inputs");
    let totalPrice = 0;
    let numItems = 0;

    productInputs.innerHTML = "";

    cartItems.forEach((item) => {
      const priceElement = item.querySelector(".item-price");
      const price = parseFloat(priceElement.textContent.replace(" €", ""));
      totalPrice += price;
      numItems++;

      const productId = item.getAttribute("data-id");
      const productName = item.querySelector(".item-name").textContent;
      const productQuantity = 1;
      const productPrice = price.toFixed(2);

      const idInput = document.createElement("input");
      idInput.type = "hidden";
      idInput.name = `products[${numItems - 1}][id]`;
      idInput.value = productId;

      const nameInput = document.createElement("input");
      nameInput.type = "hidden";
      nameInput.name = `products[${numItems - 1}][name]`;
      nameInput.value = productName;

      const quantityInput = document.createElement("input");
      quantityInput.type = "hidden";
      quantityInput.name = `products[${numItems - 1}][quantity]`;
      quantityInput.value = productQuantity;

      const priceInput = document.createElement("input");
      priceInput.type = "hidden";
      priceInput.name = `products[${numItems - 1}][price]`;
      priceInput.value = productPrice;

      productInputs.appendChild(idInput);
      productInputs.appendChild(nameInput);
      productInputs.appendChild(quantityInput);
      productInputs.appendChild(priceInput);
    });

    totalPriceElement.textContent = `${totalPrice.toFixed(2)} €`;
    numProductsElement.textContent = numItems;
    totalPriceInput.value = totalPrice.toFixed(2);
    numItemsInput.value = numItems;

    if (numItems === 0) {
      checkoutArea.style.display = "none";
      cartDetails.innerHTML = `
        <h2>My Shopping Cart</h2>
        <p>Your shopping cart is empty.</p>
      `;
    } else {
      checkoutArea.style.display = "block";
    }
  }
});

function submitComment(id, userName, date) {
  const commentTextarea = document.querySelector(".comment-section textarea");
  const commentary = commentTextarea.value.trim();

  if (commentary !== "") {
    const request = new XMLHttpRequest();
    request.open("POST", "../CRUD/add_comment.php", true);
    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );

    const data = "id=" + id + "&commentary=" + encodeURIComponent(commentary);

    request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
        buildComment(id, userName, commentary, date);
        addNotification("success", "Comment added successfully!");
      } else {
        addNotification("error", "Failed to add comment!");
      }
    };
    request.onerror = function () {
      addNotification("warning", "Failed to connect");
    };
    request.send(data);
  } else {
    addNotification("warning", "The comment box can't be empty");
  }
}

function removeFavProduct(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_wishlist.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      document.querySelector(`.wishlist-item[data-id='${id}']`).remove();
      addNotification("success", "Product removed from whish list");
    } else if (request.status === 404) {
      addNotification("error", "Couldn't find the product in the wishing cart");
    } else {
      addNotification("warning", "Failed to remove product from wish list");
    }
  };
  request.onerror = function () {
    addNotification("warning", "Failed to Connect");
  };
  request.send(data);
}

function removeProductFromCart(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_shoppinglist.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      document.querySelector(`.shopping-item[data-id='${id}']`).remove();
      addNotification("success", "Product removed from the shopping cart");
    } else if (request.status === 404) {
      addNotification(
        "error",
        "Couldn't find this product in the shopping cart!"
      );
    } else {
      addNotification(
        "warning",
        "Failed to remove product from shopping cart!"
      );
    }
  };
  request.onerror = function () {
    addNotification("warning", "Failed to connect");
  };
  request.send(data);
}

function removeComment(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_comment.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      document.querySelector(`.comment[data-id='${id}']`).remove();
      addNotification("success", "Comment removed successfully");
    } else {
      addNotification("error", "Failed to remove the comment");
    }
  };
  request.onerror = function () {
    addNotification("error", "Failed to connect");
  };
  request.send(data);
}

function deleteProduct(id) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_product.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "id=" + id;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      console.log(request.responseText);
      addNotification("success", "The Product was removed successfully");
      window.location.href = "../index.php";
    } else if (request.status === 404) {
      addNotification("error", "Couldn't find the product");
    } else {
      addNotification("error", "Failed to remove the product");
    }
  };
  request.onerror = function () {
    addNotification("error", "Failed to connect");
  };
  request.send(data);
}

function buildComment(id, userName, commentary, dateTime) {
  const comment = document.createElement("div");
  comment.className = "comment";
  comment.setAttribute("data-id", id);

  const meta = document.createElement("div");
  meta.className = "comment-meta";

  const details = document.createElement("div");
  details.className = "details";

  const author = document.createElement("span");
  author.className = "comment-author";
  author.textContent = userName + " |";

  const date = document.createElement("span");
  date.className = "comment-date";
  date.textContent = dateTime;

  details.appendChild(author);
  details.appendChild(date);

  const commentDelete = document.createElement("div");
  commentDelete.className = "comment-delete";

  const button = document.createElement("button");
  button.className = "delete-comment";
  button.addEventListener("click", function () {
    removeComment(id);
  });

  const deleteIcon = document.createElement("i");
  deleteIcon.className = "fas fa-trash-alt";

  button.appendChild(deleteIcon);
  commentDelete.appendChild(button);

  meta.appendChild(details);
  meta.appendChild(commentDelete);

  const commentText = document.createElement("div");
  commentText.className = "comment-content";
  commentText.textContent = commentary;

  comment.appendChild(meta);
  comment.appendChild(commentText);

  toAppend = document.querySelector(".comments-container");
  toAppend.appendChild(comment);
}

function addNotification(type, message) {
  const section = document.createElement("section");
  section.id = "notifications";

  const notification = document.createElement("article");
  notification.className = `notification ${type}`;

  const icon = document.createElement("i");
  icon.className = "fas fa-exclamation-circle";

  const text = document.createTextNode(message);

  notification.appendChild(icon);
  notification.appendChild(text);
  section.appendChild(notification);

  document.body.appendChild(section);

  setTimeout(() => {
    removeNotification();
  }, 1000);
}

function removeNotification() {
  var notifications = document.querySelectorAll("#notifications");
  notifications.forEach((notification) => {
    if (notification) {
      var fade = setInterval(() => {
        if (!notification.style.opacity) {
          notification.style.opacity = 1;
        }

        if (notification.style.opacity > 0) {
          notification.style.opacity -= 0.01;
        } else {
          notification.remove();
          clearInterval(fade);
        }
      }, 40);
    }
  });
}
