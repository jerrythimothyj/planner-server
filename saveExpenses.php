<?php
    $validations = new validations();
    $validObj = new stdClass();

    $validObj->validDate = $validations->validateDate($expenseObj->date);

    $validObj->validAll = 1;
  	if($validObj->validDate == false)
  		 $validObj->validAll = 0;

  	$ictr = 1;

    // if(count($expenseObj->expenses) == 0) {
    //   $validObj->invalidExpenseType[] = $ictr;
    //   $validObj->invalidComments[] = $ictr;
    //   $validObj->invalidSpendingType[] = $ictr;
    //   $validObj->invalidAmount[] = $ictr;
    //   $validObj->validAll = 0;
    // }

  	foreach ($expenseObj->expenses as $expense) {
  		if(!$validations->validateNumber($expense->expenseType) || $expense->expenseType <= 0) {
  			$validObj->invalidExpenseType[] = $ictr;
  			$validObj->validAll = 0;
  		}

      if(!$validations->validateFreeText($expense->comments)) {
        $validObj->invalidComments[] = $ictr;
        $validObj->validAll = 0;
      }

  		if(!$validations->validateNumber($expense->spendingsType) || $expense->spendingsType <= 0) {
  			$validObj->invalidSpendingType[] = $ictr;
  			$validObj->validAll = 0;
  		}

  		if(!$validations->validateNumber($expense->amount) || $expense->amount <= 0) {
  			$validObj->invalidAmount[] = $ictr;
  			$validObj->validAll = 0;
  		}

		$ictr++;
  	}

  	if($validObj->validAll == 1) {
  		$saveExpObj = new stdClass();

  		$dbConfig = new dbConfig();
        $dbConfig->dbConnect();

        $miscMethods = new miscMethods();

        $dateArr = explode('/', $expenseObj->date);

        $expenseSql = "DELETE FROM expenses ";
        $expenseSql .= "WHERE users_sl='".$_SESSION['users_sl']."'";
        $expenseSql .= " and date_yyyy='".$dateArr[0]."'";
        $expenseSql .= " and date_mm='".$dateArr[1]."'";
        $expenseSql .= " and date_dd='".$dateArr[2]."'";

        $dbResult = $dbConfig->dbQuery($expenseSql);

  		foreach ($expenseObj->expenses as $expense) {

	        $expenseSql = "INSERT INTO expenses (users_sl,";
          $expenseSql .= "date_yyyy,";
          $expenseSql .= "date_mm,";
          $expenseSql .= "date_dd,";
          $expenseSql .= "expense_types_sl,";
          $expenseSql .= "comments,";
	        $expenseSql .= "spendings_types_sl,";
	        $expenseSql .= "amount,";
	        $expenseSql .= "ip,";
	        $expenseSql .= "time)";
	        $expenseSql .= "VALUES ('".$_SESSION['users_sl']."',";
          $expenseSql .= "'".$dateArr[0]."',";
          $expenseSql .= "'".$dateArr[1]."',";
          $expenseSql .= "'".$dateArr[2]."',";
          $expenseSql .= "'".$expense->expenseType."',";
          $expenseSql .= "'".htmlspecialchars($expense->comments)."',";
	        $expenseSql .= "'".$expense->spendingsType."',";
	        $expenseSql .= "'".$expense->amount."',";
	        $expenseSql .= "'".$miscMethods->getIP()."',";
	        $expenseSql .= "'".$miscMethods->getDTTM()."')";

	        $dbConfig->dbQuery($expenseSql);
  		}

  		$saveExpObj->saveInd = 1;
    	$saveExpObj->saveText = 'Expenses Saved';

    	$returnObj  = $saveExpObj;
  	}
  	else {
  		$returnObj = $validObj;
  	}
?>
