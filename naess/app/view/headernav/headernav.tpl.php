<?php 
if(isset($_SESSION['user']))  
        {  
  	            $html =  "<nav class='headnav'>
				<ul class = 'about' style = 'float:right; margin-right:15%;'>
				<li ><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/profile' title='Min profil'>Min profil</a></li>
<li ><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/users/logout' title='Logga ut'>Logga ut</a></li>
			
				</ul>
<ul style = 'float:left; margin-left:12%;'>
	<li><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/about' title='Om sidan'>Om sidan</a></li>

</ul>
</nav>
  
      
      ";
			
        }  
else {  
          
		            $html =  "<nav class='headnav'>
					
					<ul class = 'about' style = 'float:right; margin-right:15%;'>
				<li ><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/profile' title='Hem'>Logga in</a></li>

<li><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/users/register' title='Frågor'>Registrera dig</a></li>
				</ul>
<ul style = 'float:left; margin-left:12%;'>
<li><a href='http://www.student.bth.se/~ernb14/phpmvc/kmom07:10/naess/webroot/about' title='Om sidan'>Om sidan</a></li>







</ul>
</nav>
  
      
      ";
	 }  
	 
print $html;	 	
?>		