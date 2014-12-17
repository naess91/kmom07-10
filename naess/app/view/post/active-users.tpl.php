<h2><?=$title?></h2>
<hr />
<?php if (is_array($questions) && !empty($questions)) : ?>  
 
	
<?php foreach ($questions as $question) : ?>  



<h4 style="clear:both;"><span class='questionName' style = "float:left"><a href='<?=$this->url->create('users/id/' . $question->user)?>'><?=$question->user?> - <?=$question->total?> inlägg</span></h4></a>



	

<?php endforeach;?> 
  
<?php endif; ?> 