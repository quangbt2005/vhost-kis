<?php
/*
include ("../lib/jpgraph.php") ;
include ("../lib/jpgraph_bar.php");
include ("../lib/jpgraph_line.php");
include ("../lib/jpgraph_stock.php");
include ("../lib/jpgraph_scatter.php");
include ("../lib/jpgraph_canvas.php");
include "../../../include/db1.php";
*/
define ("ROOT_PATH", "/home/vhosts/eps/htdocs/");
include (ROOT_PATH."chart/module/charts/lib/jpgraph.php") ;
include (ROOT_PATH."chart/module/charts/lib/jpgraph_bar.php");
include (ROOT_PATH."chart/module/charts/lib/jpgraph_line.php");
include (ROOT_PATH."chart/module/charts/lib/jpgraph_stock.php");
include (ROOT_PATH."chart/module/charts/lib/jpgraph_scatter.php");
include (ROOT_PATH."chart/module/charts/lib/jpgraph_canvas.php");
include ROOT_PATH."chart/include/db.php";

$rssql="select max(date) maxdate from draw_chart where mid=2";
$rsresult=mysql_query($rssql);
$row=mysql_fetch_array($rsresult);
 $date=$row['maxdate'];
//echo $rssql;
//if($date>date("Ymd")) $date=date("Ymd");
$prename=$date;
$mid=2;
$realpath = "/home/vhosts/eps/htdocs/chart/module/charts/chart_images/market/";
for($type=1;$type<=8;$type++)
{

	//echo $type;
	if ($type == 1)
	{

	$sql = "SELECT *,date_format(date,'%Y-%m-%d') LayNgay FROM draw_chart WHERE date_format(date,'%Y%m%d')<=date_format($date,'%Y%m%d') and date_format(date,'%Y%m%d')>=date_format(DATE_SUB($date,INTERVAL 30 DAY),'%Y%m%d') AND volume!=0 and mid=2 ORDER By date desc limit 0,9";	
	}
	elseif ($type == 2)
	{
		$sql = "SELECT *,date_format(date,'%Y-%m-%d') LayNgay FROM draw_chart WHERE  date_format(date,'%Y%m%d')<=date_format($date,'%Y%m%d') and date_format(date,'%Y%m%d')>=date_format(DATE_SUB($date,INTERVAL 90 DAY),'%Y%m%d') AND volume!=0 and mid=2 ORDER By date desc limit 0,44";
	}
	elseif ($type == 3)
	{
		$sql = "SELECT *,date_format(date,'%Y-%m-%d') LayNgay FROM draw_chart WHERE  date_format(date,'%Y%m%d')<=date_format($date,'%Y%m%d') and date_format(date,'%Y%m%d')>=date_format(DATE_SUB($date,INTERVAL 300 DAY),'%Y%m%d') AND volume!=0 and mid=2 ORDER By date desc limit 0,134";

	}
	elseif ($type == 4)//6Month
	{
		$sql = "SELECT *,date_format(date,'%Y-%m-%d') LayNgay FROM draw_chart WHERE  date_format(date,'%Y%m%d')<=date_format($date,'%Y%m%d') and date_format(date,'%Y%m%d')>=date_format(DATE_SUB($date,INTERVAL 365 DAY),'%Y%m%d') AND volume!=0 and mid=2 ORDER By date desc limit 0,184";
	}
	elseif ($type == 5)//1Year
	{
		$sql = "select date LayNgay,closed_price ,min_price ,max_price ,open_price , volume from draw_chart_year where mid=2 order by date desc limit 0,78";
	}
	elseif ($type == 6)//2Year
	{
		$sql = "select date LayNgay,closed_price ,min_price ,max_price ,open_price , volume from draw_chart_year where mid=2  order by date desc limit 0,135";
	}
	elseif ($type == 7)//5Year
	{
		$sql = "select date LayNgay,closed_price ,min_price ,max_price ,open_price , volume from draw_chart_year_base_month where mid=2  order by date desc limit 0,75";
	}
	elseif ($type == 8)//10Year
	{
		$sql = "select date LayNgay,closed_price ,min_price ,max_price ,open_price , volume from draw_chart_year_base_month where mid=2 order by date desc limit 0,135";
	}
    switch($type)
	{
	  case 1: 
	         {
			 $limit=9;
			 $numstick=5;
	         break;
	         } 
	  case 2: 
	         {
			 $limit=44;
			 $numstick=20;
	         break;
	         } 
	  case 3: 
	         {
			 $limit=134;
			 $numstick=60;
	         break;
	         } 
	  case 4: 
            {
			 $limit=184;
			 $numstick=110;
	         break;
	         } 
	  case 5: 
	         {
			 $limit=78;
			 $numstick=52;
	         break;
	         } 
	  case 6: 
	         {
			 $limit=135;
			 $numstick=105;
	         break;
	         } 	 
	case 7: 
	         {
			 $limit=75;
			 $numstick=60;
	         break;
	         } 	 	 
	case 8: 
	         {
			 $limit=135;
			 $numstick=120;
	         break;
	         } 	 
	} //end switch

    $result= $db->sql_query($sql);
	
	$limit=$db->sql_numrows($result);
    
	 if($limit<$numstick)
	   {
	    $numstick=$limit;
	   }

if($limit==0 || $limit=="")// sovle case do not have data
{


	$graph = new CanvasGraph(660,200,"auto");	
	$graph->SetMarginColor('white');
	$graph->SetMargin(2,60,2,25);
	$graph->InitFrame();
    $text=new Text("       [This chart does not have enough data]");
	$text->SetPos(400,60,'right');
	$text->SetColor("black");
	$graph->AddText($text);
	
	$graph2=new CanvasGraph(660,170,'auto');
 	$graph2->SetMarginColor('white');
	$graph2->SetMargin(2,60,2,25);
	$graph2->InitFrame();
    $graph2->AddText($text);
	if ($type == 1)
	{
		$graph->Stroke($realpath.$prename."1W_1.png");
		$graph2->Stroke($realpath.$prename."1W_2.png");
	}
	elseif ($type == 2)
	{
		//echo '111';
		$graph->Stroke($realpath.$prename."1M_1.png");
		$graph2->Stroke($realpath.$prename."1M_2.png");
	}
	elseif ($type == 3)
	{
		$graph->Stroke($realpath.$prename."3M_2.png");
		$graph2->Stroke($realpath.$prename."3M_2.png");
	}
	elseif ($type == 4)
	{
		$graph->Stroke($realpath.$prename."6M_2.png");
		$graph2->Stroke($realpath.$prename."6M_2.png");
	}
	elseif ($type == 5)
	{

		$graph->Stroke($realpath.$prename."1Y_1.png");
		$graph2->Stroke($realpath.$prename."1Y_2.png");
	}
	elseif ($type == 6)
	{
		$graph->Stroke($realpath.$prename."2Y_1.png");
		$graph2->Stroke($realpath.$prename."2Y_2.png");
	}
	elseif ($type == 7)
	{
		$graph->Stroke($realpath.$prename."5Y_1.png");
		$graph2->Stroke($realpath.$prename."5Y_2.png");
	}
	elseif ($type == 8)
	{
		$graph->Stroke($realpath.$prename."10Y_1.png");
		$graph2->Stroke($realpath.$prename."10Y_2.png");
	}

}
else
  {// begin process draw chart
      $ydata="";$datay="";$ydatamedian="";
      $countstick=0;$days="";
	  
	while ($row = $db->sql_fetchrow($result))
	{
		if($row['volume'] != "" && $row['volume'] != 0)
		{
          if($countstick<$numstick)
		  {	 

			$ydata= floatval($row['volume'])." ".$ydata; 

			if ($row['min_price']==0)
			{
			$opentmp=floatval($row['open_price']);
			$closedtmp=floatval($row['closed_price']);
            $maxtmp=floatval($row['max_price']);
			$mintmp=$opentmp > $closedtmp ? $closedtmp : $opentmp ;
            $mintmp=$mintmp>$maxtmp ? $maxtmp :$mintmp ;
			if ($mintmp>0.1) $mintmp=$mintmp-0.1;
			}
			else 
			{
			$mintmp=$row['min_price'];
			}

          //  $datay = floatval($row['median'])." ".$datay;
			$datay = floatval($row['max_price'])." ".$datay;
//			$datay = floatval($row['min_price'])." ".$datay;
			$datay = floatval($mintmp)." ".$datay;
			$datay = floatval($row['closed_price'])." ".$datay;
      		$datay = floatval($row['open_price'])." ".$datay; 
			
			$days= $row['LayNgay']." ".$days;
		    if($countstick==0) $datemax=$row['LayNgay'];
		    if($countstick==$numstick-1) $datemin=$row['LayNgay']; 

          }//end get stick

           $countstick++;  
           $ydatamedian =floatval($row['closed_price'])." ".$ydatamedian; 
		}
	}




//if($type==5) echo $datemin." ".$datemax;
        $countDatay=strlen($datay)-1;
  	    $countYdata=strlen($ydata)-1;
	    $countYdatamedian=strlen($ydatamedian)-1; 
        if($type==1 || $type==2)
		{
    	$countDays=strlen($days)-1;
	    $days = substr($days,0,$countDays);  
	    $days = explode(" ", $days);  	
         }
       $datay = substr($datay,0,$countDatay);  
	   $ydata = substr($ydata,0,$countYdata);  
	   $ydatamedian = substr($ydatamedian,0,$countYdatamedian);  //sp

		
  	   $ydata = explode(" ", $ydata); 
	   $ydatamedian = explode(" ", $ydatamedian);
	   $datay = explode(" ", $datay);  

	  $startmedian=$limit-$numstick;

     //begin get median
   for($i=0;$i<$numstick;$i++)
    {
        
		if($type==2 || $type==7 || $type==8)
		{      
	      $median5[$i]=0;
	     for($j=0;$j<5 && $startmedian-$j+$i>=0;$j++)
	       {$median5[$i]+=$ydatamedian[$startmedian-$j+$i];}
       		$median5[$i]=$median5[$i]/$j;
        }  
		
		
		if($type==2 || $type==3 || $type==4)
		 {
		 $median25[$i]=0;
	    for($k=0;$k<25 && $startmedian-$k+$i>=0;$k++)
	       {$median25[$i]+=$ydatamedian[$startmedian-$k+$i];}
  	         $median25[$i]=$median25[$i]/$k;
         }
		
		 if($type==3 || $type==4)
		 {
		   unset($k);
	    for($k=0;$k<75 && $startmedian-$k+$i>=0;$k++)
	       {$median75[$i]+=$ydatamedian[$startmedian-$k+$i];}
       	     $median75[$i]=$median75[$i]/$k;
         } 
        
	   
	   if($type==5 || $type==6 || $type==7 || $type==8)
	  	{
		   unset($k);
	      $median13[$i]=0;


		 for($k=0;$k<13 && $startmedian-$k+$i>=0;$k++)

	       {
		    $median13[$i]+=$ydatamedian[$startmedian-$k+$i];
		   }
       	     $median13[$i]=$median13[$i]/$k;
        }

	   if($type==5 || $type==6)
	  	{
              $median26[$i]=0; 
           unset($k);
	    for($k=0;$k<26 && $startmedian-$k+$i>=0;$k++)
	       {
			 $median26[$i]+=$ydatamedian[$startmedian-$k+$i]; 
			}
		     $median26[$i]=$median26[$i]/$k;
	    }

	}// end get median



	if($type == 2)
	{
   
		unset($point);
		$point = array();

        $sql2="SELECT count(*) CountDay,date_format(date,'%Y%m') Month From draw_chart Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and volume!=0 and mid=2 Group By date_format(date,'%Y-%m') Order by date";
		$result2=$db->sql_query($sql2);
		$temp1=0;
        $i=0;
	    $num=mysql_num_rows($result2);

		while($row=mysql_fetch_array($result2)) 
		 {
           $temp1+=$row['CountDay'];
		   $point[$i]=$temp1;
		   $lmonths[$i]=$row['Month'];
		   $i++;		    
		 }

		         $counttickposition=0;
		         $countpoint=count($point); 

		     if($countpoint==1)
		     {
   				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
			        $counttickposition++;
					
					$tickPositions[$counttickposition]=$point[0]-1;
                    $months[$counttickposition]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);

			 }
          else
	      {   

		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {
			     if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4)."/".substr($lmonths[$cpoint],4,2);
				    $counttickposition++; 
				  }
				  elseif($point[$cpoint-1]>5 && $point[$countpoint-2]-3>$point[$cpoint-1] )
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],4,2);
					$counttickposition++;
				  }

			 }
           } 

	}
