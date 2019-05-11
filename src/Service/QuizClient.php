<?php

namespace Service;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class QuizClient{
  private $numberOfQuestions;

  public function __construct($numberOfQuestions){
    $this->$numberOfQuestions = $numberOfQuestions;
  }

  public function getQuestions(){
    $body = $this->makeRequest(1);
    $questions = $this->parseRequest($body);
    return $questions;
  }

  public function makeRequest($numberOfQuestions){
    $client = new Client([
      'base_uri' => 'https://opentdb.com',
      'timeout'  => 2.0,
    ]);
    $response = $client->get('/api.php?difficulty=easy&amount='.$numberOfQuestions);
    // $questions = $this->parseRequest($response->getBody()->getContents());
    $results = $response->getBody()->getContents();
    return $results;
  }

  public function parseRequest($response){

    return json_decode($response, true);
  }
}
