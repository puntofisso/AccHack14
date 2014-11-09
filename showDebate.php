<?php
$filename=$_GET['filename'];
?>
<!DOCTYPE html>
<!-- saved from url=(0032)http://bootswatch.com/superhero/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Parli-N-Grams</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="boot/bootstrap.css" media="screen">
    <link rel="stylesheet" href="boot/bootswatch.min.css">
    <link rel="stylesheet" href="parligram.css">
 <link rel="stylesheet" type="text/css" href="nv.d3.css">
<script src="d3.min.js" charset="utf-8"></script>
<script src="nv.d3.min.js" charset="utf-8"></script>
<script src="jquery-2.1.1.min.js" charset="utf-8"></script>
   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="../bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
    <!--script type="text/javascript" async="" src="./Bootswatch  Superhero_files/ga.js"></script><script>

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script-->
  </head>
  <body>

    <div class="container fill">
        <div class="row">
          <div class="col-lg-12">
	<div id="debateslist"></div>
<script>
function getDebate(filename) {
        $('#searchterm').text("Debate "+ filename);

        // Load debate and add to list
        $.ajax({
                        url: 'debate.php',
                        data: "filename="+filename,
                        dataType: 'text',
                        async: false,
                        success: function(data)
                        {
                        $('#debateslist').empty();
                        $('#debateslist').append(data);
                       }
                });

}
var filename="<?php echo $_GET['filename'];?>";
getDebate(filename);

</script>
                 </div>


      <footer>
        <div class="row">
          <div class="col-lg-12">

            <ul class="list-unstyled">
              <li><a href="about.php">About</a></li>
            </ul>
            <p>Made by <a href="http://puntofisso.net/" rel="nofollow">Giuseppe Sollazzo</a>.</p>
            <p>Code released on <a href="https://github.com/puntofisso/AccHack14">GitHub</a>.</p>
            <p>UI based on <a href="http://bootswatch.com">Bootswatch<a>, <a href="http://getbootstrap.com/" rel="nofollow">Bootstrap</a>. Icons from <a href="http://fortawesome.github.io/Font-Awesome/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="http://www.google.com/webfonts" rel="nofollow">Google</a>.</p>

          </div>
        </div>

      </footer>




    <script src="boot/jquery-1.10.2.min.js"></script>
    <script src="boot/dist/js/bootstrap.min.js"></script>
    <script src="boot/bootswatch.js"></script>
  

</body></html>
<?php
?>
