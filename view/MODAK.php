<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.getScript demo</title>
  <style>
  .block {
     background-color: blue;
     width: 150px;
     height: 70px;
     margin: 10px;
  }
  </style>
  <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
</head>
<body>
 
<button id="go">&raquo; Run</button>
<div class="block"></div>
 
<script>
var url = "http://localhost:84/proyecto_produccion/assets/js/color.js";
$.getScript( url, function() {
  $( "#go" ).click(function() {
    $( ".block" )
      .animate({backgroundColor: "rgb(255, 180, 180)"}, 1000 )
      .delay( 500 ).animate({backgroundColor: "olive"}, 1000 )
      .delay( 500 )
      .animate({backgroundColor: "#00f"}, 1000 );
  });
});
</script>
 
</body>
</html>