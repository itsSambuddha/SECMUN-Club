<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'header.php';
include 'index_sidebar.php';
require_once 'db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_role'] ?? '') !== 'topadmin') {
    header('Location: login_signup.php');
    exit;
}

// Fetch committees for delegate allotment form
$committees = $pdo->query("SELECT * FROM committees ORDER BY committee_name ASC")->fetchAll();

// if ($committees === false) {
//     echo "<p>Error fetching committees from database.</p>";
// } else {
//     echo "<p>Committees fetched: " . count($committees) . "</p>";
// }
// ?>

<div class="container">
<main class="dashboard">
  <h1>Top-Level Admin Dashboard</h1>
  <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</p>

  <div id="dashboardGrid" class="dashboard-grid">
    <div class="dashboard-card" id="daToolCard" style="cursor:pointer;">
      <h3>Delegate Allotment (DA Tool)</h3>
      <p>Upload a spreadsheet and auto-assign delegates based on set criteria</p>
    </div>

    <a href="manage_users.php" class="dashboard-card">
      <h3>User Management</h3>
      <p>View, approve/reject user/admin signups</p>
    </a>

    <a href="messaging.php" class="dashboard-card">
      <h3>Messaging System</h3>
      <p>Internal communications</p>
    </a>

    <a href="meeting_summaries.php" class="dashboard-card">
      <h3>Meeting Summaries</h3>
      <p>Upload and archive official meetings</p>
    </a>

    <a href="budgeting.php" class="dashboard-card">
      <h3>Budgeting</h3>
      <p>Custom budgeting per event with default heads like Food, Proposal to Management</p>
    </a>

    <a href="secretariat_records.php" class="dashboard-card">
      <h3>Secretariat Records</h3>
      <p>Upload/view documents related to office bearers</p>
    </a>

    <a href="account_deletion.php" class="dashboard-card">
      <h3>Account Deletion</h3>
      <p>Delete any user/admin manually</p>
    </a>

    <div class="dashboard-card">
      <h3>Auto Account Expiry</h3>
      <p>Accounts expire one year post-registration automatically (system managed)</p>
    </div>

    <a href="analytics.php" class="dashboard-card">
      <h3>Analytics</h3>
      <p>Optional usage tracking</p>
    </a>
  </div>

  <div id="delegateAllotmentSection" style="display:none;">
    <h2>Delegate Allotment Management</h2>

    <form method="POST" action="delegate_allotment.php">
        <label>Name:</label><br>
        <input type="text" name="delegate_name" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone" required><br>

        <label>Experience (years):</label><br>
        <input type="number" name="experience" min="0" required><br>

        <label>Portfolio Allotted:</label><br>
        <input type="text" name="portfolio" required><br>

        <label>Payment Method:</label><br>
        <input type="radio" name="payment" value="UPI" required> UPI
        <input type="radio" name="payment" value="Cash"> Cash
        <input type="radio" name="payment" value="Bank Transfer"> Bank Transfer<br>

        <label>Allotment Status:</label>
        <input type="checkbox" name="allotment_status"> Allotted<br><br>

        <label>Committee:</label><br>
        <select name="committee" id="committee_select" required>
            <?php foreach ($committees as $committee): ?>
                <option value="<?= htmlspecialchars($committee['committee_name']) ?>"><?= htmlspecialchars($committee['committee_name']) ?></option>
            <?php endforeach; ?>
            <option value="add_new">Add New Committee</option>
        </select><br>

        <div id="new_committee_div" style="display:none; margin-top:10px;">
            <input type="text" name="new_committee" placeholder="Enter new committee name" />
            <button type="submit" name="add_committee">Add Committee</button>
        </div>

        <button type="submit" name="add_delegate" style="margin-top:10px;">Add Delegate</button>
    </form>

    <button id="backToDashboard" style="margin-top:20px;">Back to Dashboard</button>
  </div>
</main>

<script>
document.getElementById('daToolCard').addEventListener('click', function() {
    document.getElementById('dashboardGrid').style.display = 'none';
    document.getElementById('delegateAllotmentSection').style.display = 'block';
});

document.getElementById('backToDashboard').addEventListener('click', function() {
    document.getElementById('delegateAllotmentSection').style.display = 'none';
    document.getElementById('dashboardGrid').style.display = 'grid';
});

document.getElementById('committee_select').addEventListener('change', function() {
    var addNewDiv = document.getElementById('new_committee_div');
    if (this.value === 'add_new') {
        addNewDiv.style.display = 'block';
    } else {
        addNewDiv.style.display = 'none';
    }
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
