<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}
</script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<style type="text/css">
.form-style-8{
	font-family: 'Open Sans Condensed', arial, sans;
	width: 500px;
	padding: 30px;
	background: #FFFFFF;
	margin: 50px auto;
	box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.22);
	-moz-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.22);
	-webkit-box-shadow:  0px 0px 1px rgba(0, 0, 0, 0.22);

}
.form-style-8 h2{
	background: #4D4D4D;
	text-transform: uppercase;
	font-family: 'Open Sans Condensed', sans-serif;
	color: #797979;
	font-size: 18px;
	font-weight: 100;
	padding: 20px;
	margin: -30px -30px 30px -30px;
}
.form-style-8 input[type="text"],
.form-style-8 input[type="date"],
.form-style-8 input[type="datetime"],
.form-style-8 input[type="email"],
.form-style-8 input[type="number"],
.form-style-8 input[type="search"],
.form-style-8 input[type="time"],
.form-style-8 input[type="url"],
.form-style-8 input[type="password"],
.form-style-8 textarea,
.form-style-8 select 
{
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	outline: none;
	display: block;
	width: 100%;
	padding: 7px;
	border: none;
	border-bottom: 1px solid #ddd;
	background: transparent;
	margin-bottom: 10px;
	font: 16px Arial, Helvetica, sans-serif;
	height: 45px;
}
.form-style-8 textarea{
	resize:none;
	overflow: hidden;
}
.form-style-8 input[type="button"], 
.form-style-8 input[type="submit"]{
	-moz-box-shadow: inset 0px 1px 0px 0px #45D6D6;
	-webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6;
	box-shadow: inset 0px 1px 0px 0px #45D6D6;
	background-color: #2CBBBB;
	border: 1px solid #27A0A0;
	display: inline-block;
	cursor: pointer;
	color: #FFFFFF;
	font-family: 'Open Sans Condensed', sans-serif;
	font-size: 14px;
	padding: 8px 18px;
	text-decoration: none;
	text-transform: uppercase;
}
.form-style-8 input[type="button"]:hover, 
.form-style-8 input[type="submit"]:hover {
	background:linear-gradient(to bottom, #34CACA 5%, #30C9C9 100%);
	background-color:#34CACA;
}
</style>
<?php
	$username = "";
	$password = "";

if(!empty($_SERVER["PHP_AUTH_USER"]) && !empty($_SERVER["PHP_AUTH_PW"])) 
{
	$username = $_SERVER["PHP_AUTH_USER"];
	$password = $_SERVER["PHP_AUTH_PW"];
}
else{
?>
<div class="form-style-8">
<form method="post">
	KoBo Username:<br>
	<input style="width: 200px" type="text" name="username"><br><br>
	KoBo Password:<br>
	<input style="width: 200px" type="password" name="password"><br><br>
	<input type="submit" value="Open record">
</form>

<?php
}
if (isset($_GET['recordid']))
	{
		$recordid = $_GET['recordid'];
	} 
else $recordid = "missing";
if (isset($_GET['xformid']))
	{
		$xformid = $_GET['xformid'];
	} 
else $xformid = "missing";
if (isset($_POST['username']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$url = "https://kf.kobotoolbox.org/assets/" . $xformid . "/submissions/" . $recordid . "/edit/?return_url=false";
	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$resp = curl_exec($curl);
	$array = json_decode($resp,true);

	if (isset($array['detail'])){echo $array['detail'];}
	if (isset($array['url']))
{
header('Location: '.$array['url']);
}
curl_close($curl); 
}
?>
</div>