elseif($type == 1)
	{

	    for($ctp=0;$ctp<$numstick;$ctp++)
		{
		   $tickPositions[$ctp]=$ctp;
		   if($ctp==0 || $ctp==$numstick-1)
		   {$months[$ctp]=substr($days[$ctp],5,2)."/".substr($days[$ctp],8,2);  }
		   else $months[$ctp]=substr($days[$ctp],8,2);
		}
//print_r($days);

	}
	elseif($type == 3)
	{
	
		unset($point);
		$point = array();
        $sql2="SELECT count(*) CountDay,date_format(date,'%Y%m') Month From draw_chart Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and volume!=0 and mid=2 Group By date_format(date,'%Y-%m') Order by date";
		$result2=$db->sql_query($sql2);
		$num=mysql_num_rows($result2);
		$temp1=0;
         $i=0;
		while($row=mysql_fetch_array($result2)) 
		 {
           $temp1 +=$row['CountDay'];
		   $point[$i]=$temp1;
	       $lmonths[$i]=$row['Month'];
 	       $i++;		    
		 }
		         $counttickposition=0;
		         $countpoint=count($point); 
				 
		if($countpoint==1)
		 {
				$tickPositions[0]=0;
				$months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				$counttickposition++;
				
				$tickPositions[$counttickposition]=$point[0]-1;
				$months[$counttickposition]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);

		 }
		 else
		   {
		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {
			     if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4)."/".substr($lmonths[$cpoint],4,2);
				    $counttickposition++; 
				  }
				  elseif($point[$cpoint-1]>5 && $point[$countpoint-2]-3>$point[$cpoint-1] )
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],4,2);
					$counttickposition++;
				  }

			 }
          }

	 

	}//end if type==3
	elseif($type == 4)
	{
		unset($point);
		$point = array();
        $sql2="SELECT count(*) CountDay,date_format(date,'%Y%m') Month From draw_chart Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin'  and volume!=0 and mid=2 Group By date_format(date,'%Y-%m') Order by date";
		$result2=$db->sql_query($sql2);
		$temp1=0;
         $i=0;
		 $num=mysql_num_rows($result2);
		while($row=mysql_fetch_array($result2)) 
		 {
           $temp1+=$row['CountDay'];
		   $point[$i]=$temp1;
		    $lmonths[$i]=$row['Month'];
		   $i++;		    
		 }
		         $counttickposition=0;
		         $countpoint=count($point); 
       if($countpoint==1)
		     {
   				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
			        $counttickposition++;
					
					$tickPositions[$counttickposition]=$point[0]-1;
                    $months[$counttickposition]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);

			 }
         else
          {  
		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {
			     if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4)."/".substr($lmonths[$cpoint],4,2);
				    $counttickposition++; 
				  }
				  elseif($point[$cpoint-1]>8 && $point[$countpoint-2]-3>$point[$cpoint-1] )
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],4,2);
					$counttickposition++;
				  }

			 }
	       }



	}
	elseif($type == 5 )
	{


        unset($point);
		$point = array();//date_format(date,'%Y-%m-%d')  date <='$datemax' and date>='$datemin'
       $sql1 = "select distinct substring(date,1,6) LayNgay from draw_chart_year where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and mid=2 order by date";
        $result1=mysql_query($sql1) or die(mysql_error());
         $z=0;
  
		while($row1=mysql_fetch_array($result1) )
		{
		  $lmonths[$z]=$row1['LayNgay'];
		  $z++;
		}

	   $temp1=0;
	  for($i=0;$i<sizeof($lmonths);$i++)
		{
			//date<='$datemax' and date>='$datemin'
           $sql2="SELECT substring(date,1,6)  From draw_chart_year Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and substring(date,1,6)='$lmonths[$i]' and mid=2 ";
			$result2 = $db->sql_query($sql2) or die (mysql_error());
			$CountDay[$i] = mysql_num_rows($result2);
           $temp1+=$CountDay[$i];
		   $point[$i]=$temp1;
		}		
    
                 $counttickposition=0;
		         $countpoint=count($point); 
		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {
			     if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4)."/".substr($lmonths[$cpoint],4,2);
				    $counttickposition++; 
				  }
				  elseif($point[$cpoint-1]>5 && $cpoint%3==2 && $point[$countpoint-2]>$point[$cpoint-1])
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],4,2);
					$counttickposition++;
				  }

			 }


	}
	elseif($type == 6 )
	{


        unset($point);
		$point = array();//date<='$datemax' and date>='$datemin'
       $sql1 = "select distinct substring(date,1,6) LayNgay from draw_chart_year where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and mid=2 order by date";
        $result1=mysql_query($sql1) or die(mysql_error());
         $z=0;
  
		while($row1=mysql_fetch_array($result1) )
		{
		  $lmonths[$z]=$row1['LayNgay'];
		  $z++;
		}
	   $temp1=0;
	  for($i=0;$i<sizeof($lmonths);$i++)
		{
			//date<='$datemax' and date>='$datemin'
           $sql2="SELECT substring(date,1,6)  From draw_chart_year Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and substring(date,1,6)='$lmonths[$i]' and mid=2 ";
			$result2 = $db->sql_query($sql2) or die (mysql_error());
			$CountDay[$i] = mysql_num_rows($result2);
           $temp1+=$CountDay[$i];
		   $point[$i]=$temp1;
		}		
                 $counttickposition=0;
		         $countpoint=count($point); 
		   for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {
			     if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4)."/".substr($lmonths[0],4,2);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4)."/".substr($lmonths[$cpoint],4,2);
				    $counttickposition++; 
				  }
				  elseif($point[$cpoint-1]>5 && $cpoint%3==2 && $point[$countpoint-2]>$point[$cpoint-1])
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],4,2);
					$counttickposition++;
				  }

			 }
	}//end if type==6
	elseif($type == 7)
	{
        unset($point);

		$point = array();//date<='$datemax' and date>='$datemin'
		$sql1 = "select distinct substring(date,1,4) LayNgay from draw_chart_year_base_month where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and mid=2 order by date";
        $result1=$db->sql_query($sql1); 
         $z=0;
		while($row1=mysql_fetch_array($result1) )
		{
		  $lmonths[$z]=$row1['LayNgay'];
		  $z++;
		}
	   $num=count($lmonths); 
	   $temp1=0;
	   for($i=0;$i<$num;$i++)
		{	//date<='$datemax' and date>='$datemin'
           $sql2="SELECT substring(date,1,6)  From draw_chart_year_base_month Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and substring(date,1,4)='$lmonths[$i]' and mid=2";
			$result2 = $db->sql_query($sql2) or die (mysql_error());
			$CountDay[$i] = mysql_num_rows($result2);
           $temp1+=$CountDay[$i];
		   $point[$i]=$temp1;
		}		


                 $counttickposition=0;
		         $countpoint=count($point); 
		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {

				 if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4);
				    $counttickposition++; 
				  }
				  else if($point[$cpoint-1]>4 && $point[$countpoint-2]-3>$point[$cpoint-1])
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4);
					$counttickposition++;
				  }
		
             }


	}//end tickpos type==7
  elseif($type == 8)
	{
        unset($point);
       
		$point = array();//date<='$datemax' and date>='$datemin'
		$sql1 = "select distinct substring(date,1,4) LayNgay from draw_chart_year_base_month where   date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and mid=2 order by date";
        $result1=$db->sql_query($sql1); 
         $z=0;
		while($row1=mysql_fetch_array($result1) )
		{
		  $lmonths[$z]=$row1['LayNgay'];
		  $z++;
		}

	   $num=count($lmonths); 

	   $temp1=0;
	   for($i=0;$i<$num;$i++)
		{	//date<='$datemax' and date>='$datemin'
           $sql2="SELECT substring(date,1,6)  From draw_chart_year_base_month Where  date_format(date,'%Y-%m-%d')<='$datemax' and  date_format(date,'%Y-%m-%d')>='$datemin' and substring(date,1,4)='$lmonths[$i]' and mid=2";
			$result2 = $db->sql_query($sql2) or die (mysql_error());
			$CountDay[$i] = mysql_num_rows($result2);
           $temp1+=$CountDay[$i];
		   $point[$i]=$temp1;
		}		

                 $counttickposition=0;
		         $countpoint=count($point); 
		     for($cpoint=0;$cpoint<$countpoint;$cpoint++)
		     {

				 if($cpoint==0) 
				  {
				    $tickPositions[0]=0;
                    $months[0]=substr($lmonths[0],0,4);
				     $counttickposition++;
				  }
				  elseif($cpoint==$countpoint-1)
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4);
				    $counttickposition++; 
				  }
				  else if($point[$cpoint-1]>4 && $point[$countpoint-2]-3>$point[$cpoint-1])
				  {
				    $tickPositions[$counttickposition]=$point[$cpoint-1];
                    $months[$counttickposition]=substr($lmonths[$cpoint],0,4);
					$counttickposition++;
				  }
		
             }

	}//end tickpos type==8

    if($type==1 )
     {
     $mintmp=min($datay);
	 $maxtmp=max($datay);
     } 
	elseif ($type==2)
	   {
       $mintmp=min(min($datay),min($median25));
	   $maxtmp=max(max($datay),max($median25));
       } 
	elseif ($type==3 || $type==4)   
	   {
       $mintmp=min(min($datay),min($median25),min($median75));
	   $maxtmp=max(max($datay),max($median25),max($median75));
       } 
	elseif($type==5 || $type==6)
   	   {
       $mintmp=min(min($datay),min($median13),min($median26));
	   $maxtmp=max(max($datay),max($median13),max($median26));
       } 
	elseif($type==7 || $type==8)
	  {
       $mintmp=min(min($datay),min($median5),min($median13));
	   $maxtmp=max(max($datay),max($median5),max($median13));
	 
	  }
	
    $minscale=floor($mintmp/100)*100;
    $maxscale=ceil($maxtmp/100)*100;
	
	$graph = new Graph(660,200,"auto");	
	
	$graph->SetScale("textlin",$minscale,$maxscale);
 
	$graph->SetMarginColor('white');
	//Set vi tri cho hinh
	$graph->SetMargin(2,60,2,25);// Adjust the margin slightly so that we use the entire area (since we don't use a frame)
	// Box around plotarea
	$graph->SetBox(); 
	$graph->SetFrame(false);
	$graph->ygrid->SetLineStyle('solid');
	$graph->ygrid->SetColor('gray');
	$graph->xgrid->Show();
	//$graph->ygrid->Show(true,true);//hien luoi day dac
	$graph->xgrid->SetLineStyle('solid');
	//hien thi luoi doc	
	$graph->xgrid->SetColor('gray');
	$graph->xaxis->SetMajTickPositions($tickPositions);
	$graph->xaxis->SetTickLabels($months);// Setup month as labels on the X-axis
	$graph->xaxis->SetLabelAngle(45);


