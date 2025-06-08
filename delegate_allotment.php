<?php
// session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'TopAdmin') {
    header("Location: login_signup.php");
    exit();
}

$message = '';

// Handle adding new committee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_committee'])) {
    $new_committee = trim($_POST['new_committee']);
    if ($new_committee) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO Committees (committee_name) VALUES (?)");
        $stmt->execute([$new_committee]);
        $message = "Committee added successfully.";
    }
}

// Handle form submission for adding a delegate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_delegate'])) {
    $name = trim($_POST['delegate_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $experience = trim($_POST['experience']);
    $portfolio = trim($_POST['portfolio']);
    $payment = $_POST['payment'] ?? '';
    $allotment_status = isset($_POST['allotment_status']) ? 1 : 0;
    $committee = $_POST['committee'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO DelegateAllotments (delegate_name, email, phone_number, criteria_matched, portfolio_allotted, payment_status, allotment_done, committee, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $experience, $portfolio, $payment, $allotment_status, $committee, $_SESSION['user_id']]);
    $message = "Delegate added successfully.";
}

// Handle individual deletion
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM DelegateAllotments WHERE allotment_id = ?");
    $stmt->execute([$_GET['delete_id']]);
    $message = "Delegate record deleted.";
}

// Handle delete all
if (isset($_POST['delete_all'])) {
    $pdo->query("DELETE FROM DelegateAllotments");
    $message = "All delegate records deleted.";
}

// Fetch all delegates
$delegates = $pdo->query("SELECT * FROM DelegateAllotments ORDER BY allotment_id DESC")->fetchAll();

// Fetch committees for dropdown
$committees = $pdo->query("SELECT * FROM Committees ORDER BY committee_name ASC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delegate Allotment</title>
    <link rel="stylesheet" href="styles.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <h2>Delegate Allotment Management</h2>

    <?php if ($message): ?>
        <p style="color:green;"> <?php echo htmlspecialchars($message); ?> </p>
    <?php endif; ?>

    <!-- Delegate form -->
    <form method="POST">
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

    <!-- Delete all button -->
    <form method="POST" style="margin-top:20px;">
        <button type="submit" name="delete_all" onclick="return confirm('Are you sure you want to delete all records?')">Delete All Records</button>
    </form>

    <!-- Delegates table -->
    <h3>All Delegates</h3>
    <button onclick="printTable()">Print Table (PDF/Word/Excel)</button>
    <table border="1" cellpadding="5" cellspacing="0" id="delegates_table" style="margin-top:10px;">
        <thead>
            <tr>
                <th>Delegate Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Experience</th>
                <th>Portfolio</th>
                <th>Payment</th>
                <th>Allotment</th>
                <th>Committee</th>
                <th>Uploaded At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($delegates as $delegate): ?>
                <tr>
                    <td><?= htmlspecialchars($delegate['allotment_id']) ?></td>
                    <td><?= htmlspecialchars($delegate['delegate_name']) ?></td>
                    <td><?= htmlspecialchars($delegate['email']) ?></td>
                    <td><?= htmlspecialchars($delegate['phone_number']) ?></td>
                    <td><?= htmlspecialchars($delegate['criteria_matched']) ?></td>
                    <td><?= htmlspecialchars($delegate['portfolio_allotted']) ?></td>
                    <td><?= htmlspecialchars($delegate['payment_status']) ?></td>
                    <td><?= $delegate['allotment_done'] ? 'Yes' : 'No' ?></td>
                    <td><?= htmlspecialchars($delegate['committee']) ?></td>
                    <td><?= htmlspecialchars($delegate['created_at']) ?></td>
                    <td><a href="?delete_id=<?= $delegate['allotment_id'] ?>" onclick="return confirm('Delete this delegate?')">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script>
document.getElementById('committee_select').addEventListener('change', function() {
    var addNewDiv = document.getElementById('new_committee_div');
    if (this.value === 'add_new') {
        addNewDiv.style.display = 'block';
    } else {
        addNewDiv.style.display = 'none';
    }
});

function printTable() {
    // Option 1: Print using browser print dialog
    // You can style print with CSS media queries for a better format

    // Simple print:
    const printContents = document.getElementById('delegates_table').outerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = "<html><head><title>Delegates</title></head><body>" + printContents + "</body></html>";
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // reload to restore JS functionality

    // Option 2 (commented): Generate PDF via jsPDF (more complex and needs table formatting)
    /*
    import('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js').then(({ jsPDF }) => {
        const doc = new jsPDF.jsPDF();
        doc.text("Delegate Allotment List", 10, 10);
        doc.autoTable({ html: '#delegates_table' });
        doc.save("delegates.pdf");
    });
    */
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
