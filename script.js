document.addEventListener("DOMContentLoaded", () => {
  const page = document.body.dataset.page;

  // 🔐 Login logic for index.html
  if (page === "index") {
    const form = document.getElementById("loginForm");
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      const role = document.getElementById("role").value;

      if (!email || !password || !role) {
        alert("Please fill in all fields!");
        return;
      }

      localStorage.setItem("email", email);
      localStorage.setItem("role", role);
      window.location.href = "dashboard.html";
    });
  }

  // 🐾 Browse logic for browse.html
  if (page === "browse") {
    fetch("getAnimals.php")
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById("animalList");
        container.innerHTML = "";

        data.forEach(animal => {
          const card = document.createElement("div");
          card.className = "box";
          card.innerHTML = `
            <h3>${getEmoji(animal.species)} ${animal.name} (${animal.species})</h3>
            <p>Breed: ${animal.breed}</p>
            <p>Age: ${animal.age}</p>
            <p>Gender: ${animal.gender}</p>
            <p>Status: ${animal.status}</p>
            ${animal.status === "available"
              ? `<button onclick="adoptAnimal('${animal.name}')">Adopt</button>`
              : `<button disabled>Not Available</button>`}
          `;
          container.appendChild(card);
        });
      })
      .catch(err => {
        console.error("Failed to fetch animals:", err);
      });
  }

  // 🐶 Adopt logic for adopt.html
  if (page === "adopt") {
    const selectedAnimal = localStorage.getItem("selectedAnimal");
    const animalText = document.getElementById("selectedAnimalText");
    animalText.textContent = selectedAnimal
      ? `You are adopting: ${selectedAnimal}`
      : "No animal selected.";

    const form = document.getElementById("adoptForm");
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const name = document.getElementById("adopterName").value.trim();
      const email = document.getElementById("adopterEmail").value.trim();

      if (!name || !email || !selectedAnimal) {
        alert("Please fill in all fields and select an animal.");
        return;
      }

      alert(`Thank you, ${name}! You've adopted ${selectedAnimal}.`);
      localStorage.removeItem("selectedAnimal");
      window.location.href = "dashboard.html";
    });
  }

  // 🙋 Volunteer logic for volunteer.html with backend integration
  if (page === "volunteer") {
    const form = document.getElementById("volunteerForm");

    form.addEventListener("submit", (e) => {
      e.preventDefault();

      const name = document.getElementById("volunteerName").value.trim();
      const email = document.getElementById("volunteerEmail").value.trim();
      const task = document.getElementById("volunteerTask").value;
      const date = document.getElementById("volunteerDate").value;

      if (!name || !email || !task || !date) {
        alert("Please fill in all fields.");
        return;
      }

      fetch("submitDuty.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&task=${encodeURIComponent(task)}&date=${encodeURIComponent(date)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          alert(`Thank you, ${name}! You've signed up for ${task} duty on ${date}.`);
          window.location.href = "dashboard.html";
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error("Submission failed:", err);
        alert("Something went wrong. Please try again.");
      });
    });
  }

  // 💸 Donate logic for donate.html with backend integration
  if (page === "donate") {
    const form = document.getElementById("donateForm");

    form.addEventListener("submit", (e) => {
      e.preventDefault();

      const name = document.getElementById("donorName").value.trim();
      const email = document.getElementById("donorEmail").value.trim();
      const amount = document.getElementById("donationAmount").value;
      const message = document.getElementById("donationMessage").value.trim();

      if (!name || !email || !amount || amount <= 0) {
        alert("Please fill in all required fields with valid values.");
        return;
      }

      fetch("submitDonation.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&amount=${encodeURIComponent(amount)}&message=${encodeURIComponent(message)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          alert(`Thank you, ${name}! Your donation of $${amount} means the world to us.\n\n“Every pawprint matters.”`);
          window.location.href = "dashboard.html";
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error("Submission failed:", err);
        alert("Something went wrong. Please try again.");
      });
    });
  }
});

// 🧠 Helper functions (outside DOMContentLoaded)
function getEmoji(species) {
  const emojis = {
    Dog: "🐶",
    Cat: "🐱",
    Bird: "🐦",
    Fish: "🐠"
  };
  return emojis[species] || "🐾";
}

function adoptAnimal(name) {
  localStorage.setItem("selectedAnimal", name);
  window.location.href = "adopt.html";
}
