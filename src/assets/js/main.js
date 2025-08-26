$(document).ready(function () {
  $("#trainTable").DataTable({
    dom: "t<'row'<'d-flex justify-content-start align-items-center col-md-5 mt-1 px-3'i><'d-flex justify-content-end align-items-center col-md-7 mt-1'p>>",
    ordering: false,
    fixedHeader: {
      header: true,
    },
    language: {
      paginate: {
        first: '<span class="mdi mdi-chevron-double-left"></span>',
        last: '<span class="mdi mdi-chevron-double-right"></span>',
        next: '<span class="mdi mdi-chevron-right"></span>',
        previous: '<span class="mdi mdi-chevron-left"></span>',
      },
    },
    pagingType: "full_numbers",
    scrollCollapse: true,
    scrollY: "260px",
  });

  let nonFirstChildElements = document.querySelectorAll(
    "#trainTable > :not(:first-child)"
  );
  nonFirstChildElements.forEach(function (element) {
    element.style.borderTop = "inherit";
  });
  let rows = document.querySelectorAll(
    "#trainTable > :not(:last-child) > :last-child > *"
  );
  rows.forEach(function (row) {
    row.style.borderBottomColor = "inherit";
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const coachOptions = document.querySelectorAll(".coach-type-option");
  const coachRadios = document.querySelectorAll('input[name="coachType"]');

  // Apply initial styles based on checked radio button
  coachRadios.forEach((radio) => {
    if (radio.checked) {
      const option = radio.closest(".coach-type-option");
      if (option) {
        option.classList.remove("bg-secondary-dropdown");
        option.classList.add("bg-dark", "text-white");
      }
    } else {
      const option = radio.closest(".coach-type-option");
      if (option) {
        option.classList.remove("bg-dark", "text-white");
        option.classList.add("bg-secondary-dropdown");
      }
    }
  });

  // Handle radio button change events
  coachRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      coachOptions.forEach((option) => {
        const optionRadio = option.querySelector('input[type="radio"]');
        if (optionRadio === this) {
          option.classList.remove("bg-secondary-dropdown");
          option.classList.add("bg-dark", "text-white");
        } else {
          option.classList.remove("bg-dark", "text-white");
          option.classList.add("bg-secondary-dropdown");
        }
      });
    });
  });
});

function updateDropdown(element, dropdownId) {
  const text = element.textContent.trim();
  const dropdownButton = document.getElementById(dropdownId);
  const selectedSpan = dropdownButton.querySelector(".selected-option");
  selectedSpan.textContent = text;

  // Remove active class from all items
  const dropdown = element.closest(".dropdown");
  const items = dropdown.querySelectorAll(".dropdown-item");
  items.forEach((item) => {
    item.classList.remove("bg-dark", "text-white");
  });

  // Add active class to selected item
  element.classList.add("bg-dark", "text-white");
}

// Initialize dropdowns
document.addEventListener("DOMContentLoaded", function () {
  // Handle hover effects
  document.querySelectorAll(".dropdown-item").forEach((item) => {
    item.addEventListener("mouseenter", function () {
      if (!this.classList.contains("bg-dark")) {
        this.classList.add("bg-secondary3");
      }
    });
    item.addEventListener("mouseleave", function () {
      if (!this.classList.contains("bg-dark")) {
        this.classList.remove("bg-secondary3");
      }
    });
  });
});

function deleteReport(id) {
  if (confirm("Are you sure you want to delete this report?")) {
    fetch(`delete.php?id=${id}`, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Refresh the table or remove the row
          window.location.reload();
        } else {
          alert("Error deleting report: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Error deleting report");
      });
  }
}
