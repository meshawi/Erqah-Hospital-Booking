<?php
/**
 * Database Initializer for Erqah Hospital Booking System
 * This script runs on container startup to ensure the database is seeded
 */

// Get database credentials from environment
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'hospital_reservation_db';

// Wait for MySQL to be ready (max 60 seconds)
$maxRetries = 60;
$retries = 0;
$conn = null;

while ($retries < $maxRetries) {
    try {
        $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error);
        }
        echo "Connected to MySQL successfully.\n";
        break;
    } catch (Exception $e) {
        $retries++;
        echo "Waiting for MySQL... ($retries/$maxRetries)\n";
        sleep(1);
    }
}

if (!$conn || $conn->connect_error) {
    die("Failed to connect to MySQL after $maxRetries attempts.\n");
}

// Check if users table exists and has data
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    $userCount = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'];
    if ($userCount > 0) {
        echo "Database already initialized with $userCount user(s).\n";
        $conn->close();
        exit(0);
    }
}

echo "Initializing database...\n";

// Create clinic_types table
$conn->query("
CREATE TABLE IF NOT EXISTS `clinic_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Clinic types table created.\n";

// Insert clinic types
$conn->query("
INSERT IGNORE INTO `clinic_types` (`id`, `type_name`, `image_url`, `description`) VALUES
(1, 'عيادة العظام', 'images/Bons.png', 'توفر العلاج و العنايه للجهاز العظمي ومعالجته.'),
(2, 'عيادة الاسره', 'images/Family.png', 'توفر الاستشاره للمريض اذا كان مرض نفسي او جسدي او سلوكي.'),
(3, 'عيادة الاشعة', 'images/x-ray.png', 'عياده مخصه في التصوير السيني و كشف الامراض .'),
(4, 'عيادة الباطنيه', 'images/internal.png', 'مختص بتجهيز الاجهزه و استخراد الصور للمريض و تقديم'),
(5, 'عيادة اذن وحنجره', 'images/earsAndnose.png', 'مختصه بامراض الجهاز السمعي و الجهاز التنفسي و معالجتها.')
");
echo "Clinic types inserted.\n";

// Create doctors table
$conn->query("
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clinic_type_id` int(11) DEFAULT NULL,
  `working_hours_from` time DEFAULT NULL,
  `working_hours_to` time DEFAULT NULL,
  `image_url` varchar(255) DEFAULT '/images/Doctor_1.jpg',
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic_type_id` (`clinic_type_id`),
  CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`clinic_type_id`) REFERENCES `clinic_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Doctors table created.\n";

// Insert doctors
$conn->query("
INSERT IGNORE INTO `doctors` (`id`, `name`, `clinic_type_id`, `working_hours_from`, `working_hours_to`, `image_url`, `description`) VALUES
(1, 'مبارك الدوسري', 1, '00:00:00', '11:59:59', 'images/DCTR1.png', 'طبيب مختص بمراض الجهاز العظمي و مشاكل العظم.'),
(2, 'الدكتور **', 1, '12:00:00', '23:59:59', 'images/Doctor_defualt.png', 'طبيب مختص بمراض الجهاز العظمي و مشاكل العظم.'),
(3, 'إبراهيم الفضل', 2, '00:00:00', '11:59:59', 'images/DCTR2.png', 'طبيب مختص بالاتشاره و و معالجة المريض.'),
(4, 'الدكتور **', 2, '12:00:00', '23:59:59', 'images/Doctor_defualt.png', 'طبيب مختص بالاتشاره و و معالجة المريض.'),
(5, 'Doctor1', 3, '00:00:00', '11:59:59', 'images/DCTR3.png', 'طبيب الاشعه: مختص بتجهيز الاجهزه و استخراد الصور للمريض.'),
(6, 'الدكتور **', 3, '12:00:00', '23:59:59', 'images/Doctor_defualt.png', 'طبيب الاشعه: مختص بتجهيز الاجهزه و استخراد الصور للمريض.'),
(7, 'عبد الاله الشهراني', 4, '00:00:00', '11:59:59', 'images/DCTR4.png', 'طبيب الباطنيه:مختص بمراض الجهاز الهضمي و تشخصيها.'),
(8, 'الدكتور **', 4, '12:00:00', '23:59:59', 'images/Doctor_defualt.png', 'طبيب الباطنيه:مختص بمراض الجهاز الهضمي و تشخصيها.'),
(9, 'غسان الاسمري', 5, '00:00:00', '11:59:59', 'images/DCTR5.png', 'طبيب الاذن و الحنجره:مختص بامراض الجهاز السمعي و التنفسي.'),
(10, 'الدكتور **', 5, '12:00:00', '23:59:59', 'images/Doctor_defualt.png', 'طبيب الاذن و الحنجره:مختص بامراض الجهاز السمعي و التنفسي.')
");
echo "Doctors inserted.\n";

// Create users table
$conn->query("
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Users table created.\n";

// Insert demo admin user (password is hashed 'admin')
$adminPassword = password_hash('admin', PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT IGNORE INTO `users` (`id`, `user_id`, `email`, `password`, `phone_number`, `country`, `gender`) VALUES (1, 'admin', 'admin@hospital.local', ?, '+966500000000', 'Saudi Arabia', 'Male')");
$stmt->bind_param("s", $adminPassword);
$stmt->execute();
echo "Demo admin user created (admin/admin).\n";

// Create appointments table
$conn->query("
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `doctor_id` (`doctor_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Appointments table created.\n";

// Create contact table
$conn->query("
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Contact table created.\n";

// Create ratings table
$conn->query("
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "Ratings table created.\n";

echo "Database initialization complete!\n";
$conn->close();
?>