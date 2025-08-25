<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/url.php';
//require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/header.php';
?>
</head>

<body class="bg-secondary2">
    <?php require_once __DIR__ . '/includes/navbar.php'; ?>
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 col-lg-12 px-md-4">
                <card class="card mb-3 bg-secondary3 border-1 shadow-sm rounded-md">
                    <!--<div class="card-header bg-secondary3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">API Keys</h5>
                        <button class="btn btn-sm btn-primary">Create New Key</button>
                    </div>-->
                    <div class="card-body p-2">
                        <table
                            id="apiKeysTable"
                            class="table table-hover bg-secondary3"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="bg-secondary3 text-sm">Key</th>
                                    <th class="bg-secondary3 text-sm">Created By</th>
                                    <th class="bg-secondary3 text-sm">Created At</th>
                                    <th class="bg-secondary3 text-sm">Last Used At</th>
                                    <th class="bg-secondary3 text-sm">Cost</th>
                                    <th class="bg-secondary3 text-sm text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Void sk-ant-api03-Mf7...jQAa</td>
                                    <td class="bg-secondary3 text-xs">Somnath Halder</td>
                                    <td class="bg-secondary3 text-xs">Aug 1, 2025</td>
                                    <td class="bg-secondary3 text-xs">Never</td>
                                    <td class="bg-secondary3 text-xs">-</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key2 sk-xyz-api12-Ab3...kLMn</td>
                                    <td class="bg-secondary3 text-xs">John Doe</td>
                                    <td class="bg-secondary3 text-xs">Aug 15, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 20, 2025</td>
                                    <td class="bg-secondary3 text-xs">$5.00</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key3 sk-pqr-api99-Cd4...oPqR</td>
                                    <td class="bg-secondary3 text-xs">Jane Smith</td>
                                    <td class="bg-secondary3 text-xs">Aug 10, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 18, 2025</td>
                                    <td class="bg-secondary3 text-xs">$3.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key4 sk-abc-api77-Xy9...zABc</td>
                                    <td class="bg-secondary3 text-xs">Bob Johnson</td>
                                    <td class="bg-secondary3 text-xs">Aug 5, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 22, 2025</td>
                                    <td class="bg-secondary3 text-xs">$2.00</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary3 text-xs">Key5 sk-def-api88-Mn5...pQRs</td>
                                    <td class="bg-secondary3 text-xs">Alice Brown</td>
                                    <td class="bg-secondary3 text-xs">Aug 12, 2025</td>
                                    <td class="bg-secondary3 text-xs">Aug 21, 2025</td>
                                    <td class="bg-secondary3 text-xs">$4.50</td>
                                    <td class="bg-secondary3 text-center"><span class="mdi mdi-dots-horizontal"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </card>
            </main>
        </div>
    </div>
    <!-- End container-fluid -->
    <?php include __DIR__ . '/includes/footer.php'; ?>