if($type==3 || $type==4)
	{
	$lplot75 = new LinePlot($median75);
	$lplot75->SetColor('salmon');
    $graph->Add($lplot75);
    }


if($type==3 || $type==2 || $type==4)
	{
	$lplot25 = new LinePlot($median25);
	$lplot25->SetColor('seagreen');
    $graph->Add($lplot25);
    }
	
 if($type==2)
  {
    $lplot = new LinePlot($median5);
    $lplot->SetColor("salmon");
	$graph->Add($lplot);
  }


if($type==5 || $type==6)
  {
   	$lplot26 = new LinePlot($median26);
	$lplot26->SetColor('salmon');
    $graph->Add($lplot26);

   	$lplot13 = new LinePlot($median13);
	$lplot13->SetColor('seagreen');
    $graph->Add($lplot13);
  }

if($type==7 || $type==8)
  {

   	$lplot13 = new LinePlot($median13);
	$lplot13->SetColor('seagreen');
    $graph->Add($lplot13);
	
	$lplot = new LinePlot($median5);
	$lplot->SetColor('salmon');
    $graph->Add($lplot);
  }


 $p1 = new StockPlot($datay);
 $p1->SetColor('blue','blue','red','red');

   if ($type==1) { $p1->SetWidth(50);}
   elseif ($type==2) {$p1->SetWidth(8);}
   elseif ($type==3 || $type==5) {$p1->SetWidth(4);}
   else {$p1->SetWidth(2);}
   

	$p1->HideEndLines();	
	$p1->SetCenter();
	$graph->Add($p1); 


	$graph->xaxis->HideLabels() ;
	$graph->xaxis->HideTicks(true,true); 
	//$graph->yaxis->SetPosAbsDelta(430) ;//430 = 500-30-40
	$graph->yaxis->SetPosAbsDelta(598) ;//430 = 500-30-40
	$graph->yaxis->SetLabelSide(SIDE_RIGHT);
	$graph->yaxis->HideTicks(true,false); 

 //set lengend
