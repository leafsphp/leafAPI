<?php

/**@var Leaf\App $app */

$app->get("/", function () {
    response(["message" => "Congrats!! You're on Leaf API"]);
});

$app->get("/app", function () {
    // app() returns $app
    response(app()->routes());
});
