# VIRTUAL CLASSROOM — PHP FULL COMBINED SYSTEM

Standalone Virtual Classroom converted to **PHP + MySQL**. The original theme/assets are retained. Builder-specific authentication is not required; accounts and sessions are managed locally by PHP.

## Included modules

### 1. Administrator
- Administrator sign-in and dashboard.
- Review, approve, or reject student registration requests.
- Review, approve, or reject faculty registration requests.
- Access classroom content modules and manage published content.

### 2. Faculty
- Faculty registration and sign-in (new registrations require administrator approval).
- Faculty dashboard.
- Publish video lectures by uploading MP4, WebM, OGG or by adding an external HTTP/HTTPS video URL.
- Upload study materials: PDF, DOC/DOCX, PPT/PPTX, XLS/XLSX and TXT.
- Delete their own video lectures and study materials.
- Answer questions posted by students.

### 3. Student
- Student registration and sign-in (new registrations require administrator approval).
- Student dashboard.
- Watch available video lectures.
- Download study materials.
- Post subject questions and view faculty/admin answers.

### 4. Database and security
- MySQL schema is provided in `database.sql`.
- PDO prepared statements are used for database operations.
- Passwords use `password_hash()` and `password_verify()`.
- Role-based session checks, CSRF checks on form submissions, output escaping, and upload type/size validation are included.
- Upload directories block PHP execution on Apache using `.htaccess`.

## Requirements
- Windows XAMPP (Apache + MySQL/MariaDB) or equivalent PHP 8+ hosting.
- PHP extensions: `pdo_mysql` and `fileinfo`.
- For uploads, configure PHP `upload_max_filesize` and `post_max_size` to the desired upload size. The application limits videos to 200 MB and study materials to 25 MB.

## Installation on XAMPP (Windows)

1. Extract the folder `Virtual-Classroom-PHP` into `C:\xampp\htdocs\`.
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import**, choose this folder's `database.sql`, and import it. The SQL creates/selects the `virtual_classroom` database and all required tables.
5. Open `config/database.php`. The defaults are host `localhost`, database `virtual_classroom`, username `root`, and an empty password. Change them if your MySQL credentials differ.
6. Ensure these folders exist and are writable by the web server:
   - `uploads/videos/`
   - `uploads/materials/`
7. Visit `http://localhost/Virtual-Classroom-PHP/setup_admin.php` once. It creates the first administrator if no administrator exists.
8. Sign in at `http://localhost/Virtual-Classroom-PHP/admin_login.php` with:
   - Username: `admin`
   - Password: `Admin@12345`
9. **Immediately change the initial administrator password** if the application provides that option; otherwise change it directly by creating a new password hash and updating the `admin.password` field, or restrict/delete the one-time setup script after setup.
10. Delete `setup_admin.php` from the server after the first administrator is created.

## Main URLs
- Home: `http://localhost/Virtual-Classroom-PHP/`
- Student registration: `student_register.php`
- Faculty registration: `faculty_register.php`
- Administrator login: `admin_login.php`
- Video lectures: `video-lectures.php` (requires sign-in)
- Study materials: `study-material.php` (requires sign-in)
- Q&A forum: `qa.php` (requires sign-in)

## Important notes
- Student and faculty accounts remain pending until an administrator approves them.
- This is a fresh standalone PHP/MySQL installation. Import the supplied `database.sql` into a **new/empty** `virtual_classroom` database; do not import the old JSP project's database dump over it.
- Video URL entries are saved as external links; uploaded video files are played in the browser when the format is supported.
- The project was syntax-checked with PHP CLI and the ZIP archive integrity was checked. A live database/browser test requires running it in your own XAMPP/hosting environment with MySQL configured.
