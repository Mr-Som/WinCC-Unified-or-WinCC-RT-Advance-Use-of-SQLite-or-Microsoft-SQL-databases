$(document).ready(function () {
  $("#apiKeysTable").DataTable({
    dom: "t<'row'<'d-flex justify-content-start align-items-end col-md-5 mt-2 px-3'i><'d-flex justify-content-end align-items-center col-md-7 mt-2'p>>",
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
    scrollY: "350px",
  });

  let nonFirstChildElements = document.querySelectorAll(
    "#apiKeysTable > :not(:first-child)"
  );
  nonFirstChildElements.forEach(function (element) {
    element.style.borderTop = "inherit";
  });
  let rows = document.querySelectorAll(
    "#apiKeysTable > :not(:last-child) > :last-child > *"
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