$graph->legend->SetLayout(LEGEND_HOR);
$graph->legend->Pos(0.50,0.94,"center","center");

if($type==2) $lplot->SetLegend("MA 5 DAY");
if ($type==3 || $type==4 || $type==2) $lplot25->SetLegend("MA 25 DAY");
if ($type==3 || $type==4 ) $lplot75->SetLegend("MA 75 DAY");
if ($type==5 || $type==6)
{
  $lplot13->SetLegend("MA 13 WEEK");
   $lplot26->SetLegend("MA 26 WEEK");
}

if ($type==7 || $type==8)
{
  $lplot13->SetLegend("MA 13 MONTH");
   $lplot->SetLegend("MA 5 MONTH");
}


$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('white@0.7');
$graph->legend->SetReverse();
//legend

	if ($type == 1)
	{
		$graph->Stroke($realpath.$prename."1W_1.png");
		//$graph->Stroke();

	}
	elseif ($type == 2)
	{

		$graph->Stroke($realpath.$prename."1M_1.png");
//		$graph->Stroke($realpath."1M_1.png");
	}
	elseif ($type == 3)
	{

		$graph->Stroke($realpath.$prename."3M_1.png");
	}
	elseif ($type == 4)
	{
    
		$graph->Stroke($realpath.$prename."6M_1.png");
	}
	elseif ($type == 5)
	{
		$graph->Stroke($realpath.$prename."1Y_1.png");
	}
	elseif ($type == 6)
	{
		$graph->Stroke($realpath.$prename."2Y_1.png");
	}
	elseif ($type == 7)
	{
		$graph->Stroke($realpath.$prename."5Y_1.png");
	}
	elseif ($type == 8)
	{
		$graph->Stroke($realpath.$prename."10Y_1.png");
	}

	/////////////////////////////Create Bar charts//////////////////////////////////////////////
	$graph = new Graph(660,170,"auto");	
	$graph->SetScale("textlin");
	$graph->SetMarginColor('white');
	$graph->SetMargin(2,60,5,30);// Adjust the margin slightly so that we use the  entire area (since we don't use a frame)
	$graph->SetBox(); 
	$graph->SetFrame(false);
	$graph->ygrid->SetLineStyle('solid');
	$graph->ygrid->SetColor('gray');
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('solid');
	//hien thi luoi doc
	$graph->xgrid->SetColor('gray');
	if($type != 1 )
	{
		$graph->xaxis->SetMajTickPositions($tickPositions);
	}
	$graph->yaxis->HideTicks(true,false); 
	$graph->xaxis->SetTickLabels($months);
	$graph->xaxis->SetLabelAlign('center','center'); 
	$graph->yaxis->SetPosAbsDelta(598) ;// move yaxis to right
	$graph->yaxis->SetLabelSide(SIDE_RIGHT); //set label on yaxis right align
  if($type!=1)  {$graph->xaxis->SetLabelAlign('left','center'); }

	// Create a bar pot
	$bplot = new BarPlot($ydata);//ngay 29/9
	
	 if($numstick<10)
	{
	$bplot->SetWidth(0.5);
	}
	elseif ($numstick<25) 
	  {
	  $bplot->SetWidth(0.3);
	  }
	else $bplot->SetWidth(0.5);
	
	$fcol='#440000';
	$tcol='#FF9090';
	$bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);
	$bplot->SetWeight(0);
	$graph->Add($bplot);
