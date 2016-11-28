<?php

/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 22:56
 */
class Answers extends DbConn
{
    public function __construct($db_config)
    {
        parent::__construct($db_config);
    }

    public function getAnswers()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM answers;";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text'],
                    'question_id' => $row['question_id'],
                    'counter' => $row['counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Not found any answer";
    }

    public function getAnswer($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM answers WHERE id LIKE '" . $id . "'";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text'],
                    'question_id' => $row['question_id'],
                    'counter' => $row['counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Answer not found";
    }

    public function getAnswersByQuestionId($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM answers WHERE question_id LIKE '" . $id . "'";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text'],
                    'question_id' => $row['question_id'],
                    'counter' => $row['counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Answers do not exist";
    }

    public function putAnswer($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $stmt = $conn->prepare("INSERT INTO `answers` (`id`, `text`, `question_id`) VALUES (NULL, ?, ?)");
        $stmt->bind_param("si", $data['text'], $data['question_id']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $stmt->insert_id;
    }

    public function postAnswer($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getAnswer($data['id']);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Answer not exist";
        }

        $stmt = $conn->prepare("UPDATE answers SET text = ?, question_id = ?, counter = 0 WHERE id = ?;");
        $stmt->bind_param("sii", $data['text'], $data['question_id'], $data['id']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $data['id'] . ". record has been modified";
    }

    public function postIncrementAnswer($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getAnswer($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Answer not exist";
        }

        $stmt = $conn->prepare("UPDATE answers SET counter = counter+? WHERE id = ?;");

        $increment = 1;
        $stmt->bind_param("ii", $increment, $id);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $id . ". record has been modified";
    }

    public function deleteAnswer($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getAnswer($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Answer not exist";
        }

        $stmt = $conn->prepare("DELETE FROM `answers` WHERE `answers`.`id` = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            return "Failed to delete answer";
        }

        $conn->close();
        return "0";
    }
}