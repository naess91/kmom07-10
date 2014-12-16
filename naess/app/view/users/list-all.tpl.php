<h2><?=$title?></h2>


<?php foreach ($users as $user) : ?>

<div style='float:left; padding:5px; width:300px;'>



<img style='float:left;margin-right:5px;' src="<?php if($user->image == null) {echo 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '.jpg?s=80';} else{ echo $user->image;}?>" width = "75" height = "75">

<span style="font-weight:bold;"><a href='<?=$this->url->create('users/id/' . $user->acronym)?>'><?=$user->acronym?></a><br>Namn:  <?=$user->name?><br>Email: <?=$user->email?><br />Skapad: <?=$user->created?></span>

</div>
 
<?php endforeach; ?>