//echo $type." ";

	// .. and finally send it back to the browser
	if ($type == 1)
	{
		$graph->Stroke($realpath.$prename."1W_2.png");
	}
	elseif ($type == 2)
	{
		$graph->Stroke($realpath.$prename."1M_2.png");
	}
	elseif ($type == 3)
	{
		$graph->Stroke($realpath.$prename."3M_2.png");
	}
	elseif ($type == 4)
	{
		$graph->Stroke($realpath.$prename."6M_2.png");
	}
	elseif ($type == 5)
	{
		$graph->Stroke($realpath.$prename."1Y_2.png");
	}
	elseif ($type == 5)
	{
		$graph->Stroke($realpath.$prename."1Y_2.png");
	}
	elseif ($type == 6)
	{
		$graph->Stroke($realpath.$prename."2Y_2.png");
	}
	elseif ($type == 7)
	{
		$graph->Stroke($realpath.$prename."5Y_2.png");
	}
	elseif ($type == 8)
	{
		$graph->Stroke($realpath.$prename."10Y_2.png");
	}

	unset($ydata);
	unset($datay);
	unset($months);
	unset($median5);
	unset($median25);
 
    unset($lplot);
	unset($lplot25);
    unset($lplot75); 
    unset($lplot13); 
    unset($lplot26); 
    unset($lmonths); 
    unset($tickPositions); 
    unset($months);  
	unset($numstick);
	unset($limit);
	unset($median13);
	unset($median26);
  }//end process draw chart

}// end for 8 case

