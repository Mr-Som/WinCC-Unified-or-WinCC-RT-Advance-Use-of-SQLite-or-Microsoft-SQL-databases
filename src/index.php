<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/url.php';
//require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/header.php';
include __DIR__ . '/config/database.php';
$pdo = Database::getConnection();

// Fetch data from the database
$stmt = $pdo->query("SELECT * FROM train_maintenance_report");
$trains = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
</head>

<body class="bg-secondary2">
    <?php require_once __DIR__ . '/includes/navbar.php'; ?>
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 col-lg-12 px-md-3">
                <div class="card mb-3 bg-secondary3 border-1 shadow-sm rounded-md mt-3">
                    <div class="card-header bg-dark text-light rounded-x-md border">
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <h4 class="mb-0"><span class="mdi mdi-train"></span> ReportViewer</h4>
                            <p class="text-sm mb-0">Coach Management System</p>
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 px-3 py-1 bg-secondary2 rounded-md shadow-sm">
                            <span class="mdi mdi-magnify"></span>
                            <input type="text" class="border-0 bg-secondary2 p-2 focus-ring focus-ring-light text-sm text-muted"
                                id="searchInput" onkeyup="searchTable()"
                                placeholder="Search trains, operators...">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column align-items-start gap-1 me-3">
                                <label class="text-xs text-muted">Date Range</label>
                                <div class="dropdown">
                                    <button class="btn bg-secondary-dropdown text-xs text-muted p-2 rounded-md d-flex align-items-center justify-content-between" style="min-width: 150px;" type="button" id="dateRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="selected-option">Last 7 days</span>
                                        <span class="mdi mdi-chevron-down text-sm ms-2"></span>
                                    </button>
                                    <ul class="dropdown-menu bg-secondary2 rounded-md p-1 border-0 shadow-sm" aria-labelledby="dateRangeDropdown" style="min-width: 150px;">
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'dateRangeDropdown')">
                                                Last 7 days
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'dateRangeDropdown')">
                                                Last 30 days
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'dateRangeDropdown')">
                                                Custom range
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start gap-1 me-3">
                                <label class="text-xs text-muted">Coach Type</label>
                                <div class="dropdown">
                                    <button class="btn bg-secondary-dropdown text-xs text-muted p-2 rounded-md d-flex align-items-center justify-content-between" style="min-width: 150px;" type="button" id="coachFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="selected-option">All Types</span>
                                        <span class="mdi mdi-chevron-down text-sm ms-2"></span>
                                    </button>
                                    <ul class="dropdown-menu bg-secondary2 rounded-md p-1 border-0 shadow-sm" aria-labelledby="coachFilterDropdown" style="min-width: 150px;">
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                All Types
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                AC First Class
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                AC Chair Car
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                AC Two Tier
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                AC Three Tier
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'coachFilterDropdown')">
                                                Sleeper
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start gap-1 ">
                                <label class="text-xs text-muted">Shift</label>
                                <div class="dropdown">
                                    <button class="btn bg-secondary-dropdown text-xs text-muted p-2 rounded-md d-flex align-items-center justify-content-between" style="min-width: 150px;" type="button" id="shiftDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="selected-option">All Shifts</span>
                                        <span class="mdi mdi-chevron-down text-sm ms-2"></span>
                                    </button>
                                    <ul class="dropdown-menu bg-secondary2 rounded-md p-1 border-0 shadow-sm" aria-labelledby="shiftDropdown" style="min-width: 150px;">
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'shiftDropdown')">
                                                All Shifts
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'shiftDropdown')">
                                                Morning
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'shiftDropdown')">
                                                Evening
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-xs d-flex align-items-center px-3 py-2 bg-secondary-dropdown rounded-md" onclick="updateDropdown(this, 'shiftDropdown')">
                                                Night
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 bg-secondary3 border-1 shadow-sm rounded-md mt-1">
                    <div class="card-body p-2">
                        <table id="trainTable" class="table table-hover bg-secondary3" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">SL</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">TRAIN NO</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">TRAIN NAME</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">DATE</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">OPERATOR</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">SHIFT</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom">COACH TYPE</th>
                                    <th class="bg-secondary3 text-sm text-center border-dark border-buttom"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($trains) > 0): ?>
                                    <?php foreach ($trains as $index => $train): ?>
                                        <tr>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo $index + 1; ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo htmlspecialchars($train['train_no']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo htmlspecialchars($train['train_name']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo date('d M, Y', strtotime($train['date_of_testing'])); ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo htmlspecialchars($train['operator_name']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo htmlspecialchars($train['shift']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center border-secondary"><?php echo htmlspecialchars($train['coach_type']); ?></td>
                                            <td class="bg-secondary3 text-sm text-center border-secondary">
                                                <div class="dropdown">
                                                    <button class="btn bg-secondary-dropdown px-2 py-1 text-sm" type="button" id="actionDropdown<?php echo $index; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="mdi mdi-dots-horizontal"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-secondary2 rounded-md p-1 border-0" aria-labelledby="actionDropdown<?php echo $index; ?>" style="min-width: 120px;">
                                                        <li>
                                                            <a href="view.php?id=<?php echo $train['id']; ?>" class="dropdown-item d-flex align-items-center gap-2 bg-secondary-dropdown rounded-md px-3 py-2 text-sm">
                                                                <span class="mdi mdi-eye-outline"></span> View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button onclick="deleteReport(<?php echo $train['id']; ?>)" class="dropdown-item d-flex align-items-center gap-2 bg-secondary-dropdown rounded-md px-3 py-2 text-sm text-destructive">
                                                                <span class="mdi mdi-delete-outline"></span> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                        <td class="bg-secondary3 text-xs text-center">No records found.</td>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                        <td class="bg-secondary3 text-xs text-center"></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- End container-fluid -->
    <?php include __DIR__ . '/includes/footer.php'; ?>