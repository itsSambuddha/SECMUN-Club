<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SECMUN Club - Login/Signup</title>
  <link rel="stylesheet" href="style.css" />
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<?php
include 'header.php';
require_once 'db_connect.php';
require_once 'functions.php';

$message = '';
$mode = $_GET['mode'] ?? 'login';
$role = $_GET['role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone_number = $_POST['country_code'] . ($_POST['contact_number'] ?? '');
    $department = $_POST['department'] ?? '';
    $class_roll_no = $_POST['college_roll_no'] ?? '';
    $office = $_POST['office'] ?? '';

if ($action === 'login') {
        $result = loginUser($email, $password, $pdo);
        if ($result['success']) {
            if ($role === 'admin' && !isAdmin()) {
                $message = 'Access denied. Admins only.';
                logout();
            } else {
                header('Location: ' . ($role === 'admin' ? 'dashboard_topadmin.php' : 'index.php'));
                exit;
            }
        } else {
            $message = $result['message'];
        }
    }
        $allowed_admin_offices = ['President', 'Secretary General', 'Assistant Secretary General', 'Teacher'];
        if ($role === 'admin' && !in_array($office, $allowed_admin_offices)) {
            $message = 'Invalid admin office selected.';
        } else {
            $result = registerUser($email, $password, $office, $name, $phone_number, $department, $class_roll_no, $pdo);
            $message = $result['success']
                ? 'Registration successful! Your username is: ' . htmlspecialchars($result['username'])
                : $result['message'];
        }
    }

?>
<div class="form-wrapper">
  <div class="form-container">
    <h2 id="form-title" class="form-title">Login - <?php echo ucfirst($role); ?></h2>

    <?php if ($message): ?>
      <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" id="login-form">
      <input type="hidden" name="action" value="login" />
      <div class="input-box">
        <label>Email:</label>
        <div class="input-with-icon">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="email" required id="email" />
        </div>
      </div>

  <div class="input-box">
  <label>Password:</label>
  <div class="input-with-icon">
    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
    <input type="password" name="password" required id="password-signup" />
    <span class="toggle-password" onclick="togglePassword('password-signup', this)">
      <ion-icon name="eye-off"></ion-icon>
    </span>
  </div>
</div>

      <div class="checkbox-container">
        <input type="checkbox" name="remember" />
        <label>Remember Me</label>
        <a href="forgotpw.html" class="forgot-link">Forgot Password?</a>
      </div>

      <button type="submit">Login</button>
    </form>

    <!-- Signup Form -->
    <form method="POST" id="signup-form" class="hidden">
      <input type="hidden" name="action" value="signup" />
      <div class="input-box">
        <label>Email:</label>
        <div class="input-with-icon">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="email" required />
        </div>
      </div>

  <div class="input-box">
  <label>Password:</label>
  <div class="input-with-icon">
    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
    <input type="password" name="password" required id="password-signup" />
    <span class="toggle-password" onclick="togglePassword('password-signup', this)">
      <ion-icon name="eye-off"></ion-icon>
    </span>
  </div>
</div>

      <div class="input-box">
        <label>Name:</label>
        <input type="text" name="name" required />
      </div>

      <div class="input-box">
        <label>Contact Number:</label>
        <div class="country-code-box">
          <select name="country_code" required>
            <option value="">Code</option>
            <option value="+1">+1 (USA)</option>
            <option value="+44">+44 (UK)</option>
            <option value="+91">+91 (India)</option>
            <option value="+61">+61 (Australia)</option>
            <option value="+81">+81 (Japan)</option>
            <option value="+49">+49 (Germany)</option>
            <option value="+33">+33 (France)</option>
            <option value="+86">+86 (China)</option>
            <option value="+7">+7 (Russia)</option>
            <option value="+55">+55 (Brazil)</option>
          </select>
          <input type="text" name="contact_number" required placeholder="Phone number" />
        </div>
      </div>

      <div class="input-box">
        <label>Department:</label>
        <input type="text" name="department" required />
      </div>

      <div class="input-box">
        <label>College Roll No:</label>
        <input type="text" name="college_roll_no" required />
      </div>

      <div class="input-box">
        <label>Secretariat Office:</label>
        <select name="office" required>
          <option value="">Select Office</option>
          <option value="President">President</option>
          <option value="Secretary General">Secretary General</option>
          <option value="Assistant Secretary General">Assistant Secretary General</option>
          <option value="Teacher">Teacher</option>
          <option value="USG">USG</option>
          <option value="Junior Secretariat">Junior Secretariat</option>
        </select>
      </div>
      <button type="submit">Sign Up</button>
    </form>

    <div class="toggle-link" onclick="toggleForms()">Don't have an account? Sign Up</div>
  </div>
</div>
<?php include 'footer.php'; ?>
<script>
function toggleForms() {
  const loginForm = document.getElementById('login-form');
  const signupForm = document.getElementById('signup-form');
  const title = document.getElementById('form-title');
  const toggleLink = document.querySelector('.toggle-link');

  if (loginForm.classList.contains('hidden')) {
    loginForm.classList.remove('hidden');
    signupForm.classList.add('hidden');
    title.textContent = 'Login - <?php echo ucfirst($role); ?>';
    toggleLink.textContent = "Don't have an account? Sign Up";
  } else {
    loginForm.classList.add('hidden');
    signupForm.classList.remove('hidden');
    title.textContent = 'Sign Up - <?php echo ucfirst($role); ?>';
    toggleLink.textContent = "Already have an account? Login";
  }
}
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script>
function togglePassword(inputId, iconSpan) {
  const input = document.getElementById(inputId);
  const icon = iconSpan.querySelector('ion-icon');

  if (input.type === 'password') {
    input.type = 'text';
    icon.name = 'eye';
  } else {
    input.type = 'password';
    icon.name = 'eye-off';
  }
}
</script>

</body>
</html>
