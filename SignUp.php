<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Demo mode: Disable sign up
    echo "<script>
            alert('Demo mode: Sign up is disabled. Please use the demo credentials: admin/admin');
            window.location.href = 'login.php';
          </script>";
    exit;
    
    // Original code commented out for demo
    /*
    $user_id = $_POST['user_id'];
    $email = $_POST['Email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['PhoneNumber'];
    $dob = $_POST['date_of_birth'];
    $height = $_POST['Height'];
    $weight = $_POST['Weight'];
    $country = $_POST['Country'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;

    $sql = "INSERT INTO users (user_id, email, password, phone_number, dob, height, weight, country, gender) 
            VALUES ('$user_id', '$email', '$password', '$phone_number', '$dob', '$height', '$weight', '$country', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('تم انشاء الحساب بنجاح');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $sql . "<br>" . $conn->error . "');
              </script>";
    }
    */
}

$conn->close();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="SignUp.CSS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="SignUp.CSS">
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

    <div class="wrapper">
        <div class="title">صفحة إنشاء حساب</div>
        <form id="form" action="SignUp.php" method="POST">
            <div class="user-det">
                <div class="input-box">
                    <label class="det">اسم المستخدم</label>
                    <input type="text" name="user_id" id="ID" placeholder="ادخل اسم المستخدم " required>
                </div>

                <div class="input-box">
                    <label class="det">الإيميل</label>
                    <input type="email" name="Email" id="Email" placeholder=" ادخل الايميل الخاص بك" required>
                    <small class="error"></small>
                </div>

                <div class="input-box">
                    <label class="det">كلمة المرور</label>
                    <input type="password" name="password" id="password" placeholder=" ادخل  كلمة المرور" required>
                    <small class="error"></small>
                </div>

                <div class="input-box">
                    <label class="det">تأكيد كلمة المرور</label>
                    <input type="password" id="ConfirmPassword" placeholder="تأكيد كلمة المرور" required>
                    <small class="error"></small>
                </div>
                <div class="input-box">
                    <label class="det">رقم الجوال</label>
                    <input type="number" name="PhoneNumber" placeholder="ادخل رقم الجوال" required>
                </div>

                <div class="input-box">
                    <label class="det">تاريخ الميلاد</label>
                    <input type="date" name="date_of_birth" placeholder="">
                </div>

                <div class="input-box">
                    <label class="det">الطول</label>
                    <input type="number" name="Height" placeholder="الطول ب سم">
                </div>

                <div class="input-box">
                    <label class="det">الوزن</label>
                    <input type="number" name="Weight" placeholder="الوزن بالكيلو قرام">
                </div>

                <div class="input-box">
                    <label class="det">البلد</label>
                    <div class="select">
                        <select name="Country" id="format">
                            <option selected disabled>اختر بلدك</option>
                            <option value="Saudi Arabia">المملكة العربية السعودية</option>
                            <option value="Bahrain">البحرين</option>
                            <option value="Kuwait">الكويت</option>
                            <option value="United Arab Emirates">الإمارات</option>
                            <option value="Qatar">قطر</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="gender-det">
                <input type="radio" name="gender" id="dot-1" value="رجل">
                <input type="radio" name="gender" id="dot-2" value="أنثى">
                <label class="gender-title">الجنس</label>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">رجل</span>
                    </label>

                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">أنثى</span>
                    </label>
                </div>
            </div>

            <div>
                <input type="submit" value="إنشئ الحساب" class="btn2">
            </div>
            <br>
            <p>لديك حساب سابقا ؟ <a href="login.php"> سجل الدخول</a></p>
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
