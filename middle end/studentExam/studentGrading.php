<?php
//decoding exam-id from back
$array1  = array();

    $response = file_get_contents('php://input');
    $array1   = json_decode($response, true);
    //check what is sent from back
        print_r($array1);
//extrct exam id from array1
$exam_id=$array1[1]["exam_id"];
//$exam_id = "6";
$studentTotalScore=[];
$totalPoints = 0;
//$deductedPoints=0;
$questionGraded = [];

echo "ExamId= $exam_id";
echo  "<br/>\n";
echo  "<br/>\n";


function solution($studentAnswers, $studentTestCASE, $explodedQueston)
{
    $testMe = "\rprint ".$explodedQueston."(".$studentTestCASE.")";
    //$testMe = "\rprint (".$studentTestCASE.")";
    $code = $studentAnswers . $testMe;
    //echo $code; prints => def divisions(a,b): return a/b print division(8,4)
    $runMyCode= tempnam("/tmp", "createMyCode");
    $tempFile= tempnam("/tmp", "handleError");
    $fh = fopen($runMyCode, 'w') or die("file did not open");
    fwrite($fh, $code);
    fclose($fh);
    $command = "$runMyCode 2>&1 $tempFile";
    $output= exec('python ' .$command);

    if (!$return) {
    } else {
    }
    return $output;
}


$final = array("exam_id"=>$exam_id);
$url = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/send_All_Answers_to_middle.php";
$ch=curl_init();
curl_setopt_array($ch, array(
CURLOPT_URL => $url,
CURLOPT_POST => 1,
CURLOPT_FOLLOWLOCATION => 1,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_POSTFIELDS => json_encode($final, true)
));
  $resp = curl_exec($ch);
curl_close($ch);
echo "ALl THE ANSWERS";
echo  "<br/>\n";
 echo  $resp;
