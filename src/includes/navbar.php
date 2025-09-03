<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar bg-secondary3 navbar-expand-lg sticky-top py-1">
    <div class="container-fluid d-flex justify-content-between align-items-center pe-2 ps-3">
        <div class="menu-bar d-flex justify-content-start align-items-center">
            <div class="menu-item" onclick="window.location.href='index.php'">
                <span class="mdi mdi-home-outline"></span> Home
            </div>
            <div class="menu-item" onclick="window.location.href='annexure.php'">
                <span class="mdi mdi-file-document-outline"></span> Reports
            </div>
            <div class="menu-item" data-bs-toggle="modal" data-bs-target="#aboutModal">
                <span class="mdi mdi-information-outline"></span> About
            </div>
            <div class="menu-item" data-bs-toggle="modal" data-bs-target="#helpModal">
                <span class="mdi mdi-help-circle-outline"></span> Help
            </div>
            <div class="menu-item" onclick="window.location.reload()">
                <span class="mdi mdi-refresh"></span> Refresh
            </div>
        </div>
        <div class="menu-bar d-flex justify-content-start align-items-center">
            <div class="menu-item">
                <span class="mdi mdi-help"></span>
            </div>
        </div>
    </div>
</nav>