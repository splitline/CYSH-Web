<?php
session_start();
?>
<?php
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
        $pwd=$_SESSION['pwd'];
    }else{
        $_SESSION['id']=$id=$_POST['id'];
        $_SESSION['pwd']=$pwd=$_POST['pwd'];
    }
    function setUrlCookie($url, $postdata){
        $cookie_jar = tempnam('./tmp','cookie'); // Create file with unique file name (cookie*)
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_POST, 1);
        curl_setopt($resource, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($resource, CURLOPT_COOKIEFILE, $cookie_jar);
        curl_setopt($resource, CURLOPT_COOKIEJAR, $cookie_jar);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($resource);
        return $resource;
    }

    function getUrlContent($resource, $url){
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($resource);

        return $content;
    }


    $url = 'http://163.27.3.19/school/Login.asp';
    $postdata = "txtID=$id&txtPWD=$pwd&Chk=Y";
    $resource = setUrlCookie($url, $postdata); // set cookie 'u' => 'admin' or anything

    $url = 'http://163.27.3.19/school/STD_SCORE.asp';
    $html= getUrlContent($resource, $url); // Login success.
    
//==========================================================================================//

    include('simple_html_dom.php');
    class subject {
        public $name;
        public $exam1;
        public $exam2;
        public $exam3;
    }
    $html =  str_get_html($html);
    // echo $html;
    $table = $html->find('table', 3);
    //echo $table;
    $subject_count=substr_count($table,"<tr>")-3;
    $i=$j=0;
    foreach($table->find('tr') as $tr){
       $j=0;
       foreach($tr->find('td') as $td){
            //echo $td.$i." ".$j."<br>";
            $subjects[$subject_count]=new subject;
            if($j==0)
                @$subjects[$i]->name=$td->plaintext;
            if($j==1)
                @$subjects[$i]->exam1=$td->plaintext;
            if($j==2)
                @$subjects[$i]->exam2=$td->plaintext;
            if($j==3)
                @$subjects[$i]->exam3=$td->plaintext;
            $j++;
       }
       $i++;
    }
