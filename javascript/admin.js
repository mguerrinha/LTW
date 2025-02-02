function removeCategory(categoryId) {
  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/delete_category.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "category_id=" + categoryId;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      document.getElementById("category-" + categoryId).remove();
      addNotification("success", "Category removed successfully");
    } else {
      addNotification("error", "Failed to remove category");
    }
  };

  request.onerror = function () {
    alert("Failed to connect");
  };

  request.send(data);
}

document.getElementById("add-category-form").onsubmit = function (event) {
  event.preventDefault();
  const categoryName = document.getElementById("category_name").value;

  const request = new XMLHttpRequest();
  request.open("POST", "../CRUD/add_category.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "category_name=" + encodeURIComponent(categoryName);

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      const newCategory = JSON.parse(request.responseText);
      addCategoryToDOM(newCategory);
      document.getElementById("category_name").value = "";
      addNotification("success", "Category added successfully");
    } else {
      addNotification("error", "Failed to add category");
    }
  };

  request.onerror = function () {
    console.error("Failed to connect");
  };

  request.send(data);
};

function addCategoryToDOM(category) {
  const categoryList = document.getElementById("category-list");
  const categoryItem = buildCategory(category.id, category.name);
  categoryList.appendChild(categoryItem);
}

function buildCategory(id, name) {
  const categoryItem = document.createElement("li");
  categoryItem.className = "admin-list-item";
  categoryItem.id = "category-" + id;

  const categoryName = document.createElement("span");
  categoryName.textContent = name;

  const removeButton = document.createElement("button");
  removeButton.className = "admin-button";
  removeButton.textContent = "Remove";
  removeButton.onclick = function () {
    removeCategory(id);
  };

  categoryItem.appendChild(categoryName);
  categoryItem.appendChild(removeButton);

  return categoryItem;
}

function promoteUser(userId) {
  const request = new XMLHttpRequest();
  request.open("POST", "../actions/promote_user.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const data = "user_id=" + userId;

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      addNotification("success", "User promoted to admin successfully");
    } else {
      addNotification("error", "Failed to promote user to admin");
    }
  };

  request.onerror = function () {
    alert("Failed to connect");
  };

  request.send(data);
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
