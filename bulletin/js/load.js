var page=1;
var urlParams = {};
(function () {
    var e,
        a = /\+/g,  // Regex for replacing addition symbol with a space
        r = /([^&=]+)=?([^&]*)/g,
        d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
        q = window.location.search.substring(1);
    while (e = r.exec(q)) {
       urlParams[d(e[1])] = d(e[2]);
    }
})(); 

function load(){
  $("div.spinner").removeClass("hide");
  var type=urlParams['type']==""||urlParams['type']==null?"campus":urlParams['type'];
  switch (type){
    case "campus":
      $("span#type-title").text("校園公告");
      $("li.campus").addClass("active");
      $("li.hot").removeClass("active");
      $("li.activity").removeClass("active");
      $("li.studying").removeClass("active");
      break;
    case "hot":
      $("span#type-title").text("熱門消息");
      $("li.campus").removeClass("active");
      $("li.hot").addClass("active");
      $("li.activity").removeClass("active");
      $("li.studying").removeClass("active");
      break;
    case "activity":
      $("span#type-title").text("校外訊息");
      $("li.campus").removeClass("active");
      $("li.hot").removeClass("active");
      $("li.activity").addClass("active");
      $("li.studying").removeClass("active");
      break;
    case "studying":
      $("span#type-title").text("研習活動");
      $("li.campus").removeClass("active");
      $("li.hot").removeClass("active");
      $("li.activity").removeClass("active");
      $("li.studying").addClass("active");
      break;
  }
  $.ajax({
    url: "../api/?format=json&view=list&limit=15&page="+page+"&type="+type,
    type: "GET",
    dataType: "json",
    success: function(data) {
      //alert("SUCCESS!!!");

      var NumOfJData = data.length; 


      // for (var i = 0; i < NumOfJData; i++) {
      //   console.log(data[i]["title"]);   
      //   console.log(data[i]["date"]);    
      // }

      var i = 0;
      $.each(data, function() {
        $("#board").append("<a href=\"view.html?id="+data[i].id+"\"><div class=\"list-group-item\" style=\"display:none\">"+
          "<div class=\"row-action-primary\">"+
              "<i class=\"material-icons\">description</i>"+
            "</div>"+
            "<div class=\"row-content\">"+
              "<h4 class=\"list-group-item-heading\">"+data[i].title+"</h4>"+
              "<p class=\"list-group-item-text\">"+data[i].date+"</p>"+
            "</div>"+
          "</div></a>"+
          "<div class=\"list-group-separator\"></div>");
          $("div.list-group-item:last").fadeIn(1000+100*i);
        i++;
      });
      $("div.spinner").addClass("hide");
    },
    
    error: function() {
      alert("ERROR!!!");
    }
  });
}
$(document).ready(function(){
  load();
});
$("a.load-button").click(function(){
  page++;
  load();
});
$("button#goSearch").click(function(){
  
})