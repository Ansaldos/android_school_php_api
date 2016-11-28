<?php
// Application middleware

require_once '..\api\middlewares\BasicAuthMiddleware.php';
$app->add(new BasicAuthMiddleware($settings['api_key']));
