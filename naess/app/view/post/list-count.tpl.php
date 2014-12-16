

<?php if (is_array($questions) && !empty($questions)) : ?>  


<?php foreach ($questions as $question) : ?>  







<h2><?=$title?>:<?=$question->count?></h2>
 




<?php endforeach;?> 

<?php endif; ?> 



 

