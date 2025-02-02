// Function to remove notification with fade effect
function removeNotification() {
  var notification = document.querySelector("#notifications");
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
}

window.onload = function () {
  removeNotification();
};
