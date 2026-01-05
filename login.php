<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_POST['user_id'];
  $password = $_POST['password'];

  $sql = "SELECT id, password FROM users WHERE user_id = '$user_id' AND user_id = 'admin'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['user_id'] = $row['id'];
      header("Location: index.php");
      exit;
    } else {
      echo "<script>alert('Invalid password');</script>";
    }
  } else {
    echo "<script>alert('User ID not found');</script>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <header id="header" dir="ltr" lang="en">
    <a class="logo" href="index.php">Imamu Project</a>
    <nav><a href="#menu">القائمة</a></nav>
  </header>
  <nav id="menu">
    <ul class="links">
      <li><a href="SignUp.php">إنشاء حساب </a></li>
      <li><a href="profile.php">تسجيل الدخول</a></li>
      <li><a href="about.html">عنا</a></li>
      <li><a href="FAQs.html">الأسئلة الشائعة</a></li>
    </ul>
  </nav>

  <div class="log-form">
    <h2> صفحة تسجيل الدخول</h2>
    <form action="login.php" method="POST">
      <label for="user_id">اسم المستخدم</label>
      <input type="text" name="user_id" placeholder=" ادخل اسم المستخدم" required value="admin">
      <label for="password">كلمة المرور</label>
      <input type="password" name="password" placeholder="ادخل كلمة المرور" required value="admin">
      <button type="submit" class="btn">تسجيل الدخول</button>
      <a class="forgot" href="SignUp.php">لم تنشئ حساب ؟</a>
    </form>
  </div>

  <footer id="footer">
    <div class="inner">
      <div class="content">
        <section>
          <h3>عيادتنا</h3>
          <p>
            هي مركز رعاية طبي يقدم رعاية طبية وقائية روتينية للأشخاص الأصحاء،
            ورعاية طبية للمرضى، وتكون العيادات الطبية بالغالب أصغر من
            المستشفيات، ويزورها الأشخاص الأقل مرضاً الذين لا يحتاجون إلى
            المكوث.
          </p>
        </section>
        <section>
          <h4>روابط مفيدة</h4>
          <ul class="alt">
            <li><a href="ContactUs.php">تواصل معنا</a></li>
            <li><a href="https://maps.app.goo.gl/BkdD4PyRYsTDP2vM9" target="_blank">موقعنا</a></li>
            <li><a href="Rating.php">قيمنا</a></li>
            <li><a href="FAQs.html">الأسئلة الشائعة</a></li>
          </ul>
        </section>
        <section>
          <h4>برامج التواصل الاجتماعي</h4>
          <ul class="plain">
            <li>
              <a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a>
            </li>
            <li>
              <a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a>
            </li>
            <li>
              <a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a>
            </li>
            <li>
              <a href="#"><i class="icon fa-github">&nbsp;</i>Github</a>
            </li>
          </ul>
        </section>
      </div>
    </div>
  </footer>

  <div id="copyright" class="copyright">
    copyright
    <a href="Credit.pdf" download="Credit.pdf">Mohammed Aleshawi, click for more</a>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/util.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>