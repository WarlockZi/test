<?php session_start(); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>wss server admin panel by petukhovsky.com</title>
</head>
<body>
<h1>wss server admin panel</h1>
<?php
if (isset($_SESSION['wsadmin']['login'])){ ?>
<h2>wss server control buttons</h2>
<input id="ws-start" class="button" type="button" value="start" /> <input id="ws-stop" class="button" type="button" value="stop" /> <!-- <input id="echo-ws-restart" class="button" type="button" value="restart" /> -->
<br />

<h2>echo wss server current status</h2>
<div id="ws-status" style="border: 1px solid">
Loading... 
</div>
<input id="ws-status-refresh" class="button" type="button" value="refresh" /><br /><br />

<h2>echo wss server logfile</h2>
<div id="ws-logfile" style="border: 1px solid; overflow-y: scroll; height: 200px; resize: vertical;">
Loading... 
</div>
<input id="ws-logfile-refresh" class="button" type="button" value="refresh" /> <input id="ws-logfile-clear" class="button" type="button" value="clear" /><br /><br />


<h2>echo wss server errorfile</h2>
<div id="ws-errorfile" style="border: 1px solid; overflow-y: scroll; height: 100px; resize: vertical;">
Loading... 
</div>
<input id="ws-errorfile-refresh" class="button" type="button" value="refresh" /> <input id="ws-errorfile-clear" class="button" type="button" value="clear" /><br /><br />


<input id="ws-exit" class="button" type="button" value="logout" /><br /><br />

<?php
} else { ?>
login:<br />
<input id="login" type="text" maxlength="15" size="15" name="login" /><br />
pass:<br />
<input id="pass" type="password" maxlength="15" size="15" name="pass" /><br />
<input id="gologin" class="button" type="button" value="login" /><br />
<p id="loginmsg" style="color:red;"></p><br />

<?php
}
?>

<script src="wsadmin.js" type="text/javascript"></script>

wss server admin panel v.0.5.0. OS Windows/*nix supported! (HTTPS compatible)

</body>
</html>