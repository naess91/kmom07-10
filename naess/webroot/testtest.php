<?php
  if(!isset($_SESSION['user']))  
        {  
            $html = '<p>hej</p>';
        }  
else {  
            $html = '<p>hej då</p>';
        }  
return $html;	
?>