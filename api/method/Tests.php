<?php
/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 20.
 * Time: 15:26
 */

/**
 * Get all test
 */
$app->get('/tests', function ($request, $response) {

    $result = $this->tests->getTests();
    $resultCounter = count($result);

    if($resultCounter !== 0) {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned " . $resultCounter . " records",
                "data" => $result
            )));

    }

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Get test
 */
$app->get('/test/{id}', function ($request, $response) {

    $result = $this->tests->getTest($request->getAttribute('id'));
    if(is_array($result))
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned test",
                "data" => $result,
            )));
    }

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Get random test
 */
$app->get('/test', function ($request, $response) {

    $result = $this->tests->getRandomTest();
    if(is_array($result))
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned test",
                "data" => $result,
            )));
    }

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Get test's questions by id
 */
$app->get('/testquestions/{id}', function ($request, $response) {

    $result = $this->tests->getTestQuestionsByTestId($request->getAttribute('id'));
    if(is_array($result))
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned questions",
                "data" => $result,
            )));
    }

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Insert new test
 */
$app->put('/test', function ($request, $response) {
    $result = $this->tests->putTest();
    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result,
        )));
});

/**
 * Update test
 */
$app->post('/test/{id}', function ($request, $response) {
    $result = $this->tests->postTest($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Delete test
 */
$app->delete('/test/{id}', function ($request, $response) {
    $result = $this->tests->deleteTest($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});






