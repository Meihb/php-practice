<?php
/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-10-17
 * Time: 14:09
 */
header('Cache-control:max-age=86400,must-revalidate');//基于请求时间的最长缓存时间,确认ETag新鲜性
header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
header('Expires:'.gmdate('D, d M Y H:i:s',time()+86400).'GMT');
echo '不刷新';
?>
<html>

</html>

