
<h2><?=$title?></h2>
<hr />

<?php foreach($taglist as $tag) {?>
<div style='clear:both;'>
	
<span style="margin-bottom:0px; font-size:26px;"><a style="text-decoration:none;" href="<?=$this->url->create('questions/list/' . $tag->tag)?>"><?=$tag->tag?></a></span><span style="font-style:italic;">(<?=$tag->total?>)</span>
</div>

<? } ?>