//echo $type;
//var_dump($tickPositions);
 $sql="SELECT chartid,cid,mid,Cur_Date FROM chartmanagement where cid='20062' and mid='$mid' and date_format(Cur_Date,'%Y-%m-%d')= date_format($date,'%Y-%m-%d')";
  $result=$db->sql_query($sql) or die(mysql_error());
 
if (!mysql_num_rows($result))
   {
  $strinsert="INSERT INTO chartmanagement (mid,cid,1Day,1Month,3Month,6Month,1Year,2Year,5Year,10Year,Cur_Date) VALUES (
   '$mid','20062','".$prename."1W_1.png,".$prename."1W_2.png'
   ,'".$prename."1M_1.png,".$prename."1M_2.png','".$prename."3M_1.png,".$prename."3M_2.png'
   ,'".$prename."6M_1.png,".$prename."6M_2.png'
   ,'".$prename."1Y_1.png,".$prename."1Y_2.png'
   ,'".$prename."2Y_1.png,".$prename."2Y_2.png'
   ,'".$prename."5Y_1.png,".$prename."5Y_2.png'
   ,'".$prename."10Y_1.png,".$prename."10Y_2.png',date_format($date,'%Y-%m-%d'))";   
    $db->sql_query($strinsert) or die(mysql_error());
   }	 
?>
