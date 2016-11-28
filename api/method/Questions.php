<?php
/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 23:19
 */

/**
 * Get all questions
 */
$app->get('/questions', function ($request, $response) {

    $result = $this->questions->getQuestions();
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
 * Get question
 */
$app->get('/question/{id}', function ($request, $response) {

    $result = $this->questions->getQuestion($request->getAttribute('id'));
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
 * Insert new test
 */
$app->put('/question', function ($request, $response) {
    $result = $this->questions->putQuestion($request->getParsedBody());
    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result,
        )));
});

/**
 * Update test
 */
$app->post('/question', function ($request, $response) {
    $result = $this->questions->postQuestion($request->getParsedBody());

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Delete test
 */
$app->delete('/question/{id}', function ($request, $response) {
    $result = $this->questions->deleteQuestion($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});






