<?php
include('../backend/session_check.php');
include('../backend/database.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userRole = $_SESSION['role'] ?? '';

if ($userRole === 'Manager') {
  header('Location: ../index.php');
  exit();
}

function fetchQueryResults($conn, $query)
{
  $result = $conn->query($query);
  $data = [];

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
  }

  return $data;
}

// Fetch all required data using the reusable function
$logs = fetchQueryResults($conn, "SELECT activity_log.*, users.username FROM activity_log JOIN users USING(userID) ORDER BY activity_log.createdAt DESC");
$uniqueUsersByDate = fetchQueryResults($conn, "SELECT DATE(createdAt) as actionDate, COUNT(DISTINCT userID) as userCount FROM activity_log GROUP BY actionDate ORDER BY actionDate DESC");
$mostFrequentActions = fetchQueryResults($conn, "SELECT action, COUNT(*) as actionCount FROM activity_log GROUP BY action ORDER BY actionCount DESC LIMIT 10");
$topBrowsers = fetchQueryResults($conn, "SELECT browserInfo, COUNT(*) as actionCount FROM activity_log GROUP BY browserInfo ORDER BY actionCount DESC LIMIT 10");
$actionsOverTime = fetchQueryResults($conn, "SELECT DATE(createdAt) as actionDate, COUNT(*) as actionCount FROM activity_log GROUP BY actionDate ORDER BY actionDate ASC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.css">
  <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
  <link rel="icon" href="../assets/website icon.png" type="image/png" />
  <title>System Logs</title>
</head>

<body>
  <div class="app">
    <aside class="sidebar" style="z-index: 10;">
      <?php include '../components/sidebar.php' ?>
    </aside>
    <section style="z-index: 0;">
      <div class="container">
        <header>
          <?php include '../components/header.php' ?>
        </header>
        <h1>System Logs</h1>
        <div class="table-container">
          <table id="logsTable" class="display">
            <thead>
              <tr>
                <th>Created At</th>
                <th>Log ID</th>
                <th>Username</th>
                <th>Action</th>
                <th>IP Address</th>
                <th>OS Info</th>
                <th>Browser Info</th>
                <th>Action Details</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log): ?>
                <tr>
                  <td><?php echo htmlspecialchars($log['createdAt']); ?></td>
                  <td><?php echo htmlspecialchars($log['logID']); ?></td>
                  <td><?php echo htmlspecialchars($log['username']); ?></td>
                  <td><?php echo htmlspecialchars($log['action']); ?></td>
                  <td><?php echo htmlspecialchars($log['ipAddress']); ?></td>
                  <td><?php echo htmlspecialchars($log['osInfo']); ?></td>
                  <td><?php echo htmlspecialchars($log['browserInfo']); ?></td>
                  <td><?php echo htmlspecialchars($log['actionDetails']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="charts-container">
          <!-- Unique Users by Date Chart -->
          <div id="uniqueUsersByDateChart" class="chart"></div>

          <!-- Most Frequent Actions Chart -->
          <div id="mostFrequentActionsChart" class="chart"></div>

          <!-- Top Browsers Chart -->
          <div id="topBrowsersChart" class="chart"></div>

          <!-- Actions Over Time Chart -->
          <div id="actionsOverTimeChart" class="chart"></div>
        </div>
      </div>

    </section>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#logsTable').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    const uniqueUsersByDate = <?php echo json_encode($uniqueUsersByDate); ?>;
    const mostFrequentActions = <?php echo json_encode($mostFrequentActions); ?>;
    const topBrowsers = <?php echo json_encode($topBrowsers); ?>;
    const actionsOverTime = <?php echo json_encode($actionsOverTime); ?>;

    // ECharts Chart Setup Function
    function createChart(containerId, options) {
      const chart = echarts.init(document.getElementById(containerId));
      chart.setOption(options);
    }

    // Unique Users by Date
    createChart('uniqueUsersByDateChart', {
      title: {
        text: 'Unique Users by Date',
        left: 'center',
        top: 10
      },
      tooltip: {
        trigger: 'axis',
        formatter: '{b}: {c} users'
      },
      xAxis: {
        type: 'category',
        data: uniqueUsersByDate.map(item => item.actionDate)
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: uniqueUsersByDate.map(item => item.userCount),
        type: 'line',
        smooth: true,
        color: '#5470C6'
      }]
    });

    // Most Frequent Actions
    createChart('mostFrequentActionsChart', {
      title: {
        text: 'Most Frequent Actions',
        left: 'center',
        top: 10
      },
      tooltip: {
        trigger: 'axis',
        formatter: '{b}: {c} actions'
      },
      xAxis: {
        type: 'category',
        data: mostFrequentActions.map(item => item.action),
        axisLabel: {
          formatter: function (value) {
            return value.length > 10 ? value.slice(0, 10) + '...' : value;
          }
        }
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: mostFrequentActions.map(item => item.actionCount),
        type: 'bar',
        color: '#91CC75'
      }]
    });

    // Top Browsers
    createChart('topBrowsersChart', {
      title: {
        text: 'Top Browsers',
        left: 'center',
        top: 10
      },
      tooltip: {
        trigger: 'axis',
        formatter: '{b}: {c} actions'
      },
      xAxis: {
        type: 'category',
        data: topBrowsers.map(item => item.browserInfo),
        axisLabel: {
          formatter: function (value) {
            return value.length > 10 ? value.slice(0, 10) + '...' : value;
          }
        }
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: topBrowsers.map(item => item.actionCount),
        type: 'bar',
        color: '#FAC858'
      }]
    });

    // Actions Over Time
    createChart('actionsOverTimeChart', {
      title: {
        text: 'Actions Over Time',
        left: 'center',
        top: 10
      },
      tooltip: {
        trigger: 'axis',
        formatter: '{b}: {c} actions'
      },
      xAxis: {
        type: 'category',
        data: actionsOverTime.map(item => item.actionDate)
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: actionsOverTime.map(item => item.actionCount),
        type: 'line',
        smooth: true,
        color: '#EE6666'
      }]
    });
  </script>
</body>

</html>