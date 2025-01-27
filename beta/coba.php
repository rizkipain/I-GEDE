<!doctype html>
<html>
  <head>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
  </head>
  <body>
    <h1>Take screenshot of webpage with html2canvas</h1>
    <div class="container" id='container' >
      <img src='images/image1.jpg' width='100' height='100'>
      <img src='images/image2.jpg' width='100' height='100'>
      <img src='images/image3.jpg' width='100' height='100'>
    </div><br/>
    <input type='button' id='but_screenshot' value='Take screenshot' onclick='screenshot();'><br/>
    
    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type='text/javascript'>
    function screenshot(){
       html2canvas(document.body).then(function(canvas) {

         document.body.appendChild(canvas);

         // Get base64URL
         var base64URL = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');

         // AJAX request
         $.ajax({
            url: 'ajaxfile.php',
            type: 'post',
            data: {image: base64URL},
            success: function(data){
               console.log('Upload successfully');
            }
         });
       });
     }
     </script>
  </body>
</html>