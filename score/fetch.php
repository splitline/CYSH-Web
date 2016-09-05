<?php
//================Get HTML(use curl)================//
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
        $pwd=$_SESSION['pwd'];
    }else{
        $id=$_POST['id'];
        $pwd=$_POST['pwd'];
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
    $resource = setUrlCookie($url, $postdata); 
    $url = 'http://163.27.3.19/school/STD_SCORE.asp';
    $html= getUrlContent($resource, $url); 
    //echo iconv("UTF-8","BIG5", $html);
    if(iconv("BIG5","UTF-8", $html)=="無權使用 請登入"){
        //echo 'Login Error';
        header("location:./?login_error");
    }
    else if(!isset($_SESSION['id'])){
        $_SESSION['id']=$id;
        $_SESSION['pwd']=$pwd;
    }

//================Start parse================//
    include('../simple_html_dom.php');
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
