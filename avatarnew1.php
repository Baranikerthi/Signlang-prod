<!DOCTYPE html>
<html>
<head>
<?php 
  require_once("include.php"); 
?>
<title>ISL Text to Sign</title>
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<meta http-equiv="Access-Control-Allow-Methods" content="GET">
<link rel="stylesheet" href="css/cwasa.css">
<script type="text/javascript" src="avatar_files/allcsa.js"></script>
<script src="https://kit.fontawesome.com/a74d0f3882.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript">

  var TUavatarLoaded = false;
  var avatarbusy = false;
  function weblog(line)
  {
      weblogid = document.getElementById("debugger");
      weblogid.innerHTML=line+"<br>"+weblogid.innerHTML;
  }
</script>
</head>
<body onload="CWASA.init();">
<?php
  /*Page navigation menu*/
  include_once("nav.php");
?>
<div class="container" id="loading">
  <div class="row">
    <div class="col-md-12 text-center">
      <span style="background-color:#ebf8a4; padding: 8px 20px;">
      <i class="fa fa-spinner fa-spin"></i> Loading application. Please wait...</span>
    </div>
  </div>
</div>

<div class="container" id="avatar_wrapper" style="display:none;">
  <div class="row">
    <div class="col-md-6">
        <!-- <h1 id="hellomsg" style="font-weight:bold;">Hello ! I am your ISL avatar.</h1> -->
          <div id="leftSide" style="display:none;">

            <div class="speechIn">
              <h4 class="instruction"> Enter text below or Start Recording</h4>
              <button class="mic-button" id="mic-button">
                <i class="fas fa-microphone" id="mic-icon"></i>
              </button>
            </div>
            <div id="menu1">
            <textarea id="engtext" class="form-control" style="width:100%; height:80px;"><?php

            if(isset($_GET['mode']) && isset($_GET['gloss'])) {
              echo $_GET['gloss'];
            }

            ?></textarea><br>
            <button type="button" id="playeng" class="btn btn-primary">Play</button>
            <button type="button" id="btnClearEng" class="btn btn-default">Clear</button>

            </div>
            <!-- <div id="menu2">
            <br>
            <label for="transliterateTextarea">Type text to convert to hindi:</label><br>
            <textarea class="form-control" id="transliterateTextarea" name="transliterateTextarea" style="width:100%; height:80px;"></textarea><br>
            <textarea id="hinditext" class="form-control" style="width:100%; height:80px; display:none;"></textarea>
            <button type="button" id="playhindi" class="btn btn-primary" disabled>Play</button>
            <button type="button" id="btnClearHindi" class="btn btn-default">Clear</button>
            </div>

            <div id="menu3" style="max-height:250px; overflow-y:scroll;">
              <br>
              <label>Example Sentences</label> -->
            
              <!-- >> example.php include -->
            <!-- </div> -->


            <div id="showdebugger" style="position:fixed; left:0px; top:50%; display:none;">
              <button id="btnshowdebugger" alt="Show Debugger" title="Show Debugger" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-cog"></i></button>
            </div>

            <br><br>
            <div id="debugpane">
            <label>Debugger:</label>
            <button type="button" id="clrDebugger" style="float:right;" class="btn btn-sm btn-small">Clear Debugger</button>
            <button type="button" id="hideDebugger" style="float:right;margin-right:10px;" class="btn btn-sm btn-danger">Hide Debugger</button>
            <div style="clear:both;"></div>
            <div id="debugger"></div>
            </div>
          


          </div><!--left side multi menu pane ends here-->

    </div>

    <div class="col-md-6">
      <div class="CWASAPanel av0" align="center">
        <div class="divAv av0">
          <canvas class="canvasAv av0" ondragstart="return false" width="374" height="403"></canvas>
        </div> 
      </div>
      <div id="currentWord" class="alert alert-warning"></div>
    </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/speechToText.js"></script>
<!-- <script src="js/hindiconvert.js"></script> -->
<script>
  
/*
  Hide debugger
*/
$("#hideDebugger").click(function() {
    $("#debugpane").hide();
    $("#showdebugger").show();
    $("#menu3").css("max-height","420px");
});

$("#btnshowdebugger").click(function() {
    $("#debugpane").show();
    $("#showdebugger").hide();
    $("#menu3").css("max-height","250px");
});

// /*
// Monitor hindi text area
// */
// $("#hinditext").on('keypress', function(e) {
//     var code = e.keyCode || e.which;
//     if(code==32){ // space has been pressed
//         hinditext = $("#hinditext").val();
//         converttohindi(hinditext);        
//     }
// });

/*
  Global SigmlData is a 
  javascript object
*/
var SigmlData;
var lookup = {};

