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
                    <div class="card-header bg-dark text-light rounded-md border-0">
                        <div class="container-fluid d-flex justify-content-between align-items-center p-2">
                            <h4 class="mb-0"><span class="mdi mdi-train"></span> ReportViewer</h4>
                            <p class="text-sm mb-0">Coach Management System</p>
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-end align-items-center p-2">
                        <div class="d-grid d-md-flex button-group gap-3" role="group" aria-label="Navbar buttons">
                            <div class="dropdown">
                                <button class="btn btn-secondary3 py-1"><span class="mdi mdi-filter-variant text-xxl"></span></button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Navbar buttons">
                                <button class="btn btn-secondary3 boder-muted outline-none text-xl px-1 py-0"><span class="mdi mdi-chevron-left"></span></button>
                                <button class="btn btn-secondary3 boder-muted outline-none text-sm px-1 py-0">AUGEST 25</span></button>
                                <button class="btn btn-secondary3 boder-muted outline-none text-xl px-1 py-0"><span class="mdi mdi-chevron-right"></span></button>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary3 text-sm d-flex align-items-center" type="button" id="coachTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                </div>
                <div class="card mb-3 bg-secondary3 border-1 shadow-sm rounded-md mt-1">
                    <div class="card-body p-2">
                        <table id="trainTable" class="table table-hover bg-secondary3" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="bg-secondary3 text-sm text-center">SL</th>
                                    <th class="bg-secondary3 text-sm text-center">TRAIN NO</th>
                                    <th class="bg-secondary3 text-sm text-center">TRAIN NAME</th>
                                    <th class="bg-secondary3 text-sm text-center">DATE</th>
                                    <th class="bg-secondary3 text-sm text-center">OPERATOR</th>
                                    <th class="bg-secondary3 text-sm text-center">SHIFT</th>
                                    <th class="bg-secondary3 text-sm text-center">COACH TYPE</th>
                                    <th class="bg-secondary3 text-sm text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($trains) > 0): ?>
                                    <?php foreach ($trains as $index => $train): ?>
                                        <tr>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo $index + 1; ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo htmlspecialchars($train['train_no']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo htmlspecialchars($train['train_name']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo date('d M, Y', strtotime($train['date_of_testing'])); ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo htmlspecialchars($train['operator_name']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo htmlspecialchars($train['shift']); ?></td>
                                            <td class="bg-secondary3 text-xs text-center"><?php echo htmlspecialchars($train['coach_type']); ?></td>
                                            <td class="bg-secondary3 text-sm text-center">
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
    <script>
        function deleteReport(id) {
            if (confirm('Are you sure you want to delete this report?')) {
                fetch(`delete.php?id=${id}`, {
                        method: 'DELETE',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Refresh the table or remove the row
                            window.location.reload();
                        } else {
                            alert('Error deleting report: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting report');
                    });
            }
        }
    </script>
    <?php include __DIR__ . '/includes/footer.php'; ?>