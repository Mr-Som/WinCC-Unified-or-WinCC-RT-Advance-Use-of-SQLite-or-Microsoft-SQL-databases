<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar bg-secondary2 navbar-expand-lg sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-start px-4">
        <div class="d-grid gap-1">
            <h4 class="mb-0">RTR REPORT</h4>
            <p class="text-sm text-muted mb-2">Manage & view coach reports </p>
        </div>
        <div class="d-grid d-md-flex button-group gap-3" role="group" aria-label="Navbar buttons">
            <div class="dropdown">
                <button class="btn btn-secondary2 py-1"><span class="mdi mdi-filter-variant text-xxl"></span></button>
            </div>
            <div class="btn-group" role="group" aria-label="Navbar buttons">
                <button class="btn btn-secondary3 boder-muted outline-none text-xl px-1 py-0"><span class="mdi mdi-chevron-left"></span></button>
                <button class="btn btn-secondary3 boder-muted outline-none text-sm px-1 py-0">AUGEST 25</span></button>
                <button class="btn btn-secondary3 boder-muted outline-none text-xl px-1 py-0"><span class="mdi mdi-chevron-right"></span></button>
            </div>
            <div class="dropdown">
                <button class="btn btn-lg btn-dark text-sm d-flex align-items-center" type="button" id="coachTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    COACH TYPE <span class="mdi mdi-chevron-down text-xl ms-1"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end bg-secondary2 rounded-md p-0 border-1" aria-labelledby="coachTypeDropdown" style="min-width: 180px;">
                    <li class="p-2 rounded-md">
                        <label class="dropdown-item d-flex align-items-center justify-content-between m-0 px-3 py-2 bg-secondary-dropdown rounded-md coach-type-option" style="cursor:pointer;">
                            Both
                            <input class="form-check-input coach-radio border-secondary" type="radio"
                                name="coachType" value="both" checked>
                        </label>
                    </li>
                    <li class="px-2 rounded-md">
                        <label class="dropdown-item d-flex align-items-center justify-content-between m-0 px-3 py-2 bg-secondary-dropdown rounded-md coach-type-option" style="cursor:pointer;">
                            LHB
                            <input class="form-check-input coach-radio border-secondary" type="radio"
                                name="coachType" value="lhb">
                        </label>
                    </li>
                    <li class="p-2 rounded-md">
                        <label class="dropdown-item d-flex align-items-center justify-content-between m-0 px-3 py-2 bg-secondary-dropdown rounded-md coach-type-option" style="cursor:pointer;">
                            ICF
                            <input class="form-check-input coach-radio border-secondary" type="radio"
                                name="coachType" value="icf">
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>