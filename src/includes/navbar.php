<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar bg-secondary3 navbar-expand-lg sticky-top py-1">
    <div class="container-fluid d-flex justify-content-between align-items-center pe-2 ps-3">
        <div class="menu-bar d-flex justify-content-start align-items-center">
            <div class="menu-item">Home</div>
            <div class="menu-item">Reports</div>
            <div class="menu-item">About</div>
            <div class="menu-item">Contact</div>
            <div class="menu-item">Help</div>
            <div class="menu-item">Refresh</div>
        </div>
        <div class="menu-bar d-flex justify-content-start align-items-center">
            <div class="menu-item">?</div>
        </div>
    </div>
</nav>