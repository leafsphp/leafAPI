<?php

/**@var Leaf\App $app */

$app->get("/", function () {
    json(["message" => "Congrats!! You're on Leaf API"], 200);
});

$app->get("/app", function () {
    // app() returns $app
    json(app()->routes(), 200);
});
