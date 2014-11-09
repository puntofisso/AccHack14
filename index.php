<?php
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
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">Parli-N-Grams</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
	    <li>
              <a href="about.php">About</a>
            </li>
         </ul>

          <ul class="nav navbar-nav navbar-right">
          </ul>

        </div>
      </div>
    </div>


    <div class="container fill">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-lg-9">
            <h1 class="tohide">Parli-N-Grams</h1>
            <p class="lead tohide">What did they say?</p>
		<div id="control">
		<form method="post">
		<p><a href="#" class="btn btn-default" id="addVar">+</a>
		<input id="searchsubmit" class="btn btn-default" type="submit" value="Search"></p>
		</p>
		</form>


		<script>
		//create three initial fields
		var filelistdictionary = Array();
		var startingNo = 0;
		var $node = "";
		for(varCount=0;varCount<=startingNo;varCount++){
			var displayCount = varCount+1;
			$node += '<p class="tohide"><label for="var'+displayCount+'">N-Gram '+displayCount+': </label><input type="text" value="digital" class="ngraminput parli-form-control" name="var'+displayCount+'" id="var'+displayCount+'"></input>&nbsp;<a href="#" class="btn btn-default" id="removeVar">-</a></p>';
		}

$('form').prepend($node);

$('form').on('click', '#removeVar', function(event){
		event.preventDefault();
		$(this).parent().remove();

		});

$('#addVar').on('click', function(event){
		event.preventDefault();
		varCount++;
		$node = '<p class="tohide"><label for="var'+varCount+'">N-Gram '+varCount+': </label><input type="text" class="ngraminput parli-form-control" name="var'+varCount+'" id="var'+varCount+'"></input>&nbsp;<a href="#" class="btn btn-default" id="removeVar">-</a></p>';
		$(this).parent().before($node);
		});

// intercept click on submit
$('#searchsubmit').click(function(event){
		event.preventDefault();
	      		$('#searchterm').empty();
		$('#debateslist').empty();
		generateChart(false);
		});

</script>
</div>
<div id="chart" >
<svg id="chartsvg"></svg>
</div>
</div>
<div class="col-lg-3">
<div id="debates">
<span id="searchterm"></span>
<div id="debateslist"></div>
</div>

