<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require_once __DIR__.'/../config/database.php';
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function go($url){header('Location: '.$url);exit;}
function flash($msg){$_SESSION['flash']=$msg;}
function show_flash(){if(!empty($_SESSION['flash'])){echo '<div class="alert alert-info">'.e($_SESSION['flash']).'</div>';unset($_SESSION['flash']);}}
function require_role($role){if(($_SESSION['role']??'')!==$role) go($role.'_login.php');}
function page_start($title='Virtual Classroom'){?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?=e($title)?></title><link rel="stylesheet" href="assets/css/bootstrap.min.css"><link rel="stylesheet" href="assets/css/style.css"><style>body{background:#f5f7fb}.vc-nav{background:#182b5b;padding:16px}.vc-nav a{color:white;margin-right:18px}.vc-card{background:white;padding:25px;border-radius:10px;box-shadow:0 4px 20px #0001;margin:20px 0}</style></head><body><nav class="vc-nav"><a href="index.php"><b>Virtual Classroom</b></a><a href="index.php">Home</a><a href="student_login.php">Student</a><a href="faculty_login.php">Faculty</a><a href="admin_login.php">Admin</a><?php if(!empty($_SESSION['role'])):?><a href="<?=e($_SESSION['role'])?>_dashboard.php">Dashboard</a><a href="logout.php">Logout</a><?php endif;?></nav><main class="container py-4"><?php show_flash(); ?><?php }
function page_end(){?></main><script src="assets/js/jquery-1.12.4.min.js"></script><script src="assets/js/bootstrap.min.js"></script></body></html><?php }
function csrf_token(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function verify_csrf(){if($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(403);exit('Invalid request token. Please go back and try again.');}}
function current_user_name(){return $_SESSION['display_name']??'User';}
function can_manage_content(){return in_array($_SESSION['role']??'', ['faculty','admin'], true);}
function field($name,$label,$type='text',$required=true){echo '<div class="form-group mb-3"><label>'.e($label).'</label><input class="form-control" type="'.e($type).'" name="'.e($name).'" '.($required?'required':'').'></div>';}
