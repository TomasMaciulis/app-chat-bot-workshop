<?php

namespace Service;

class QuizRegisterUser{

  private $userId;
  private $question;

  public function __construct($userId, $question){
    $this->userId = $userId;
    $this->question = $question;
  }

  public function registerUser(){
    $arr = array($this->userId, $this->question);

    $jsonVar = json_encode($arr);

    echo getcwd() . "\n";

    file_put_contents('usr/'.$this->userId.'.json', $jsonVar);
  }
}