?>
<!DOCTYPE html>
<html lang="zh-tw" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>嘉中簡化版成績查詢系統</title>
        <link rel="stylesheet" href="css/uikit.gradient.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="Chart.min.js"></script>
    </head>

    <body>
        <nav class="uk-navbar uk-margin-large-bottom uk-navbar-attached">
            <div class="uk-container uk-container-center" >
                <a class="uk-navbar-brand uk-hidden-small" href="#">CYSH-Score</a>
                <ul class="uk-navbar-nav uk-hidden-small">
                    <li class="uk-active">
                        <a href="score.php">Home</a>
                    </li>
                    <li><a href="about.php">About</a></li>
                </ul>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">CYSH-Score</div>
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav uk-hidden-small">
                        <li class="uk-parent" data-uk-dropdown="" aria-haspopup="true" aria-expanded="false">
                            <a href=""><i class="uk-icon-user"></i><?php echo @$name; ?><i class="uk-icon-caret-down"></i></a>
                            <div class="uk-dropdown uk-dropdown-flip uk-dropdown-navbar">
                                <ul class="uk-nav uk-nav-navbar">
                                    <li><a href="#">Profile</a></li>
                                    <li class="uk-nav-divider"></li>
                                    <li><a href="#">Log Out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
        </nav>
    
        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                    <div>
                        <h1>嘉中簡化版成績查詢系統</h1>
                        <div class="uk-grid">
                        <div class="uk-width-medium-1-3">
                            <ul data-uk-switcher="{connect:'#switcher-content-a-fade', animation: 'fade'}" class="uk-tab">
                                <li id="exam1"><a href="#">第一次段考</a></li>
                                <li id="exam2"><a href="#">第二次段考</a></li>
                                <li id="exam3"><a href="#">期末考</a></li>
                                <li id="total"><a href="#">總成績</a></li>
                            </ul>
                            <ul class="uk-switcher uk-margin" id="switcher-content-a-fade">
                                <li>
                                    <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                                        <thead>
                                            <tr>
                                                <th>科目</th>
                                                <th>成績</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($I=2;$I<$subject_count;$I++){
                                                    echo "<tr>";
                                                    echo "<td>".@$subjects[$I]->name."</td>";
                                                    echo "<td>".@$subjects[$I]->exam1."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam2."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam3."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                </li>
                                <li>
                                    <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                                        <thead>
                                            <tr>
                                                <th>科目</th>
                                                <th>成績</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($I=2;$I<$subject_count;$I++){
                                                    echo "<tr>";
                                                    echo "<td>".@$subjects[$I]->name."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam1."</td>";
                                                    echo "<td>".@$subjects[$I]->exam2."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam3."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                                        <thead>
                                            <tr>
                                                <th>科目</th>
                                                <th>成績</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($I=2;$I<$subject_count;$I++){
                                                    echo "<tr>";
                                                    echo "<td>".@$subjects[$I]->name."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam1."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam2."</td>";
                                                    echo "<td>".@$subjects[$I]->exam3."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                                        <thead>
                                            <tr>
                                                <th>科目</th>
                                                <th>平時</th>
                                                <th>補考</th>
                                                <th>重修</th>
                                                <th>學期</th>
                                                <th>調整後</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                /*for($I=2;$I<$subject_count;$I++){
                                                    echo "<tr>";
                                                    echo "<td>".@$subjects[$I]->name."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam1."</td>";
                                                    //echo "<td>".@$subjects[$I]->exam2."</td>";
                                                    echo "<td>".@$subjects[$I]->exam3."</td>";
                                                    echo "</tr>";
                                                }*/
                                            ?>
                                        </tbody>
                                    </table>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-width-medium-2-3">
                        <hr>
                            <canvas id="canvas" height="200px"></canvas>
                        </div>
                        </div>
                        <script>
                        var barChartData1 = {
                            labels : [<?php
                                for($I=2;$I<$subject_count;$I++){
                                    echo '"'.str_replace("&nbsp;","", $subjects[$I]->name).'"';
                                    if($I!=$subject_count-1)
                                        echo',';
                                }
                            ?>],
                            datasets : [
                                {
                                    fillColor : "rgba(151,187,205,0.5)",
                                    strokeColor : "rgba(151,187,205,0.8)",
                                    highlightFill : "rgba(151,187,205,0.75)",
                                    highlightStroke : "rgba(151,187,205,1)",
                                    data : [<?php
                                        for($I=2;$I<$subject_count;$I++){
                                            echo '"'.str_replace("&nbsp;","", $subjects[$I]->exam1).'"';
                                            if($I!=$subject_count-1)
                                                echo',';
                                        }
                                    ?>]
                                }
                            ]

                        }
                        var barChartData2 = {
                            labels : [<?php
                                for($I=2;$I<$subject_count;$I++){
                                    echo '"'.str_replace("&nbsp;","", $subjects[$I]->name).'"';
                                    if($I!=$subject_count-1)
                                        echo',';
                                }
                            ?>],
                            datasets : [
                                {
                                    fillColor : "rgba(151,187,205,0.5)",
                                    strokeColor : "rgba(151,187,205,0.8)",
                                    highlightFill : "rgba(151,187,205,0.75)",
                                    highlightStroke : "rgba(151,187,205,1)",
                                    data : [<?php
                                        for($I=2;$I<$subject_count;$I++){
                                            echo '"'.str_replace("&nbsp;","", $subjects[$I]->exam2).'"';
                                            if($I!=$subject_count-1)
                                                echo',';
                                        }
                                    ?>]
                                }
                            ]

                        }
                        var barChartData3 = {
                            labels : [<?php
                                for($I=2;$I<$subject_count;$I++){
                                    echo '"'.str_replace("&nbsp;","", $subjects[$I]->name).'"';
                                    if($I!=$subject_count-1)
                                        echo',';
                                }
                            ?>],
                            datasets : [
                                {
                                    fillColor : "rgba(151,187,205,0.5)",
                                    strokeColor : "rgba(151,187,205,0.8)",
                                    highlightFill : "rgba(151,187,205,0.75)",
                                    highlightStroke : "rgba(151,187,205,1)",
                                    data : [<?php
                                        for($I=2;$I<$subject_count;$I++){
                                            echo '"'.str_replace("&nbsp;","", $subjects[$I]->exam3).'"';
                                            if($I!=$subject_count-1)
                                                echo',';
                                        }
                                    ?>]
                                }
                            ]

                        }
                        window.onload = function(){
                            var ctx = document.getElementById("canvas").getContext("2d");
                            new Chart(ctx).Bar(barChartData1, {
                                responsive : true
                            });
                        }
                        $("#exam1").click(function(){
                            var ctx = document.getElementById("canvas").getContext("2d");
                            new Chart(ctx).Bar(barChartData1, {
                                responsive : true
                            });
                        });
                        $("#exam2").click(function(){
                            var ctx = document.getElementById("canvas").getContext("2d");
                            new Chart(ctx).Bar(barChartData2, {
                                responsive : true
                            });
                        });
                        $("#exam3").click(function(){
                            var ctx = document.getElementById("canvas").getContext("2d");
                            new Chart(ctx).Bar(barChartData3, {
                                responsive : true
                            });
                        });
                        </script>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
