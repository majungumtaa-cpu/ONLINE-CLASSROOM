# ONLINE-CLASSROOM
SYSTEM CARRY ONLINE CLASSES
ONLINE CLASSROOM — COMPLETE PHP SYSTEM
A self-contained Online Classroom built with PHP + MySQL. The original design and assets are preserved. No external builder authentication is needed—accounts and sessions are handled entirely by PHP.

Modules Included
1. Administrator
Admin login and control panel.

Review, approve, or decline student sign-up requests.

Review, approve, or decline instructor sign-up requests.

Access classroom content modules and manage published materials.

2. Instructor (Faculty)
Instructor sign-up and login (new accounts require admin approval).

Instructor dashboard.

Publish video lessons by uploading MP4, WebM, OGG files or by adding an external HTTP/HTTPS video link.

Upload learning resources: PDF, DOC/DOCX, PPT/PPTX, XLS/XLSX and TXT.

Remove their own video lessons and learning resources.

Respond to questions submitted by learners.

3. Learner (Student)
Learner sign-up and login (new accounts require admin approval).

Learner dashboard.

Watch available video lessons.

Download learning resources.

Submit subject questions and view instructor/admin responses.

4. Database and Security
MySQL schema is included in database.sql.

PDO prepared statements are used for all database operations.

Passwords use password_hash() and password_verify().

Role-based session verification, CSRF checks on form submissions, output escaping, and upload type/size validation are included.

Upload directories block PHP execution on Apache using .htaccess.

Requirements
Windows XAMPP (Apache + MySQL/MariaDB) or equivalent PHP 8+ hosting.

PHP extensions: pdo_mysql and fileinfo.

For uploads, configure PHP upload_max_filesize and post_max_size to the desired upload size. The application limits videos to 200 MB and learning resources to 25 MB.

Installation on XAMPP (Windows)
Extract the folder Online-Classroom-PHP into C:\xampp\htdocs\.

Open XAMPP Control Panel and start Apache and MySQL.

Open http://localhost/phpmyadmin.

Select Import, choose this folder's database.sql, and import it. The SQL creates/selects the online_classroom database and all required tables.

Open config/database.php. The defaults are host localhost, database online_classroom, username root, and an empty password. Change them if your MySQL credentials differ.

Ensure these folders exist and are writable by the web server:

uploads/videos/

uploads/materials/

Visit http://localhost/Online-Classroom-PHP/setup_admin.php once. It creates the first administrator if no administrator exists.

Sign in at http://localhost/Online-Classroom-PHP/admin_login.php with:

Username: admin

Password: Admin@12345

Immediately change the initial administrator password if the application provides that option; otherwise change it directly by creating a new password hash and updating the admin.password field, or restrict/delete the one-time setup script after setup.

Delete setup_admin.php from the server after the first administrator is created.

Main URLs
Home: http://localhost/Online-Classroom-PHP/

Learner registration: student_register.php

Instructor registration: faculty_register.php

Administrator login: admin_login.php

Video lessons: video-lectures.php (requires sign-in)

Learning resources: study-material.php (requires sign-in)

Q&A forum: qa.php (requires sign-in)

Important Notes
Learner and instructor accounts remain pending until an administrator approves them.

This is a fresh standalone PHP/MySQL installation. Import the supplied database.sql into a new/empty online_classroom database; do not import the old JSP project's database dump over it.

Video URL entries are saved as external links; uploaded video files are played in the browser when the format is supported.

The project was syntax-checked with PHP CLI and the ZIP archive integrity was checked. A live database/browser test requires running it in your own XAMPP/hosting environment with MySQL configured.
