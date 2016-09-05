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
      //var NumOfJData = data.length; 
      // for (var i = 0; i < NumOfJData; i++) {
      //   console.log(data[i]["title"]);   
      //   console.log(data[i]["date"]);    
      // }
      $("a#open").attr("href",data["url"]);
      $("h3.panel-title").text(data["title"]);
      var content=data["content"].replace(/#__semicolon__#/ig,";");
      $("div.panel-body").html(content);
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