// view-load.js
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
  var id=urlParams['id'];
  $.ajax({
    url: "../api/?format=json&view=content&id="+id,
    type: "GET",
    dataType: "json",
    success: function(data) {
    	
      //alert("SUCCESS!!!");

      $("a#open").attr("href",data["url"]);
      $("span.article-title").html(data["title"]);
      //$("button.bulletin-info").attr('data-content',"類型："+data["type"]+"發佈日期："+data["date"]+"發佈單位："+data["unit"])
      var content=data["content"].replace(/#__semicolon__#/ig,";");
      $("div.article-content").html(content);
	  var NumOfJData = data["file"].length;
      for (var i = 0; i < NumOfJData; i++) {
        var link=$("<a class=\"btn btn-raised btn-success\"></a>").text(data["file"][i]["filename"]).attr('href',data["file"][i]["url"]).append("<i class=\"material-icons\">file_download</i>"); 
        $("div.download-list").append(link);
        
      }
      $("div.spinner").addClass("hide");
    },
    error: function(xhr, ajaxOptions, thrownError){
		 alert(xhr.status); 
         alert(thrownError);

		}
  });
}
$(document).ready(function(){
  load();
});