<?php

class ExampleController extends BaseController {
    protected function post(){
        try {
            $this->getPDO()->beginTransaction();
            $sql = 'INSERT INTO table1 (column1, column2) VALUES (:column1, :column2)';
            $pdoState = $this->getPDO()->prepare($sql);
            $pdoState->bindValue(':column1', 99, PDO::PARAM_INT);
            $pdoState->bindValue(':column2', 'foobar', PDO::PARAM_STR);
            $pdoState->execute();

            $this->getPDO()->commit();
        } catch (PDOException $e) {
            $this->getPDO()->rollBack();
            throw $e;
        }
        $this->success();
    }

    protected function get(){
        $sql = 'SELECT column2 FROM table1 WHERE column1 = :column1';
        $pdoState = $this->getPDO()->prepare($sql);
        $pdoState->bindValue(':column1',  99,  PDO::PARAM_INT);
        $pdoState->execute();
        foreach ($pdoState as $row) {
            $scores[] = $row;
        }
        $this->success($scores);
    }
}

