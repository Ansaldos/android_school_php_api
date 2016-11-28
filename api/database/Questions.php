<?php

/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 23:17
 */
class Questions extends DbConn
{
    public function __construct($db_config)
    {
        parent::__construct($db_config);
    }

    public function getQuestions()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM questions;";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Not found any question";
    }

    public function getQuestion($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM questions WHERE id LIKE '" . $id . "'";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Question not found";
    }

    public function putQuestion($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }
		
        $stmt = $conn->prepare("INSERT INTO `questions` (`id`, `text`) VALUES (NULL, ?)");
        $stmt->bind_param("s", $data['text']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $stmt->insert_id;
    }

    public function postQuestion($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getQuestion($data['id']);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Question not exist";
        }

        $stmt = $conn->prepare("UPDATE questions SET text = ? WHERE id = ?;");
        $stmt->bind_param("si", $data['text'], $data['id']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $data['id'] . ". record has been modified";
    }

    public function deleteQuestion($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getQuestion($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Question not exist";
        }

        $stmt = $conn->prepare("DELETE FROM `questions` WHERE `questions`.`id` = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            return "Failed to delete question";
        }

        $conn->close();
        return "0";
    }
}