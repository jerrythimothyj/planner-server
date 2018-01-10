<?php
    $validations = new validations();
    $validObj = new stdClass();

    $validObj->validDate = $validations->validateDate($reminderObj->date);

    $validObj->validAll = 1;
  	if($validObj->validDate == false)
  		 $validObj->validAll = 0;

  	$ictr = 1;

  	foreach ($reminderObj->reminders as $reminder) {
  		if(!$validations->validateTime($reminder->time)) {
  			$validObj->invalidTime[] = $ictr;
  			$validObj->validAll = 0;
  		}

        if(!$validations->validateFreeText($reminder->title)) {
            $validObj->invalidTitle[] = $ictr;
            $validObj->validAll = 0;
        }

        if(!$validations->validateFreeText($reminder->description)) {
            $validObj->invalidDescription[] = $ictr;
            $validObj->validAll = 0;
        }

  		if(!$validations->validateEmailsList($reminder->additional_emails)) {
  			$validObj->invalidAdditionalEmails[] = $ictr;
  			$validObj->validAll = 0;
  		}

  		if(!$validations->validateNumber($reminder->is_done)) {
  			$validObj->invalidIsDone[] = $ictr;
  			$validObj->validAll = 0;
  		}

		$ictr++;
  	}

  	if($validObj->validAll == 1) {
  		$saveReminderObj = new stdClass();

  		$dbConfig = new dbConfig();
        $dbConfig->dbConnect();

        $miscMethods = new miscMethods();

        $dateArr = explode('/', $reminderObj->date);
        $timeArr = explode('/', $reminderObj->time);

        $reminderSql = "DELETE FROM reminders ";
        $reminderSql .= "WHERE users_sl='".$_SESSION['users_sl']."'";
        $reminderSql .= " and date_yyyy='".$dateArr[0]."'";
        $reminderSql .= " and date_mm='".$dateArr[1]."'";
        $reminderSql .= " and date_dd='".$dateArr[2]."'";

        $dbResult = $dbConfig->dbQuery($reminderSql);

  		foreach ($expenseObj->expenses as $expense) {

	        $reminderSql = "INSERT INTO expenses (users_sl,";
            $reminderSql .= "date_yyyy,";
            $reminderSql .= "date_mm,";
            $reminderSql .= "date_dd,";
            $reminderSql .= "expense_types_sl,";
            $reminderSql .= "comments,";
	        $reminderSql .= "spendings_types_sl,";
	        $reminderSql .= "amount,";
	        $reminderSql .= "ip,";
	        $reminderSql .= "time)";
	        $reminderSql .= "VALUES ('".$_SESSION['users_sl']."',";
          $reminderSql .= "'".$dateArr[0]."',";
          $reminderSql .= "'".$dateArr[1]."',";
          $reminderSql .= "'".$dateArr[2]."',";
          $reminderSql .= "'".$expense->expenseType."',";
          $reminderSql .= "'".htmlspecialchars($expense->comments)."',";
	        $reminderSql .= "'".$expense->spendingsType."',";
	        $reminderSql .= "'".$expense->amount."',";
	        $reminderSql .= "'".$miscMethods->getIP()."',";
	        $reminderSql .= "'".$miscMethods->getDTTM()."')";

	        $dbConfig->dbQuery($reminderSql);
  		}

  		$saveExpObj->saveInd = 1;
    	$saveExpObj->saveText = 'Expenses Saved';

    	$returnObj  = $saveExpObj;
  	}
  	else {
  		$returnObj = $validObj;
  	}
?>
