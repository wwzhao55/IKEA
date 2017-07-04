<?php
function dgPicUrl($url){
	return config('web.qiniu_domain').$url;
}