<?php
namespace Naess\Kalender;
class Kalender {  
     

     
    /* Properties */  
    private $days = array("Måndag","Tisdag","Onsdag","Torsdag","Fredag","Lördag","Söndag");
     
    private $thisYear=0;
     
    private $thisMonth=0;
     
    private $thisDay=0;
     
    private $thisDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
	
	
    
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->thisYear=$year;
         
        $this->thisMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
					"<img src = 'img/manadensbabe/$month.jpg'>".
					
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createCalender().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                              
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                 
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->thisDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->thisYear.'-'.$this->thisMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->thisDay=1;
                 
            }
        }
         
        if( ($this->thisDay!=0)&&($this->thisDay<=$this->daysInMonth) ){
             
            $this->thisDate = date('Y-m-d',strtotime($this->thisYear.'-'.$this->thisMonth.'-'.($this->thisDay)));
             
            $cellContent = $this->thisDay;
             
            $this->thisDay++;   
             
        }else{
             
            $this->thisDate =null;
 
            $cellContent=null;
        }
             
         
        return '<li id="li-'.$this->thisDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }
    
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->thisMonth==12?1:intval($this->thisMonth)+1;
         
        $nextYear = $this->thisMonth==12?intval($this->thisYear)+1:$this->thisYear;
         
        $preMonth = $this->thisMonth==1?12:intval($this->thisMonth)-1;
         
        $preYear = $this->thisMonth==1?intval($this->thisYear)-1:$this->thisYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Tidigare månad</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->thisYear.'-'.$this->thisMonth.'-1')).'</span>'.
				
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Nästa månad</a>'.
            '</div>';
    }
         
    /**
    * create calendar week 
    */
    private function _createCalender(){  
                 
        $content='';
         
        foreach($this->days as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}
?>