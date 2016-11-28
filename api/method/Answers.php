<?php
/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 23:04
 */

/**
 * Get all answers
 */
$app->get('/answers', function ($request, $response) {

    $result = $this->answers->getAnswers();
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
$app->get('/answer/{id}', function ($request, $response) {

    $result = $this->answers->getAnswer($request->getAttribute('id'));
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
 * Get question's answers
 */
$app->get('/questionanswers/{id}', function ($request, $response) {

    $result = $this->answers->getAnswersByQuestionId($request->getAttribute('id'));
    if(is_array($result))
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array(
                "info" => "Returned answers",
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
$app->put('/answer', function ($request, $response) {
    $result = $this->answers->putAnswer($request->getParsedBody());
    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result,
        )));
});

/**
 * Update test
 */
$app->post('/answer', function ($request, $response) {
    $result = $this->answers->postAnswer($request->getParsedBody());

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Increment answer counter
 */
$app->post('/answer_increment/{id}', function ($request, $response) {
    $result = $this->answers->postIncrementAnswer($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});

/**
 * Delete test
 */
$app->delete('/answer/{id}', function ($request, $response) {
    $result = $this->answers->deleteAnswer($request->getAttribute('id'));

    return $response->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            "info" => $result
        )));
});






