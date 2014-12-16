<div>


<img style='float:left;margin-right:15px; 'src="<?php if($user->image == null) {echo 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '.jpg?s=80';} else{ echo $user->image;}?>" width = "100" height = "100">
<span style="font-weight:bold;"><a href='<?=$this->url->create('users/id/' . $user->acronym)?>'><?=$user->acronym?></a><br />Email: <?=$user->email?><br>Namn: <?=$user->name?><br>Skapad: <?=$user->created?></span>


<?php if(isset($logout)) {
	$loggaut = $this->url->create('users/logout/');
	$edit = $this->url->create('users/edit/' . $user->acronym);
	$pass = $this->url->create('users/changePassword/' . $user->acronym);
	echo "<br><a href='$loggaut'>Logga ut</a> -  <a href='$edit'>Redigera info</a> -  <a href='$pass'>Ändra Lösenord</a>";
}?>

</div>
<br />
<h3 style="margin-bottom:0px; padding-top:20px;">Frågor</h3>
<hr />
<?php if (is_array($questions) && !empty($questions)) : ?>  
<div class="questions"> 
	
<?php foreach ($questions as $question) : ?>  

<?php $url = $this->url->create('questions/show') .'/' . $question->id?>

<a href=<?php echo $url?>><div class="question"  style='overflow:auto; padding:10px; padding-bottom:10px;position:relative;'>


<h4 style="clear:both;"><span class='questionName'><?=$question->title?></span></h4>



	 <span style="float:right;"><?=$question->created?></span> 
</div></a>
<?php endforeach;?> 

</div>  
<?php endif; ?> 

<h3 style="margin-bottom:0px;">Svar</h3>
<hr />

<?php if (is_array($answers) && !empty($answers)) : ?>  
<div class="questions"> 
	
<?php foreach ($answers as $question) : ?> 


<?php $url = $this->url->create('questions/view') .'/' . $question[0]->id?>

<a href=<?php echo $url?>><div class="question"  style='overflow:auto; padding:10px; padding-bottom:10px;position:relative;'>


<h4 style="clear:both;"><span class='questionName'><?=$question[0]->title?></span></h4>



	 <span style="float:right;"><?=$question[0]->created?></span> 
</div></a>
<?php endforeach;?> 

</div>  
<?php endif; ?> 

