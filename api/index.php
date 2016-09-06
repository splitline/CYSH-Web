<?php
header('Content-Type: application/json; charset=utf-8');
include('../simple_html_dom.php');
@$format=isset($_GET['format'])?strtolower($_GET['format']):'json';
/*
http://www.cysh.cy.edu.tw/bulletin.do?unitId=183&unitID=183&pageID=3037&vRetStr=;;;;20;;;;;;;;;;;;;!00000;;;;;;;;;;100;;;;;;&typeId=88&opr=more&meth=bulletin/morePage&page=1
*/
@$view=$_GET['view'];
if($format=='json'){
	
	header('Content-Type: application/json; charset=utf-8');
	// 示範如何讀取HTML元素
	if($view=='list'){
		$type=isset($_GET['type'])?$_GET['type']:'campus';	//hot,campus,activity
		$limit=isset($_GET['limit'])?$_GET['limit']:20;
		$page=isset($_GET['page'])?$_GET['page']:1;
		if($type=="hot")
			$type_id=89;
		else if($type=="campus")
			$type_id=88;
		else if($type=="activity")
			$type_id=90;
		else if($type=="studying")
			$type_id=111;
		$html = file_get_html('http://www.cysh.cy.edu.tw/bulletin.do?unitId=183&unitID=183&pageID=3037&vRetStr=;;;;'.$limit.';;;;;;;;;;;;;!000000;;;;;;;;;;100;;;;;;&typeId='.$type_id.'&opr=more&meth=bulletin/morePage&page='.$page);
		//echo $html;
		$count=0;
		echo "[";
		foreach($html->find('a[tabindex=101]') as $a){
			$count++;
			if($count<=$limit){
				//echo $a->href ."\n";
				preg_match("/bulletin\.do\?opr\=info&vRetStr\=;;;;.*;;;;;;;;;;;;;!000000;;;;;;;;;;100;;;;;;&id\=(\d{4,5})&typeId\=.*&unitId\=(\d{3})&unitID\=(\d{3})&pageID\=3037&backFrom\=more&unitName\=.*&_M_\=null/",$a->href,$match);
							//bulletin.do?opr=info&vRetStr=;;;;20;;;;;;;;;;;;;!000000;;;;;;;;;;100;;;;;;&id=10652&typeId=88&unitId=192&unitID=183&pageID=3037&backFrom=more&unitName=學務處訓育組&_M_=null
				//echo $count.':'.@$match[1].','.@$match[2]."\n";
				$id[$count-1]=@$match[1];
				//$unit_id[$count-1]=@$match[2];
			}
		}
		//print_r($id);
		$count=0;
		// echo $html;
		foreach($html->find('font[color=#000000]') as $element){
			//echo $element.'\n';
			if($count%3==0&&$count==0)
				echo "{\n\t";
			if($count%3==0&&$count!=0)
				echo ",{\n\t";
			//echo $count;
			if($count%3==0)
				echo "\"id\":".$id[(int)$count++/3].",\n";//echo "\"id\":".$id[(int)$count/5].",\n\t\"unit_id\":".$unit_id[(int)$count/5].",\n";
			
			// if($count%5==1)echo "\t\"title\":\"";
			// if($count%5==2)echo "\t\"unit\":\"";
			// if($count%5==3)echo "\t\"date\":\"";
			// if($count%5==4)echo "\t\"click_rate\":";
			if($count%3==1)echo "\t\"title\":\"";
			if($count%3==2)echo "\t\"date\":\"";
			
			
			echo trim($element->plaintext);
			// if($count%5!=4)echo "\"";
			// if($count%5==4&&$count+1!=$limit*5)
			// 	echo "\n}\n";
			// if($count%5!=4)
			// 	echo ",\n";
			// if($count+1==$limit*5)
			// 	echo "\n}\n";
			echo "\"";
			if($count%3==2&&$count+1!=$limit*3)
				echo "\n}\n";
			if($count%3!=2)
				echo ",\n";
			if($count+1==$limit*3)
				echo "\n}\n";
			$count++;
			
		}
		echo "]";
	}
	else if ($view=='content') {
		if(isset($_GET['id']))
			$id=$_GET['id'];
		else
			die('錯誤：公告內容id未指定');
		$unit_id=isset($_GET['unit_id'])?$_GET['unit_id']:183;
		$text=isset($_GET['text'])?$_GET['text']:'origin';	//origin,plain
		$html=file_get_html('http://www.cysh.cy.edu.tw/bulletin.do?opr=info&unitID='.$unit_id.'&pageID=3037&id='.$id);
		
		echo "{\n";
		echo "\t\"url\":\"".'http://www.cysh.cy.edu.tw/bulletin.do?opr=info&unitID='.$unit_id.'&pageID=3037&id='.$id."\",\n";
		echo "\t\"title\":\"".@$html->find('font[style=font-size:small]', 0)->innertext."\",\n";
		echo "\t\"type\":\"".substr(@$html->find('font[color=#000000]', 1)->innertext,9,12)."\",\n";
		
		echo "\t\"date\":\"".substr(@$html->find('font[color=#000000]', 4)->innertext,9)."\",\n";
		echo "\t\"unit\":\"".substr(@$html->find('font[color=#000000]', 5)->innertext,12)."\",\n";
		if($text=='origin')
			echo "\t\"content\":\"".str_replace("'","\"",str_replace(";", "#__semicolon__#", addslashes(@$html->find('font[color=#000000]', 6)->innertext))) ."\",\n";
		if($text=='plain')
			echo "\t\"content\":\"".addslashes(@$html->find('td[valign="top"]', 1)->plaintext)."\"\n";
		echo "\t\"file\":[";
		$file_html=@$html->find('table[bgcolor=#CCCCCC]',0);
		$i=0;
		if(isset($file_html)){
		foreach(@$file_html->find('a') as $element){
			if($i!=0)echo ",{";
			else echo "{";
			echo "\"filename\":\"".str_replace("'","\"",str_replace(";", "#__semicolon__#",addslashes($element->innertext)))."\",\"url\":\""."http://www.cysh.cy.edu.tw/".$element->href."\"}";
			$i++;
		}
	}
		echo "]\n}";
	}

	
	
}
else if($format=='xml'){

	header('Content-type: text/xml; charset=utf-8');
}
else{
	header("Content-Type:text/plain; charset=utf-8");
	echo '錯誤:"format"參數格式有誤';
}
?>
