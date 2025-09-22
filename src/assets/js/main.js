$(document).ready(function () {
  // Initialize DataTables
  const table = $("#trainTable").DataTable({
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

  // Fix table borders after DataTables initialization
  const nonFirstChildElements = document.querySelectorAll(
    "#trainTable > :not(:first-child)"
  );
  nonFirstChildElements.forEach(function (element) {
    element.style.borderTop = "inherit";
  });
  const rows = document.querySelectorAll(
    "#trainTable > :not(:last-child) > :last-child > *"
  );
  rows.forEach(function (row) {
    row.style.borderBottomColor = "inherit";
  });

  // Custom search function for DataTables
  $("#searchInput").on("keyup", function () {
    table.search(this.value).draw();
    applyCustomFilters(); // Apply dropdown filters after search
  });

  // Function to update dropdown button text and apply filters
  window.updateDropdown = function (element, dropdownId) {
    const text = element.textContent.trim();
    const dropdownButton = document.getElementById(dropdownId);
    const selectedSpan = dropdownButton.querySelector(".selected-option");
    selectedSpan.textContent = text;

    // Remove active class from all items in the same dropdown
    const dropdown = element.closest(".dropdown");
    const items = dropdown.querySelectorAll(".dropdown-item");
    items.forEach((item) => {
      item.classList.remove("bg-dark", "text-white");
      item.classList.add("bg-secondary-dropdown");
    });

    // Add active class to selected item
    element.classList.add("bg-dark", "text-white");
    element.classList.remove("bg-secondary-dropdown");

    // Apply filters
    applyCustomFilters();
  };

  // Function to apply custom dropdown filters
  function applyCustomFilters() {
    const dateRange = document
      .getElementById("dateRangeDropdown")
      .querySelector(".selected-option")
      .textContent.trim();
    const coachType = document
      .getElementById("coachFilterDropdown")
      .querySelector(".selected-option")
      .textContent.trim();
    const shift = document
      .getElementById("shiftDropdown")
      .querySelector(".selected-option")
      .textContent.trim();
    const today = new Date();

    table.rows().every(function () {
      const row = this.node();
      const data = this.data();
      const dateText = row.cells[3].textContent;
      const coachTypeValue = row.cells[6].textContent.toLowerCase();
      const shiftValue = row.cells[5].textContent.toLowerCase();

      // Date range filter
      let matchesDate = true;
      if (dateRange !== "Custom range") {
        const rowDate = new Date(dateText);
        if (dateRange === "Last 7 days") {
          const sevenDaysAgo = new Date(today);
          sevenDaysAgo.setDate(today.getDate() - 7);
          matchesDate = rowDate >= sevenDaysAgo && rowDate <= today;
        } else if (dateRange === "Last 30 days") {
          const thirtyDaysAgo = new Date(today);
          thirtyDaysAgo.setDate(today.getDate() - 30);
          matchesDate = rowDate >= thirtyDaysAgo && rowDate <= today;
        } else if (dateRange === "Last 60 days") {
          const sixtyDaysAgo = new Date(today);
          sixtyDaysAgo.setDate(today.getDate() - 60);
          matchesDate = rowDate >= sixtyDaysAgo && rowDate <= today;
        } else if (dateRange === "Last 90 days") {
          const ninetyDaysAgo = new Date(today);
          ninetyDaysAgo.setDate(today.getDate() - 90);
          matchesDate = rowDate >= ninetyDaysAgo && rowDate <= today;
        }
      }

      // Coach type filter
      const matchesCoach =
        coachType === "All Types" || coachTypeValue === coachType.toLowerCase();

      // Shift filter
      const matchesShift =
        shift === "All Shifts" || shiftValue === shift.toLowerCase();

      // Show or hide row
      this.node().style.display =
        matchesDate && matchesCoach && matchesShift ? "" : "none";
    });

    // Redraw table to update pagination
    table.draw();
  }

  // Handle dropdown item hover effects
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

  // Apply filters on page load
  applyCustomFilters();
});

// Delete report function
function deleteReport(id) {
  if (confirm("Are you sure you want to delete this report?")) {
    const formData = new FormData();
    formData.append("id", id);

    fetch("/src/scripts/delete.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.reload(); // Refresh the page
        } else {
          alert("Error deleting report: " + (data.message || data.error));
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Error deleting report");
      });
  }
}

// Utility function for alerts
function alertMessage(message) {
  alert(message);
}

// Helper to get cookie value by name
function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2)
    return decodeURIComponent(parts.pop().split(";").shift());
  return "";
}

// Show cookie value in input if exists
document.addEventListener("DOMContentLoaded", function () {
  const title = getCookie("title");
  if (title) {
    document.getElementById("input_title").value = title;
  }
});

// Set cookie on Save button click
document
  .getElementById("saveChangesBtn")
  .addEventListener("click", function () {
    const title = document.getElementById("input_title").value;
    document.cookie = "title=" + encodeURIComponent(title) + "; path=/";
    // Close modal using Bootstrap's modal API
    const editModal = bootstrap.Modal.getOrCreateInstance(
      document.getElementById("editModal")
    );
    editModal.hide();
  });
