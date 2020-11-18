<?php

$app->get("/leaf", function () {
    respondWithCode("New in v2", 200);
});
