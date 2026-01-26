<?php
date_default_timezone_set('America/New_York');
//date.timezone = 'America/New_York';
echo $_SERVER['HTTP_X_FORWARDED_PORT'];


echo "****";
echo ini_get('upload_max_filesize')."<br />";
echo ini_get('post_max_size')."<br />";
echo ini_get('max_execution_time')."<br />";
echo date('Y-m-d H:i:s');
phpinfo();
//mail('dibyendu.dutta.mail@gmail.com', 'My Subject', 'hello');

?>