<?php

/**
 * Created by PhpStorm.
 * User: legye
 * Date: 2016. 11. 20.
 * Time: 15:25
 */
class Tests extends DbConn
{
    public function __construct($db_config)
    {
        parent::__construct($db_config);
    }

    /**
     * Get all test from db
     * @return array|string
     */
    public function getTests()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM tests;";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'completing_counter' => $row['completing_counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Not found any test";
    }

    /**
     * Get test by id
     * @param $id
     * @return array|string
     */
    public function getTest($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM tests WHERE id LIKE '" . $id . "'";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result = array(
                    'id' => $row['id'],
                    'completing_counter' => $row['completing_counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Test not found";
    }

    public function getRandomTest()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $sql = "SELECT * FROM tests order by RAND() LIMIT 1;";
        $response = $conn->query($sql);
        $result = array();

        if ($response->num_rows > 0) {
            while ($row = $response->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'completing_counter' => $row['completing_counter']
                );
            }

            $conn->close();
            return $result;
        }

        $conn->close();
        return "Test not found";
    }

    public function getTestQuestionsByTestId($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $stmt = $conn->prepare("
          SELECT `questions`.`id`, `questions`.`text` FROM `testquestions` inner join `questions` on `testquestions`.`question_id` = `questions`.`id` where `testquestions`.`test_id` = ? LIMIT 10;");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $sqlResult = $stmt->get_result();

        $result = array();
        if ($sqlResult->num_rows > 0) {
            while ($row = $sqlResult->fetch_assoc()) {
                $result[] = array(
                    'id' => $row['id'],
                    'text' => $row['text']
                );
            }
            $conn->close();
            return $result;
        }

        $conn->close();
        return "Questions do not exist";
    }

    /**
     * Insert new test
     * @param $data
     * @return int|string
     */
    public function putTest()
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        $stmt = $conn->prepare("INSERT INTO `tests` (`id`) VALUES (NULL)");

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $stmt->insert_id;
    }

    /**
     * Update test
     * @param $id
     * @return string
     */
    public function postTest($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getTest($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Test not exist";
        }

        $stmt = $conn->prepare("UPDATE tests SET completing_counter = completing_counter+? WHERE id = ?;");

        $increment = 1;
        $stmt->bind_param("ii", $increment, $id);

        if (!$stmt->execute()) {
            return "Execute failed";
        }

        $conn->close();
        return $id . ". record has been modified";
    }

    /**
     * Delete test by id
     * @param $id
     * @return string
     */
    public function deleteTest($id)
    {
        $conn = $this->getConnection();
        if(is_null($conn))
        {
            return "Database server not responding";
        }

        //Check test record is exist
        $existingTest = $this->getTest($id);
        if(!is_array($existingTest)) //Returns an array if exist
        {
            return "Test not exist";
        }

        $stmt = $conn->prepare("DELETE FROM `tests` WHERE `tests`.`id` = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            return "Failed to delete test";
        }

        $conn->close();
        return "0";
    }
}