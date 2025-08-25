document.addEventListener("DOMContentLoaded", () => {
  const page = document.body.getAttribute("data-page");

  if (page === "index") {
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      const role = document.getElementById("role").value;

      if (!email || !password || !role) {
        alert("Please fill in all fields.");
        return;
      }

      localStorage.setItem("userEmail", email);
      localStorage.setItem("userRole", role);

      window.location.assign("dashboard.html");
    });
  }
});
