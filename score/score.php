<?php
    session_start();
    include('fetch.php');
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
        <script src="js/Chart.min.js"></script>
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
                                    <li><a href="./?log_out">Log Out</a></li>
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
                        var ctx = document.getElementById("canvas").getContext("2d");
                        window.onload = function(){
                            new Chart(ctx).Bar(barChartData1, {
                                responsive : true,
                            });
                        }
                        $("#exam1").click(function(){
                            new Chart(ctx).Bar(barChartData1, {
                                responsive : true
                            });
                        });
                        $("#exam2").click(function(){
                            new Chart(ctx).Bar(barChartData2, {
                                responsive : true
                            });
                        });
                        $("#exam3").click(function(){
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
