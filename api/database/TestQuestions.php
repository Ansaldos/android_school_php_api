<?php

/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 21.
 * Time: 23:31
 */
class TestQuestions extends DbConn
{
    public function __construct($db_config)
    {
        parent::__construct($db_config);
    }

    public function getTestQuestions()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM testquestions;";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'test_id' => $row['test_id'],
                    'question_id' => $row['question_id']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Not found any TestQuestions";
    }

    public function getTestQuestion($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM testquestions WHERE id LIKE '" . $id . "'";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'test_id' => $row['test_id'],
                    'question_id' => $row['question_id']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "TestQuestion not found";
    }

    public function putTestQuestion($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $stmt = $conn->prepare("INSERT INTO `testquestions` (`id`, `test_id`, `question_id`) VALUES (NULL, ?, ?)");
        $stmt->bind_param("ii", $data['test_id'], $data['question_id']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $stmt->insert_id;
    }

    public function postTestQuestion($data)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getTestQuestion($data['id']);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "TestQuestion not exist";
        }

        $stmt = $conn->prepare("UPDATE testquestions SET test_id = ?, question_id = ? WHERE id = ?;");
        $stmt->bind_param("iii", $data['test_id'], $data['question_id'], $data['id']);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $data['id'] . ". record has been modified";
    }

    public function deleteTestQuestion($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getTestQuestion($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "TestQuestion not exist";
        }

        $stmt = $conn->prepare("DELETE FROM `testquestions` WHERE `testquestions`.`id` = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            return "Failed to delete TestQuestion";
        }

        $conn->close();
        return "0";
    }
}