echo  "<br/>\n";
echo  "<br/>\n";
$ALL_fetched_answers = (array)json_decode($resp, true);
//echo $ALL_fetched_answers;
 $ALL_student_Answers= count($ALL_fetched_answers);
 //echo $ALL_student_Answers;

  for ($i = 0; $i < $ALL_student_Answers; $i++) {
      $appendAnsFunc="";
      $appendFunc="";
      $answerVars="";
      $questionVars="";
      $total_TestGotRights = 0;
      $studentScore = 0;
      $deductedPoints=2;
      //$minusPoints=1;
      $eachAnswer = $ALL_fetched_answers[$i];
      $ans_id = $eachAnswer['ans_id'];
      $questionID = $eachAnswer['questionID'];
      $answer = $eachAnswer['answer'];
      $username = $eachAnswer['username'];

      $final1 = array("id"=>$questionID);
      $url3 = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/send_Questions_back.php";
      $ch=curl_init();
      curl_setopt_array($ch, array(
CURLOPT_URL => $url3,
CURLOPT_POST => 1,
CURLOPT_FOLLOWLOCATION => 1,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_POSTFIELDS => json_encode($final1, true)
));
      $resp = curl_exec($ch);
      curl_close($ch);
      echo "Question";
      echo  "<br/>\n";
      echo $resp;
      $questionData = (array)json_decode($resp, true);
      $info = $questionData[0];
      $points = $info['points'];
      $question = $info['question'];
      //echo  "<br/>\n";
      //echo  "<br/>\n";
      //  echo "printing question:=____>$question";
      //works
      echo  "<br/>\n";
      echo  "<br/>\n";
      //works


      if (array_key_exists($questionID, $questionGraded)) {
      } else {
          $totalPoints += $points;
          $questionGraded[$questionID]=$questionID;
      }

      $url2 = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/send_Cases_back.php";
      $ch=curl_init();
      curl_setopt_array($ch, array(
   CURLOPT_URL => $url2,
   CURLOPT_POST => 1,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_POSTFIELDS => json_encode($final1, true)
 ));
      $resp = curl_exec($ch);
      curl_close($ch);
      echo  "TestCase";
      echo  "<br/>\n";
      echo $resp;
      echo  "<br/>\n";
      $all_testCases = (array)json_decode($resp, true);
      $numOfTestCases = count($all_testCases);
      //echo $numOfTestCases;//works


      for ($j = 0; $j < $numOfTestCases; $j++) {
          $answer_Result = "";
          $caseResult = "fail";
          $testCase = $all_testCases[$j];
          $testCaseID = $testCase['case_id'];
          $questionID = $testCase['questionID'];
          $test_case = $testCase['test_case'];
          echo $test_case;
          $caseAnswer = $testCase['case_answer'];


          /// to find function name inside question:
          $result = preg_split('/named/', $question);
          $result = $result[1];
          $eachWords = explode(' ', trim($result));
          $eachWords1= $eachWords[0];
          $appendFunc=$eachWords1;
          echo  "<br/>\n";
          echo "Question function Unique Name:=_____>  $eachWords1";
          echo  "<br/>\n";

          /// to find function name inside answer:
          $answeR = preg_split('/def/', $answer);
          $answeR=$answeR[1];
          $eachAnswer=explode('(', trim($answeR));
          $eachAnswer1=$eachAnswer[0];
          $appendAnsFunc=$eachAnswer1;
          echo "Student answer function  Name:=_____>$eachAnswer1";
          echo  "<br/>\n";

          ///Checking if function name matched to answer or not
          if ($eachWords1==$eachAnswer1) {
              echo "Function name matched with Question";
              $functionName = "Function name matched with Question";
          } else {
              $functionName = "Function name did not match with Question";
          }
          // to find stuff from Answer paranthesis

          preg_match('#\((.*?)\)#', $answer, $match);
          $answerVars = $match[1];
          //print $answerVars;


          // to find varaibles from Question

          $result1 = preg_split('/parameters /', $question);
          $result = $result1[1];
          $questVars = explode(' ', trim($result));
          //echo $questVars;
          $questionVars1= $questVars[0];
          $questionVars=$questionVars1;
          echo  "<br/>\n";
          echo "Question variables:=_____>  $questionVars1";
          echo  "<br/>\n";
          echo "answer variables:=_____>  $answerVars";
          echo  "<br/>\n";

          if ($answerVars==$questionVars) {
              echo "Variables  matched with Question";
              $variableMatch = "Variables  matched with Question";
          } else {
              //$functionName = "Function name did not match with Question, 2 points deducted";
              echo "Function variables did not match with Question,2 point deducted";
              $variableMatch ="Function variables did not match with Question";
              //echo $variableMatch;
          }


          $answer_Result = solution($answer, $test_case, $eachAnswer1);
          echo  "<br/>\n";
          echo "Solution is printed:=_____> $answer_Result";


          echo  "<br/>\n";

          if ($answer_Result == $caseAnswer) {
              $total_TestGotRights++;
              $caseResult = "success";
              $casePoints = round($points/$numOfTestCases, 2);
              $test_case1 =str_replace("'", '', $test_case);
              $case_feedback = "$eachAnswer1($test_case1) ->  $caseAnswer";
              echo "caseFeedback is printed:=_____>$case_feedback";
          } else {
              //$c = $a.$b;
              $test_case1 =str_replace("'", '"', $test_case);

              $case_feedback = "$eachAnswer1($test_case1) ->  $caseAnswer";
              $casePoints="0";
          }
          $answer_result1=str_replace("'", "''", $answer_Result);
          $run=$answer_result1;
          $sendArray = array(
                    'username' => $username,
                    'testCaseID' => $testCaseID,
                    'question_id' => $questionID,
                    'ans_id' => $ans_id,
                    'result' => $caseResult,
                    'exam_id' => $exam_id,
                    'casePoints'=>$casePoints,
                    'case_feedback'=>$case_feedback,
                    'functionName'=>$functionName,
                    'variableMatch'=>$variableMatch,
                    'run'=>$run



  );
          $sendArray = json_encode($sendArray);
          $url4 = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/submitResults.php";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url4);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $sendArray);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          $result = curl_exec($ch);
          echo  "<br/>\n";
          echo $result;
          echo  "<br/>\n";
          curl_close($ch);
          // works
      }//end tests
      echo "it reached here";
      echo $points;
      echo  "<br/>\n";
      $totalPoints+=$Points;
      echo $totalPoints;
    //  echo $total_TestGotRights;
      echo  "<br/>\n";
      //echo $numOfTestCases;
      echo  "<br/>\n";
      $studentScore = $points * ($total_TestGotRights/$numOfTestCases);
      echo $studentScore;
      if ($appendAnsFunc!=$appendFunc) {
          echo "Function name did not match, 2 point deducted";

          $studentScore = $points * ($total_TestGotRights/$numOfTestCases)-$deductedPoints;
      }
      echo  "<br/>\n";
      echo $studentScore;


      echo  "<br/>\n";


      //$studentScore = $points * ($total_TestGotRights/$numOfTestCases);
      if ($answerVars!=$questionVars) {
          echo "Function variables did not matched with Question,2 point deducted";
          $studentScore = $studentScore-$deductedPoints;
      }
      echo $studentScore;


      if (isset($username, $studentTotalScore)) {
          $studentTotalScore[$username] += $studentScore;
      } else {
          $studentTotalScore[$username] = $studentScore;
      }
      if ($studentScore<0){
        $studentScore=0;
      }
      $sendArray5 = array('ID'=>$questionID,
      'points'=>$studentScore,
      'exam_id' => $exam_id
    );

      $sendArray5 = json_encode($sendArray5);
      $url6 = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/studentAnswers.php";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url6);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $sendArray5);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      $result = curl_exec($ch);
      echo $result;
      curl_close($ch);
      echo  "<br/>\n";
      echo  "<br/>\n";
      echo "just ptinted  this";
      echo $sendArray5;
      //echo $appendAnsFunc;
      //echo $appendFunc;
  } //loop


  foreach (array_keys($studentTotalScore) as $key) {
      $grade = ($studentTotalScore[$key]/$totalPoints)*100;
      $grade=round($grade, 1);
      if ($grade<0){
        $grade=0;
      }

      $sendArray1 = array('totalPoints'=>$totalPoints,'ID'=>$questionID,'points'=>$studentScore,'username' => $key,'grade' => $grade,'exam_id' => $exam_id,  );

      $sendArray1 = json_encode($sendArray1);
      $url5 = "https://web.njit.edu/~mds39/CS490/master/back/studentExam/studentGrades.php";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url5);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $sendArray1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      $result = curl_exec($ch);
      echo $result;
      curl_close($ch);
      echo  "<br/>\n";
      echo  "<br/>\n";
      echo $sendArray1;
  }
