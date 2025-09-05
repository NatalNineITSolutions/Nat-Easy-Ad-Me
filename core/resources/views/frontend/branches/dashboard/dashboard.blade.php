<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4A6CF7;
            --secondary-color: #64748B;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
            --dark-color: #1E293B;
            --light-color: #F8FAFC;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #F1F5F9;
            color: var(--dark-color);
        }

        .branch-dashboard {
            min-height: 100vh;
        }

        /* Header Styles */
        .branch-header {
            background: linear-gradient(135deg, var(--primary-color), #2D4FCC);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .branch-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .branch-logo {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .branch-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard{
            margin-top: 10px;
        }

        .branch-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        /* Sidebar Styles */
        .branch-sidebar {
            background: white;
            width: 280px;
            height: calc(100vh - 80px);
            position: fixed;
            left: 0;
            top: 80px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 99;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: #F8FAFC;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        /* Main Content Area */
        .branch-main-content {
            margin-left: 280px;
            padding: 2rem;
            margin-top: 10px;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .stat-content h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .stat-content p {
            color: var(--secondary-color);
            margin: 0;
        }

        .bg-purple {
            background-color: rgba(155, 39, 176, 0.1);
            color: #9b27b0;
        }

        .bg-cyan {
            background-color: rgba(0, 188, 212, 0.1);
            color: #00bcd4;
        }

        .bg-orange {
            background-color: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }

        .bg-green {
            background-color: rgba(0, 166, 90, 0.1);
            color: #00a65a;
        }

        .bg-blue {
            background-color: rgba(0, 115, 183, 0.1);
            color: #0073b7;
        }

        .bg-red {
            background-color: rgba(245, 105, 84, 0.1);
            color: #f56954;
        }

        .bg-amber {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        /* Charts and Activity Section */
        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-container,
        .activity-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        /* Activity Items */
        .activity-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-info {
            background-color: var(--info-color);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .branch-sidebar {
                transform: translateX(-100%);
            }

            .branch-sidebar.open {
                transform: translateX(0);
            }

            .branch-main-content {
                margin-left: 0;
            }

            .dashboard-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .branch-header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .branch-main-content {
                padding: 1rem;
            }
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .menu-toggle {
                display: block;
            }
        }

        /* Revenue specific styles */
        .revenue-card {
            background: linear-gradient(135deg, #4A6CF7, #2D4FCC);
            color: white;
            grid-column: 1 / -1;
        }

        .revenue-card .stat-icon {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .revenue-card h3 {
            color: white;
        }

        .revenue-card p {
            color: rgba(255, 255, 255, 0.8);
        }

        .revenue-trend {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .trend-up {
            color: #10B981;
        }

        .trend-down {
            color: #EF4444;
        }
    </style>
</head>

<body>
    <div class="branch-dashboard">
        <!-- Header -->
        @include('frontend.branches.partials.header')

        <!-- Sidebar -->
        @include('frontend.branches.partials.sidebar')

        <!-- Main Content -->
        <main class="branch-main-content">

            <h1 class="mb-4">Branch Dashboard</h1>

            <div class="dashboard">
                <div class="dashboard-welcome">
                    <h1>Welcome, {{ auth('branch')->user()->name }}!</h1>
                    <p>Here you can manage products, view reports, and handle branch operations.</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="dashboard-cards">
                <!-- Total Revenue Card -->
                <div class="stat-card revenue-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <h3>$42,580</h3>
                        <p>Total Revenue</p>
                        <div class="revenue-trend trend-up">
                            <i class="fas fa-arrow-up"></i>
                            <span>12.5% increase from last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold text-primary">
                        ₹ {{ number_format($dailyCommission ?? 0, 2) }}
                    </h2>        
                    <i class="fa-solid fa-sack-dollar fa-3x text-success"></i>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle sidebar on mobile
            document.getElementById('sidebarToggle').addEventListener('click', function () {
                document.getElementById('branchSidebar').classList.toggle('open');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (e) {
                if (window.innerWidth < 1024) {
                    if (!e.target.closest('#branchSidebar') && !e.target.closest('#sidebarToggle')) {
                        document.getElementById('branchSidebar').classList.remove('open');
                    }
                }
            });

            // Performance chart
            const ctx = document.getElementById('performanceChart').getContext('2d');
            const performanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 30000, 38000, 40000, 42580],
                        borderColor: '#4A6CF7',
                        backgroundColor: 'rgba(74, 108, 247, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>