<?php
defined('ROOT_PATH') or exit;

if(isset($uri) && trim($uri, '/') == 'api/v1/cloud/connect') {
    $_GET['control'] = 'cloud';
    $_GET['action'] = 'connect';
    return;
}
