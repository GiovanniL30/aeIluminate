<?php
include('./backend/session_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/index.css" />
    <link rel="icon" href="./assets/website icon.png" type="image/png" />
    <title>Dashboard</title>
</head>

<body>
    <div id="video-overlay">
        <video id="intro-video" autoplay muted>
            <source src="assets\aelluminate intro.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
    </div>

    <div id="main-content" class="app">
        <aside class="sidebar">
            <?php include './components/sidebar.php' ?>
        </aside>
        <section>
            <div class="container">
                <header>
                    <?php include './components/header.php' ?>
                </header>
                <!-- Dashboard -->
                <div class="dashboard">
                    <h2>Dashboard</h2>
                    <div class="dashboard-charts">
                        <!-- User Overview -->
                        <div class="user-overview-box">
                            <h4 id="total-users" style="text-align: left;"></h4>
                            <canvas id="userOverviewChart"></canvas>
                        </div>
                        <!-- Posts Chart -->
                        <div class="posts-chart">
                            <h4>Post Activity</h4>
                            <!-- Month Navigation -->
                            <div class="month-navigation-container">
                                <div class="month-navigation">
                                    <img id="prev-month" src="assets/previous" alt="Previous Month" />
                                    <span id="current-month">December</span>
                                    <img id="next-month" src="assets/next" alt="Next Month" />
                                </div>
                            </div>
                            <canvas id="postsChart"></canvas>
                            <!-- Statistics for Today, Yesterday, and Average -->
                            <div class="stats-container">
                                <span id="today-stat">Today: 0</span>
                                <span id="yesterday-stat">Yesterday: 0</span>
                                <span id="average-stat">Average: 0</span>
                            </div>
                        </div>
                        <!-- Graduation Year Doughnut Chart -->
                        <div class="graduation-year-chart">
                            <h4>Graduation Year</h4>
                            <canvas id="graduationYearChart"></canvas>
                            <div class="month-navigation-container">
                                <div class="month-navigation">
                                    <img id="prev-month" src="assets/previous" alt="Previous Month" />
                                    <span id="current-month">December</span>
                                    <img id="next-month" src="assets/next" alt="Next Month" />
                                </div>
                            </div>

                        </div> <!-- END OF GRADUATION YEAR CHART -->
                        <!--Employment Doughnut Chart -->
                        <div class="job-status-chart">
                            <h4>Job Status</h4>
                            <canvas id="jobStatusChart"></canvas>
                        </div>
                    </div>
                </div> <!-- END OF DASHBOARD -->
            </div> <!-- END OF CONTAINER -->
        </section>
    </div>
    <script src="./scripts/index.js" type="module"></script>
    <script src="./scripts/header.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</body>

</html>