<script>
function generateChart(onboot) {
$("#chartsvg").empty();
var searchNgram = "";
/*These lines are all chart setup.  Pick and choose which chart features you want to utilize. */
nv.addGraph(function() {
var chart = nv.models.lineChart()
                .margin({left: 100})  //Adjust chart margins to give the x-axis some breathing room.
                .useInteractiveGuideline(true)  //We want nice looking tooltips and a guideline!
                .transitionDuration(350)  //how fast do you want the lines to transition?
                .showLegend(true)       //Show the legend, allowing users to turn on/off line series.
                .showYAxis(true)        //Show the y-axis
                .showXAxis(true)        //Show the x-axis
  ;

  chart.xAxis
      .axisLabel('Year');

  chart.yAxis
      .axisLabel('Mentions');

  var myData = extractData();
  d3.select('#chart svg')
      .datum(myData)
      .call(chart)
.style({ 'width': 800, 'height':400 });

 d3.selectAll("g.nv-line")
    .on("click.mine", function(dataset){


      var singlePoint, pointIndex, pointXLocation, allData = [];
      var lines = chart.lines;

      var xScale = chart.xAxis.scale();
      var yScale = chart.yAxis.scale();
      var mouseCoords = d3.mouse(this);
      var pointXValue = xScale.invert(mouseCoords[0]);

   dataset
          .filter(function(series, i) {
            series.seriesIndex = i;
            return !series.disabled;
          })
          .forEach(function(series,i) {
              pointIndex = nv.interactiveBisect(series.values, pointXValue, lines.x());
              lines.highlightPoint(i, pointIndex, true);

              var point = series.values[pointIndex];

              if (typeof point === 'undefined') return;
              if (typeof singlePoint === 'undefined') singlePoint = point;
              if (typeof pointXLocation === 'undefined')
                pointXLocation = xScale(lines.x()(point,pointIndex));

              allData.push({
                  key: series.key,
                  value: lines.y()(point, pointIndex),
                  color: lines.color()(series,series.seriesIndex)
              });
          });
      /*
      Returns the index in the array "values" that is searchNgram to searchVal.
      Only returns an index if searchVal is within some "threshold".
      Otherwise, returns null.
      */
      nv.nearestValueIndex = function (values, searchVal, threshold) {
            "use strict";
            var yDistMax = Infinity, indexToHighlight = null;
            values.forEach(function(d,i) {
               var delta = Math.abs(searchVal - d);
               if ( delta <= yDistMax && delta < threshold) {
                  yDistMax = delta;
                  indexToHighlight = i;
               }
            });
            return indexToHighlight;
      };

    //Determine which line the mouse is closest to.
      var yValue = yScale.invert( mouseCoords[1] );
      var domainExtent = Math.abs(yScale.domain()[0] - yScale.domain()[1]);
      var threshold = 0.03 * domainExtent;
      var indexToHighlight = nv.nearestValueIndex(
          allData.map(function(d){ return d.value}), yValue, threshold
       );
      if (indexToHighlight !== null) {
        allData[indexToHighlight].highlight = true;
        searchNgram = allData[indexToHighlight];
        }
        var term = searchNgram['key'];
        var year = Math.round(pointXValue);
	
	$('#searchterm').empty();
        $('#searchterm').append("Debates for <b>"+searchNgram['key']+"</b> in "+year);
        showDebatesList(term,year);



});

  nv.utils.windowResize(function() { chart.update() });
  if (!onboot) {
	$('.tohide').empty();
	        $('.tohide').remove();
  }
  return chart;
});
}// Data extraction
function extractData() {
        var returnArray = new Array();
        var ngramsArray = new Array();
        $('.ngraminput').each(function(i,obj) {
                var value = "#"+obj['id'];
                var y = $(value).val();
                ngramsArray.push(y);
        });
        var ngrams = ngramsArray;

        if (ngrams.length==0) {
                alert("You need to enter at least one search term");
                return;
        }
        var colourArray = ['#ff0000','#00ff00','#0000ff','#ff00ff','#00ffff','#ffff00'];
        var colourIndex = 0;
        ngrams.forEach(function(entry) {
                if ((entry=='') || (typeof entry == 'undefined')) return;
                var countArray = [];
                var fileListArray = [];

                $.ajax({

                        url: 'mysql.php',
                        data: "ngram="+entry,
                        dataType: 'json',
                        async: false,
                        success: function(data)
                        {
                                for (var i=1935; i<=2014; i++) {
                                        var thisobj = data[i];
                                        if ((thisobj == '') || (typeof thisobj == 'undefined')) {
                                                countArray.push({x: i, y:0});
                                                fileListArray[i] = null;
                                        } else {
                                                countArray.push({x: i, y:parseInt(thisobj['count'])});
                                                fileListArray[i] = thisobj['filelist'];

                                        }
                                }
                                filelistdictionary[entry] = fileListArray;
                        }
                });


                returnArray.push({values: countArray, key: entry, color: colourArray[colourIndex]});
                colourIndex++;

        });



return returnArray;

}
function showDebatesList(ngram,year) {
        $('#debateslist').empty();
        var filelist = filelistdictionary[ngram][year];
	
        var filearr = filelist.split(';');
        var newHTML = [];
        $.each(filearr, function(index, value) {
	    var url = value.split("/");
	    if ((url[4] == 'undefined') || (typeof url[4] === "undefined")) return;
	    var dateval = url[4].replace('debates','').replace('.xml','');
            newHTML.push('<a href="showDebate.php?filename='+ url[4] + '">' + dateval + '</a><br/>');
        });

        $('#debateslist').append(newHTML);
}

function getDebate(ngram,year,id) {
        var filename = "debates2014-04-08b.xml";
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


generateChart(true);

</script>
          </div>
                 </div>
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


    </div>


    <script src="boot/jquery-1.10.2.min.js"></script>
    <script src="boot/dist/js/bootstrap.min.js"></script>
    <script src="boot/bootswatch.js"></script>
  

</body></html>
<?php
?>