$(document).ready(function() {

  var loadingTout = setInterval(function() {
      if(TUavatarLoaded) {
        clearInterval(loadingTout);
        console.log("MSG: Avatar loaded successfully !");

        setTimeout(function() {
          /*
            When the avatar has loaded
            the loading message is hidden and main wrapper is shown
          */
          $("#loading").hide();
          $(".divCtrlPanel").hide();
          $("#avatar_wrapper").show();

          /*
            As the avatar is shown a hello test is started
            in order to load all the avatar playing dependencies
          */
          console.log("MSG: Starting hello test.");
          $("#currentWord").text("Hello");
          $(".txtaSiGMLText").val('<sigml><hns_sign gloss="hello"><hamnosys_nonmanual><hnm_mouthpicture picture="hVlU"/></hamnosys_nonmanual><hamnosys_manual><hamflathand/><hamthumboutmod/><hambetween/><hamfinger2345/><hamextfingeru/><hampalmd/><hamshouldertop/><hamlrat/><hamarmextended/><hamswinging/><hamrepeatfromstart/></hamnosys_manual></hns_sign></sigml>');
          $(".bttnPlaySiGMLText").click();
          console.log("MSG: Ending hello test");
      
          /*
            After the hello has been played the main control 
            panel is displayed      
          */
          setTimeout(function() {
            $("#hellomsg").hide();
            $("#leftSide").slideDown();
          }, 10000);
    
        }, 6000);
      }
  }, 2000);

  // keep loading things here
  // load all sigml files into cache

  $.getJSON( "SignFiles/signdump.php", function( data ) {
    SigmlData = data;

    // make the lookup table
    for (i = 0, len = SigmlData.length; i < len; i++) {
        lookup[SigmlData[i].w] = SigmlData[i].s;
    }
  });

  console.log('Document Ready');
  document.getElementById('btn').removeAttribute("disabled");

});  


// clear button code
$("#btnClearEng").click(function(){
    $("#engtext").val("");
});
$("#btnClearHindi").click(function(){
    $("#transliterateTextarea").val("");
});
$("#clrDebugger").click(function(){
    $("#debugger").html("");
});
/*
  Code for the avatar player goes here
*/

/*
  When play english button is clicked
*/
$("#playeng").click(function() {

  console.log("Started parsing");

  input = $("#engtext").val().trim().replace(/\r?\n/g, ' '); // change newline to space while reading

  if(input.length == 0)
    return;

  input = input.toLocaleLowerCase();

  console.log("sending request to get root words");

  $.getJSON( "engstemmer/engstem.php?l=" + input, function(data) {
    console.log("Got root words");
    console.log(data);
    $("#debugger").text("Play sequence " + JSON.stringify(data));

    /*
      Code to play avatar
    */
  
    playseq = Array();
    for(i = 0; i < data.length; i++)
      playseq.push(data[i]);

    // start playing only if length of data received
    // was more than 0

    if(data.length > 0) {
      var playtimeout = setInterval(function() {

          if(playseq.length == 0 || data.length == 0) {
            clearInterval(playtimeout);
            console.log("Clear play interval");
            avatarbusy=false;
            return;
          }

          if(avatarbusy == false) {
            avatarbusy = true; // this is set to flase in allcsa.js      

            word2play = playseq.shift();    
            console.log("word2play: " + word2play);
            weblog("Playing sign :" + word2play);
            if(lookup[word2play]==null) 
            {
              weblog("<span style='color:red;'>SiGML not available for word : " + word2play + "</span>");
              avatarbusy=false;
              
              // break word2play into chars and unshift them to playseq
            for(i = word2play.length - 1; i >= 0; i--)
              playseq.unshift(word2play);

            } else {
              // data2play = '<sigml><hns_sign gloss="after"><hamnosys_nonmanual></hamnosys_nonmanual><hamnosys_manual><hamfinger2345/><hamthumboutmod/><hamextfingeru/><hampalml/><hamshouldertop/><hamlrbeside/><hambetween/><hamear/><hamlrat/><hamclose/><hamseqbegin/><hammoveur/><hammovedl/><hamseqend/><hamrepeatfromstart/></hamnosys_manual></hns_sign></sigml>';
              // word2play = 'after';
              data2play = lookup[word2play];
              // console.log(data2play);
              $("#currentWord").text(word2play);
              $(".txtaSiGMLText").val(data2play);
              $(".bttnPlaySiGMLText").click();
            }
          } else {
            console.log("Avatar is still busy");

            // check if error occured then reset the avatar to free
            errtext = $(".statusExtra").val();
            if(errtext.indexOf("invalid") != -1) {
              weblog("<span style='color:red;'>Error: " + errtext + "</span>");
              avatarbusy = false;
            }
          }
      }, 500);
    }

  });

});

/*
  function to play example sentences
*/
function playsign(line)
{
  $("#engtext").val(line);
  $("#playeng").click();
}

/*window.onerror = function() {
    alert("Error caught");
};*/
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113307373-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113307373-1');
</script>

</body></html>