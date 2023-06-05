<?php

class Bookmark {
    private $id;
    private $title;
    private $link;
    private $date_added;
    private $done = false;
    private $dbConnection;
    private $dbTable = 'bookmarks';

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getLink() {
        return $this->link;
    }

    public function getDateAdded() {
        return $this->date_added;
    }

    public function getDone() {
        return $this->done;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setDateAdded($date_added) {
        $this->date_added = $date_added;
    }

    public function setDone($done) {
        $this->done = $done;
    }


    //// create
    public function create() {
        $query = "INSERT INTO " . $this->dbTable . " (title, link, date_added, done) VALUES (:title, :link, now(), :done)";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":link", $this->link);
        $stmt->bindValue(":done", $this->done, PDO::PARAM_BOOL);
    
        if ($stmt->execute()) {
            return true;
        }
    
        printf("Error: %s", $stmt->error);
        return false;
    }



    ////read
    public function readOne() {
        $query = "SELECT * FROM " . $this->dbTable . " WHERE id = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute() && $stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id = $result->id;
            $this->title = $result->title;
            $this->link = $result->link;
            $this->date_added = $result->date_added;
            $this->done = $result->done;
            return true;
        }
    
        return false;
    }


    public function readAll() {
        $query = "SELECT * FROM " . $this->dbTable . " WHERE done = false";
        $stmt = $this->dbConnection->prepare($query);
    
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return false;
    }
    

    public function update() {
        $query = "UPDATE " . $this->dbTable . " SET done=:done WHERE id = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":done", $this->done);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute() && $stmt->rowCount() == 1) {
            return true;
        }
    
        return false;
    }
    
    
    public function delete() {
        $query = "DELETE FROM " . $this->dbTable . " WHERE id = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute() && $stmt->rowCount() == 1) {
            return true;
        }
    
        return false;
    }
    
    
    

}


