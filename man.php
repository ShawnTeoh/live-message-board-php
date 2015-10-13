<?php
    session_start();
    $_SESSION["token"] = md5(uniqid(mt_rand(), true));
?>
<!DOCTYPE html>
<html>
<head>
<title>UQMSA Malaysian Appreciation Night 2015</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.1/flatly/bootstrap.min.css" />
<script type="text/javascript">
  var warning = function () {
    setTimeout(function(){
      alert("Session timed out, please refresh page and try again.");
    }, 600000);
  }
  warning();

  var verify = function () {
    var name = document.getElementById('name');
    var msg = document.getElementById('msg');
    if (name.value == null || name.value == "") {
      notify("Please fill in your name");
      return false;
    } else if (msg.value == null || msg.value == "") {
      notify("Please fill in a message");
      return false;
    } else {
      return true;
    }
  };

  var notify = function(text) {
    document.getElementById('noti').style.display='';
    document.getElementById('noti_text').innerHTML=text;
    document.getElementById('noti').scrollIntoView();
  };

  var noti_close = function(text) {
    document.getElementById('noti').style.display='none';
  };
</script>
<noscript>
  <META HTTP-EQUIV="Refresh" CONTENT="0; URL=https://bot.uqmsa.org/js-error.php" />
</noscript>
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <p><img class="img-responsive" width="280" height="109" src="images/logo.png" alt="logo"/></p>
      <h2>UQMSA <strong>Malaysian Appreciation Night 2015</strong></h2>
    </div>
  </div>

  <div class="container">
    <div id="noti" class="alert alert-danger" role="alert" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="noti_close()"><span aria-hidden="true">&times;</span></button>
      <strong id="noti_text"></strong>
    </div>
    <h4 style="font-weight:bold">Merdeka Confessions: Write a message to Malaysia/friends in Malaysia/fellow Malaysians!</h4>
    <h4 style="padding-bottom:20px">Note that your message will be publicly displayed. ;)</h4>
    <form class="form-horizontal" onsubmit="return verify()" action="https://bot.uqmsa.org/man-submit.php" method="post" name="paymentform">
      <fieldset>
        <div class="form-group">
          <label class="col-md-2 control-label" for="name">Name</label>
          <div class="col-md-3">
            <input id="name" name="name" maxlength="15" type="text" placeholder="Your name" class="form-control input-md">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label" for="msg">Message</label>
          <div class="col-md-4">
            <textarea id="msg" name="msg" maxlength="5000" placeholder="Your message" class="form-control input-md"></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        <input name="veri" type="hidden" value="<?php echo $_SESSION["token"]; ?>">
      </fieldset>
    </form>
  </div>
  <footer>
    <div class="container" style="padding-top:15px">
      <a href="https://www.positivessl.com" style="font-family: arial; font-size: 10px; color: #212121; text-decoration: none;"><img src="https://www.positivessl.com/images-new/PositiveSSL_tl_trans.png" alt="SSL Certificate" title="SSL Certificate" border="0" /></a><div style="font-family: arial;font-weight:bold;font-size:15px;color:#86BEE0;"><a href="https://www.positivessl.com" style="color:#86BEE0; text-decoration: none;">SSL Certificate</a></div>
    </div>
  </footer>
</body>
</html>
