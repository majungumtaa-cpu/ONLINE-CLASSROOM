<?php
require 'includes/bootstrap.php';
if(empty($_SESSION['role'])) go('student_login.php');
$role=$_SESSION['role']; $isManager=can_manage_content();
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 if(!$isManager){http_response_code(403);exit('Not allowed.');}
 $action=$_POST['action']??'add';
 if($action==='delete'){
  $id=(int)($_POST['id']??0); $q=$pdo->prepare('SELECT * FROM video_lectures WHERE id=?');$q->execute([$id]);$v=$q->fetch();
  if($v && ($role==='admin' || (int)$v['faculty_id']===(int)$_SESSION['user_id'])){if($v['video_path'] && is_file(__DIR__.'/'.$v['video_path']))@unlink(__DIR__.'/'.$v['video_path']);$pdo->prepare('DELETE FROM video_lectures WHERE id=?')->execute([$id]);flash('Video lecture deleted.');}
  go('video-lectures.php');
 }
 $title=trim($_POST['title']??'');$subject=trim($_POST['subject']??'');$desc=trim($_POST['description']??'');$type=$_POST['video_type']??'upload';
 if($title===''||$subject===''){flash('Title and subject are required.');go('video-lectures.php');}
 $path=null;$url=null;
 if($type==='url'){$url=trim($_POST['video_url']??'');if(!filter_var($url,FILTER_VALIDATE_URL)||!preg_match('~^https?://~i',$url)){flash('Enter a valid http/https video URL.');go('video-lectures.php');}}
 else {
  if(empty($_FILES['video']['tmp_name'])||$_FILES['video']['error']!==UPLOAD_ERR_OK){flash('Choose a video file to upload.');go('video-lectures.php');}
  if($_FILES['video']['size']>200*1024*1024){flash('Video must be 200 MB or smaller.');go('video-lectures.php');}
  $finfo=new finfo(FILEINFO_MIME_TYPE);$mime=$finfo->file($_FILES['video']['tmp_name']);$allowed=['video/mp4'=>'mp4','video/webm'=>'webm','video/ogg'=>'ogv'];
  if(!isset($allowed[$mime])){flash('Only MP4, WebM or OGG videos are allowed.');go('video-lectures.php');}
  $name=bin2hex(random_bytes(16)).'.'.$allowed[$mime];$dest=__DIR__.'/uploads/videos/'.$name;
  if(!move_uploaded_file($_FILES['video']['tmp_name'],$dest)){flash('Could not save uploaded video.');go('video-lectures.php');}$path='uploads/videos/'.$name;
 }
 $q=$pdo->prepare('INSERT INTO video_lectures(title,description,subject,video_type,video_path,video_url,faculty_id) VALUES(?,?,?,?,?,?,?)');$q->execute([$title,$desc,$subject,$type,$path,$url,$role==='faculty'?$_SESSION['user_id']:null]);
 flash('Video lecture published.');go('video-lectures.php');
}
$q=$pdo->query("SELECT v.*,COALESCE(f.name,'Administrator') AS faculty_name FROM video_lectures v LEFT JOIN faculty f ON f.id=v.faculty_id ORDER BY v.created_at DESC");$videos=$q->fetchAll();
page_start('Video Lectures');
?>
<div class="vc-card"><h2>Video Lectures</h2><p>Watch class recordings and learning videos.</p>
<?php if($isManager): ?><hr><h4>Publish a video lecture</h4><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="add"><div class="form-group mb-3"><label>Lecture title</label><input class="form-control" name="title" required maxlength="200"></div><div class="form-group mb-3"><label>Subject</label><input class="form-control" name="subject" required></div><div class="form-group mb-3"><label>Description</label><textarea class="form-control" name="description" rows="3"></textarea></div><div class="form-group mb-3"><label>Video source</label><select class="form-control" name="video_type" id="videoType" onchange="document.getElementById('uploadBox').hidden=this.value==='url';document.getElementById('urlBox').hidden=this.value!=='url'"><option value="upload">Upload video (MP4/WebM/OGG, max 200MB)</option><option value="url">Video URL</option></select></div><div id="uploadBox" class="form-group mb-3"><input class="form-control" type="file" name="video" accept="video/mp4,video/webm,video/ogg"></div><div id="urlBox" class="form-group mb-3" hidden><input class="form-control" type="url" name="video_url" placeholder="https://..."></div><button class="btn btn-primary">Publish lecture</button></form><?php endif; ?>
</div>
<?php foreach($videos as $v): ?><div class="vc-card"><h4><?=e($v['title'])?></h4><p><b><?=e($v['subject'])?></b> · By <?=e($v['faculty_name'])?> · <?=e($v['created_at'])?></p><p><?=nl2br(e($v['description']))?></p><?php if($v['video_type']==='upload' && $v['video_path']): ?><video controls preload="metadata" style="width:100%;max-height:480px;background:#111"><source src="<?=e($v['video_path'])?>"></video><?php elseif($v['video_url']): ?><p><a href="<?=e($v['video_url'])?>" target="_blank" rel="noopener">Open video link</a></p><?php endif; ?><?php if($isManager && ($role==='admin'||(int)$v['faculty_id']===(int)$_SESSION['user_id'])): ?><form method="post" onsubmit="return confirm('Delete this lecture?')"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$v['id']?>"><button class="btn btn-sm btn-danger">Delete</button></form><?php endif; ?></div><?php endforeach; if(!$videos): ?><div class="vc-card">No video lectures have been published yet.</div><?php endif; ?>
<?php page_end(); ?>