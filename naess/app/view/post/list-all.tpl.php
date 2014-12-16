
<h2><?=$title?></h2>
<hr />
<?php if (is_array($questions) && !empty($questions)) : ?>  



<?php foreach ($questions as $question) : ?>  

<?php $url = $this->url->create('questions/view') .'/' . $question->id?>
<a href=<?php echo $url?>><h2 style = "float:left;"><?=$question->title?></h2></a>
<p style = "float:right;"><a href="<?=$this->url->create('users/id/' . $question->user)?>"><?=$question->user?></a> <?=$question->created?></p>

<div style = "clear:both;">
</div>





<?php endforeach;?> 
 
<?php endif; ?> 



 

