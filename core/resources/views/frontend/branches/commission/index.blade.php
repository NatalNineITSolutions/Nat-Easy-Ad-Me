<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Branch Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <x-branch.css />

</head>
<body>
    <div class="branch-dashboard">
        <!-- Header -->
        @include('frontend.branches.partials.header')

        <!-- Sidebar -->
        @include('frontend.branches.partials.sidebar')

       <main class="branch-main-content">

            <!-- Total Commission Box -->
            <div class="mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Total Commission</h5>
                            <h2 class="fw-bold text-primary">₹ 12,450.00</h2>
                        </div>
                        <i class="fa-solid fa-coins fa-3x text-warning"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Commission History</h4>
                <form class="d-flex gap-2">
                    <select class="form-select">
                        <option>Daily Commission</option>
                        <option>Monthly Commission</option>
                        <option>All</option>
                    </select>
                </form>
            </div>

            <!-- Commission Table -->
            <div class="table-container">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>02 Sep 2025</td>
                            <td>#ORD1234</td>
                            <td>Product A</td>
                            <td>₹ 2,500.00</td>
                            <td class="text-success fw-bold">₹ 250.00</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>01 Sep 2025</td>
                            <td>#ORD1229</td>
                            <td>Product B</td>
                            <td>₹ 3,200.00</td>
                            <td class="text-success fw-bold">₹ 320.00</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>31 Aug 2025</td>
                            <td>#ORD1225</td>
                            <td>Product C</td>
                            <td>₹ 1,800.00</td>
                            <td class="text-success fw-bold">₹ 180.00</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>


    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<x-branch.js />
</body>
</html>
