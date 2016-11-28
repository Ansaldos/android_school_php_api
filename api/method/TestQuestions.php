<?php
/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 23:31
 */

/**
 * Get all TestQuestions
 */
$app->get('/testQuestions', function ($request, $response) {

    $result = $this->testQuestions->getTestQuestions();
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
 * Get TestQuestion
 */
$app->get('/testQuestion/{id}', function ($request, $response) {

    $result = $this->testQuestions->getTestQuestion($request->getAttribute('id'));
    if(is_array($result))
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned answer",
                "data" => $result,
            )));
    }

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Insert new TestQuestion
 */
$app->put('/testQuestion', function ($request, $response) {
    $result = $this->testQuestions->putTestQuestion($request->getParsedBody());
    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result,
        )));
});

/**
 * Update TestQuestion
 */
$app->post('/testQuestion', function ($request, $response) {
    $result = $this->testQuestions->postTestQuestion($request->getParsedBody());

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Delete TestQuestion
 */
$app->delete('/testQuestion/{id}', function ($request, $response) {
    $result = $this->testQuestions->deleteTestQuestion($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});






