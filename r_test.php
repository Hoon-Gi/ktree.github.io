<?php
    $lines = @file("test.txt") or $result = "파일을 읽을 수 없습니다.";
    
	if ($lines != null) {
        $result = '<table border="1">';
        $result .= "<tr><th>나무이름</th><th>개화시기</th><th>꽃차례</th><th>꽃 색깔</th><th>잎의 자라는 형태</th>
					<th>잎의 형태</th><th>잎의 길이</th><th>잎의 폭</th><th>겹잎</th><th>톱니</th>
					<th>갈래</th><th>열매 결실시기</th><th>열매 종류</th><th>열매 색깔</th></tr>";
		$cnt = count($lines);
        for($i = 0; $i < $cnt; $i++){
            $result .= "<tr>";
            $arr = explode(";", $lines[$i]);
            for($j = 0;$j < 14;$j++){
                $result .= "<td>{$arr[$j]}</td>";
				
				$element[$i][$j] = $arr[$j];
            }
            $result .= "</tr>";
        }
        $result .= "</table>";
    }
	
?>
<!DOCTYPE html>
<html lang="ko">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <title>search result</title>
    </head>
    <body>
        <h1>검색 결과</h1>
		<p>
			<?php 	
			$x = array();
			$x[1] = $_POST['x1'];		//개화시기
			$x[2] = $_POST['x2'];		//꽃차례
			$x[3] = $_POST['x3'];		//꽃색깔
			$x[4] = $_POST['x4'];		//잎이 자라는 형태
			//$x[5] = $_POST['x5'];		//잎의 형태
			$x[6] = $_POST['x6'];		//잎의 길이
			$x[7] = $_POST['x7'];		//잎의 폭
			//$x[8] = $_POST['x8'];		//겹잎
			//$x[9] = $_POST['x9'];		//톱니
			//$x[10] = $_POST['x10'];	//갈래
			$x[11] = $_POST['x11'];		//열매 결실 시기
			//$x[12] = $_POST['x12'];	//열매 종류
			$x[13] = $_POST['x13'];		//열매 색깔
			
			
			if(empty($x[2])) { $x[2] = " "; }
			if(empty($x[3])) { $x[3] = " "; }
			if(empty($x[4])) { $x[4] = " "; }
			if(empty($x[13])) { $x[13] = " "; }
			
			
			$list1 = array();	
		//string 구문만 조건문을 걸어서 1차적으로 list를 거름
			for($i = 0; $i < $cnt; $i++){
				if(strpos($element[$i][2],$x[2])!==false && strpos($element[$i][3],$x[3])!==false && strpos($element[$i][4],$x[4])!==false && strpos($element[$i][13],$x[13])!==false)
				{	
					array_push( $list1, $i );
				}
				//list1에 i라는 인덱스가 저장되어있는 상태
			}
			echo "1차로 걸러진 인덱스<br/>";
			for($i=0; $i<count($list1); $i++){
				echo $list1[$i]."<br/>";
			}
			echo "--------------------------<br/>";
			echo "개화시기 = ".$x[1]."<br/>";
			
		//잎의 길이로 조건문 걸어서 list2에 push
			$list2 = array();
			if(empty($x[1])){
				$list2 = $list1;
			}
			for($i = 0; $i < count($list1); $i++)
			{
				$arr1 = explode(",",$element[$list1[$i]][1]);
				$a = $arr1[0]; 		$b = $arr1[1];
				echo "a=".$a."    b=".$b."<br/>";
				//1. 앞의 값이 뒤의 값보다 클 때 ex) 12월 ~ 다음해3월
				if( $a > $b ){
					if( $x[1] >= $a || $x[1] <= $b){
						array_push( $list2, $list1[$i] );
					}
				}
				
				//2. 뒤의 값이 앞보다 같거나 클 때 ex)5월~5월, 6월~8월 , 대부분의 정상적인 경우
				else if( $a <= $b ) {
					if( $x[1] >= $a && $x[1] <= $b ){
						array_push( $list2, $list1[$i] );
					}
				}
			}
			echo "--------------------------<br/>";
			echo "개화시기로 거른 인덱스(=list2)<br/>";
			for($i=0; $i<count($list2); $i++){
				echo $list2[$i]."<br/>";
			}
			
			//잎의 폭으로 조건문 걸어서 list3에 push
			
			//...
			
			//최종 list에 push
			
			//최종 후보군 출력
			for($i=0; $i<count($list2); $i++){
				$name = $element[$list2[$i]][0];
				echo $name."<br/>";
				echo "<img src='/img/$name.png' width='100' height='100' ><br/>";
			}		
			?>
		</p>
    </body>
</html>