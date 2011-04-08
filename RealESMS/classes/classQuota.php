<?php
require_once('../includes.php');

class CQuota extends WS_Class
{
  var $_ERROR_CODE;
  var $items;

  function CQuota($check_remoter)
  {
    $this->_MDB2 = initDB() ;
    $this->_MDB2_WRITE = initWriteDB();
    $this->_ERROR_CODE = '0';
    $this->items = array();

    $this->class_name = get_class($this);

    $arr = array(
      'InsertQuotaRate' => array(
                    'input' => array('Rate','TDate','CreatedBy'),
                    'output' => array('ID')
                    ),
      'UpdateQuotaRate' => array(
                    'input' => array('QuotaRateID','Rate','UpdatedBy'),
                    'output' => array()
                    ),
      'DeleteQuotaRate' => array(
                    'input' => array('QuotaRateID','UpdatedBy'),
                    'output' => array()
                    ),
      'ConfirmQuotaRate' => array(
                    'input' => array('QuotaRateID','UpdatedBy'),
                    'output' => array()
                    ),
      'DeleteConfirmedQuotaRate' => array(
                    'input' => array('QuotaRateID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaRateList' => array(
                    'input' => array('WhereClause','TimeZone'),
                    'output' => array('ID','RateProceeds','T','IsConfirmed','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'UpdateConfirmedQuotaRate' => array(
                    'input' => array('QuotaRateID','Rate','UpdatedBy'),
                    'output' => array('ID')
                    ),
      'InsertQuotaSetting' => array(
                    'input' => array('QuotaAmount','CreatedBy'),
                    'output' => array('ID')
                    ),
      'UpdateQuotaSetting' => array(
                    'input' => array('QuotaSettingID','QuotaAmount','UpdatedBy'),
                    'output' => array()
                    ),
      'DeleteQuotaSetting' => array(
                    'input' => array('QuotaSettingID','UpdatedBy'),
                    'output' => array()
                    ),
      'ConfirmQuotaSetting' => array(
                    'input' => array('QuotaSettingID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaSettingList' => array(
                    'input' => array('WhereClause','TimeZone'),
                    'output' => array('ID','QuotaAmount','SetDate','IsConfirmed','IsExec','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'InsertQuotaStockPercent' => array(
                    'input' => array('StockSymbol','StockExchangeID','PercentPrice','CreatedBy'),
                    'output' => array('ID')
                    ),
      'UpdateQuotaStockPercent' => array(
                    'input' => array('QuotaStockPercentID','PercentPrice','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaStockPercentList' => array(
                    'input' => array('WhereClause','TimeZone'),
                    'output' => array('ID','PercentPrice','StockID','Symbol','StockExchangeID','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'GetQuotaStockPercentInfo' => array(
                    'input' => array('QuotaStockPercentID'),
                    'output' => array('ID','PercentPrice','StockID','Symbol','StockExchangeID')
                    ),
      'GetQuotaRateInfo' => array(
                    'input' => array('QuotaRateID'),
                    'output' => array('ID','RateProceeds','T')
                    ),
      'GetQuotaSettingInfo' => array(
                    'input' => array('QuotaSettingID'),
                    'output' => array('ID','QuotaAmount','SetDate')
                    ),
      'InsertQuotaAccount' => array(
                    'input' => array('AccountID','CreatedBy'),
                    'output' => array('ID')
                    ),
      'GetQuotaAccountList' => array(
                    'input' => array('AccountNo','CreatedBy','FromDate','ToDate'),
                    'output' => array('ID','AccountID','AccountNo','FullName','OrginalQuota','UsableQuota','DayToProceed','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'UpdateQuotaAccountDayToProceed' => array(
                    'input' => array('QuotaAccountID','DayToProceed','UpdatedBy'),
                    'output' => array()
                    ),
      'DeleteQuotaAccount' => array(
                    'input' => array('QuotaAccountID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaAccountInfo' => array(
                    'input' => array('QuotaAccountID'),
                    'output' => array('ID','AccountID','AccountNo','FullName','OrginalQuota','UsableQuota','DayToProceed','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'InsertQuotaTransfer' => array(
                    'input' => array('FromAccountID','ToAccountID','QuotaAmount','Note','CreatedBy'),
                    'output' => array('ID')
                    ),
      'DeleteQuotaTransfer' => array(
                    'input' => array('QuotaTransferID','UpdatedBy'),
                    'output' => array()
                    ),
      'ConfirmQuotaTransfer' => array(
                    'input' => array('QuotaTransferID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaTransferList' => array(
                    'input' => array('FromAccountNo','ToAccountNo','TransferDate','IsConfirmed','CreatedBy'),
                    'output' => array('ID','FromAccountID','ToAccountID','FromAccountNo','ToAccountNo','QuotaAmount','TransferDate','IsConfirmed','Note','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'GetQuotaAccountDetail' => array(
                    'input' => array('AccountNo'),
                    'output' => array('ID','AccountID','AccountNo','FullName','OrginalQuota','UsableQuota','DayToProceed','CardNo','Amount')
                    ),
      'InsertQuotaDepositWithdraw' => array(
                    'input' => array('AccountID','QuotaAmount','Note','Type','CreatedBy'),
                    'output' => array('ID')
                    ),
      'DeleteQuotaDepositWithdraw' => array(
                    'input' => array('QuotaDepositWithdrawID','UpdatedBy'),
                    'output' => array()
                    ),
      'ConfirmQuotaDepositWithdraw' => array(
                    'input' => array('QuotaDepositWithdrawID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaDepositWithdrawList' => array(
                    'input' => array('AccountNo','TradingDate','IsConfirmed','Type','CreatedBy'),
                    'output' => array('ID','AccountID','AccountNo','FullName','QuotaAmount','TradingDate','Note','IsConfirmed','Type','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'InsertQuotaPayment4TDebt' => array(
                    'input' => array('AccountID','Amount','CreatedBy'),
                    'output' => array('ID')
                    ),
      'DeleteQuotaPayment4TDebt' => array(
                    'input' => array('PaymentID','UpdatedBy'),
                    'output' => array()
                    ),
      'ConfirmQuotaPayment4TDebt' => array(
                    'input' => array('PaymentID','UpdatedBy'),
                    'output' => array()
                    ),
      'GetQuotaTDebtList' => array(
                    'input' => array('Where','TimeZone'),
                    'output' => array('ID','AccountID','AccountNo','FullName','PaymentAmount','DebtAmount','TradingDate','PaymentDate','IsPaid','NumDay','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'GetQuotaPayment4TDebtList' => array(
                    'input' => array('Where','TimeZone'),
                    'output' => array('ID','AccountID','AccountNo','FullName','PaymentAmount','TradingDate','IsConfirmed','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'GetQuotaPayment4TDebtInfo' => array(
                    'input' => array('Payment4TDebtID'),
                    'output' => array('AccountID','AccountNo','PaymentAmount','IsConfirmed')
                    ),
      'GetQuotaPayment4TDebtDetail' => array(
                    'input' => array('Payment4TDebtID'),
                    'output' => array('ID','TDebtID','Amount','DebtAmount','PaymentAmount')
                    ),
      'ConfirmPaymentInterest' => array(
                    'input' => array('TDebtInterestID','UpdatedBy'),
                    'output' => array('ID','AccountID','AccountNo','FullName','QuotaAmount','TradingDate','Note','IsConfirmed','Type','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'QuotaProcessReset' => array(
                    'input' => array('TradingDate','CreatedBy'),
                    'output' => array()
                    ),
      'QuotaProcessCalculate' => array(
                    'input' => array('TradingDate','CreatedBy'),
                    'output' => array()
                    ),
      'GetDebtInterestList' => array(
                    'input' => array('Where','TimeZone'),
                    'output' => array('ID','AccountNo','AccountID','FullName','InterestAmount','TradingDate','InterestRate','IsPaid','CreatedBy','UpdatedBy','CreatedDate','UpdatedDate')
                    ),
      'GetAccountDebt' => array(
                    'input' => array('AccountID'),
                    'output' => array('DebtAmount','DebtAmountTotal','PaymentAmount','InterestAmount')
                    ),
      'QuotaTDebt' => array(
                    'input' => array('TradingDate','CreatedBy'),
                    'output' => array()
                    ),
      'GetTDebtDetailList' => array(
                    'input' => array('TdebtID'),
                    'output' => array('TDebtID','OrderID','OrderNumber','Symbol','MatchedQuantity','MatchedPrice','TradingDate','PaymentDate')
                    ),
      'GetQuota4Bravo' => array(
                    'input' => array('TradingDate'),
                    'output' => array('AccountID','AccountNo','DebtAmount','BravoCode')
                    ),
      'InsertQuota4AcountVB' => array(
                    'input' => array('AccountID','AccountNo','Amount','Note','TradingDate','CreatedBy'),
                    'output' => array()
                    ),
      'InsertListOfQuota4AcountVB' => array(
                    'input' => array('TradingDate'),
                    'output' => array('AccountID','AccountNo','DebtAmount','BravoCode','ErrorCode')
                    ),
    );

    parent::__construct($arr);
  }
  // -------------------------------------------------------------------------------------------- //
  function __destruct() {
    $this->_MDB2->disconnect();
    $this->_MDB2_WRITE->disconnect();
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaRate($Rate, $TDate, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_insertQuotaRate('%s','%s','%s')", $Rate, $TDate, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40003;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function UpdateQuotaRate($QuotaRateID, $Rate, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'UpdateQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_updateQuotaRate('%s','%s','%s')", $QuotaRateID, $Rate, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40004;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaRate($QuotaRateID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_deleteQuotaRate('%s','%s')", $QuotaRateID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40005;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmQuotaRate($QuotaRateID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_confirmQuotaRate('%s','%s')", $QuotaRateID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40006;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteConfirmedQuotaRate($QuotaRateID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteConfirmedQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_deleteQuotaRateAfterConfirmed('%s','%s')", $QuotaRateID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40007;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaRateList($WhereClause, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaRateList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaRateList(\"%s\",'%s')", $WhereClause, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "RateProceeds"  => new SOAP_Value("RateProceeds", "string", $result[$i]['rateproceeds']),
            "T"             => new SOAP_Value("T", "string", $result[$i]['t']),
            "IsConfirmed"   => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function UpdateConfirmedQuotaRate($QuotaRateID, $Rate, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'UpdateConfirmedQuotaRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $log[] = sprintf('UpdateConfirmedQuotaRate - OldQuotaRateID:%s;UpdatedBy:%s;ExecutedTime:%s', $QuotaRateID, $UpdatedBy, date('Y-m-d h:i:s'));
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $log[] = sprintf('ErrorCode:%s(authenUser);', $this->_ERROR_CODE);
      write_my_log_path("UpdateConfirmedQuotaRate", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
    // ------------------------------------------------------------------------------------------ //
    // Get old Quota
    // ------------------------------------------------------------------------------------------ //
    $query  = sprintf( "CALL sp_quota_getQuotaRateList('id=%s AND IsConfirmed=1','+07:00')", $QuotaRateID);
    $mdb    = initWriteDB();
    $result = $mdb->extended->getAll($query);
    $count  = count($result);

    $log[]  = sprintf('Query:%s;Count:%s', $query, $count);

    if($count==1){
      $oldQuota = $result[0];
      // ---------------------------------------------------------------------------------------- //
      // Delete old Quota
      // ---------------------------------------------------------------------------------------- //
      $query  = sprintf( "CALL sp_quota_deleteQuotaRateAfterConfirmed('%s','%s')", $QuotaRateID, $UpdatedBy);
      $mdb    = initWriteDB();
      $result = $mdb->extended->getAll($query);

      if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
      else{
        $result = $result[0]['varerror'];
        if ($result < 0) {
          switch ($result) {
            case '-1':
              $this->_ERROR_CODE = 40002;
              break;

            case '-2':
              $this->_ERROR_CODE = 40007;
              break;
          }
        }
      }
      $log[] = sprintf('Query:%s;ErrorCode:%s', $query, $this->_ERROR_CODE);
      if($this->_ERROR_CODE != 0){
        write_my_log_path("UpdateConfirmedQuotaRate", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }
      // ---------------------------------------------------------------------------------------- //
      // Insert New Quota
      // ---------------------------------------------------------------------------------------- //
      $newQuotaRateID = 0;
      $query  = sprintf( "CALL sp_quota_insertQuotaRate('%s','%s','%s')", $Rate, $oldQuota['t'], $UpdatedBy);
      $mdb    = initWriteDB();
      $result = $mdb->extended->getAll($query);

      if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
      else{
        $result = $result[0]['varerror'];
        if ($result < 0) {
          switch ($result) {
            case '-1':
              $this->_ERROR_CODE = 40002;
              break;

            case '-2':
              $this->_ERROR_CODE = 40003;
              break;
          }
        } else {
          $newQuotaRateID = $result;
          $this->items[0] = new SOAP_Value(
            'item',
            $struct,
            array(
                "ID" => new SOAP_Value( "ID", "string", $result )
            )
          );
        }
      }
      $log[] = sprintf('Query:%s;ErrorCode:%s;NewID:%s', $query, $this->_ERROR_CODE, $newQuotaRateID);
      if($this->_ERROR_CODE != 0){
        write_my_log_path("UpdateConfirmedQuotaRate", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }
      // ---------------------------------------------------------------------------------------- //
      // Confirm New Quota
      // ---------------------------------------------------------------------------------------- //
      $query  = sprintf( "CALL sp_quota_confirmQuotaRate('%s','%s')", $newQuotaRateID, $UpdatedBy);
      $mdb    = initWriteDB();
      $result = $mdb->extended->getAll($query);

      if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
      else{
        $result = $result[0]['varerror'];
        if ($result < 0) {
          switch ($result) {
            case '-1':
              $this->_ERROR_CODE = 40002;
              break;

            case '-2':
              $this->_ERROR_CODE = 40006;
              break;
          }
        }
      }
      $log[] = sprintf('Query:%s;ErrorCode:%s', $query, $this->_ERROR_CODE);
    } else {
      $this->_ERROR_CODE = 88887;
      $log[] = sprintf('ErrorCode:%s', $this->_ERROR_CODE);
    }
    write_my_log_path("UpdateConfirmedQuotaRate", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaSetting($QuotaAmount, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaSetting';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_insertQuotaSetting('%s','%s')", $QuotaAmount, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40008;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function UpdateQuotaSetting($QuotaSettingID, $QuotaAmount, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'UpdateQuotaSetting';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_updateQuotaSetting('%s','%s','%s')", $QuotaSettingID, $QuotaAmount, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40009;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaSetting($QuotaSettingID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaSetting';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_deleteQuotaSetting('%s','%s')", $QuotaSettingID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40010;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmQuotaSetting($QuotaSettingID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmQuotaSetting';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_confirmQuotaSetting('%s','%s')", $QuotaSettingID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40011;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaSettingList($WhereClause, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaSettingList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaSettingList(\"%s\",'%s')", $WhereClause, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"          => new SOAP_Value("ID", "string", $result[$i]['id']),
            "QuotaAmount" => new SOAP_Value("QuotaAmount", "string", $result[$i]['quotaamount']),
            "SetDate"     => new SOAP_Value("SetDate", "string", $result[$i]['setdate']),
            "IsConfirmed" => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
            "IsExec"      => new SOAP_Value("IsExec", "string", $result[$i]['isexec']),
            "CreatedBy"   => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"   => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "CreatedDate" => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "UpdatedDate" => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaStockPercent($StockSymbol, $StockExchangeID, $PercentPrice, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaStockPercent';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_insertQuotaStockPercent('%s','%s','%s','%s')", $StockSymbol, $StockExchangeID, $PercentPrice, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40012;
            break;

          case '-3':
            $this->_ERROR_CODE = 40013;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function UpdateQuotaStockPercent($QuotaStockPercentID, $PercentPrice, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'UpdateQuotaStockPercent';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_updateQuotaStockPercent('%s','%s','%s')", $QuotaStockPercentID, $PercentPrice, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40014;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaStockPercentList($WhereClause, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaStockPercentList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaStockPercentList(\"%s\",'%s')", $WhereClause, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"              => new SOAP_Value("ID", "string", $result[$i]['id']),
            "PercentPrice"    => new SOAP_Value("PercentPrice", "string", $result[$i]['percentprice']),
            "StockID"         => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
            "Symbol"          => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
            "StockExchangeID" => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
            "CreatedBy"       => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"       => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "CreatedDate"     => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "UpdatedDate"     => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaStockPercentInfo($QuotaStockPercentID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaStockPercentInfo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaStockPercentInfo('%s')", $QuotaStockPercentID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"           => new SOAP_Value("ID", "string", $result[$i]['id']),
            "PercentPrice" => new SOAP_Value("PercentPrice", "string", $result[$i]['percentprice']),
            "StockID"      => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
            "Symbol"       => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
            "StockExchangeID" => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaRateInfo($QuotaRateID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaRateInfo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaRateInfo('%s')", $QuotaRateID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "RateProceeds"  => new SOAP_Value("RateProceeds", "string", $result[$i]['rateproceeds']),
            "T"             => new SOAP_Value("T", "string", $result[$i]['t']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaSettingInfo($QuotaSettingID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaSettingInfo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getQuotaSettingInfo('%s')", $QuotaSettingID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"          => new SOAP_Value("ID", "string", $result[$i]['id']),
            "QuotaAmount" => new SOAP_Value("QuotaAmount", "string", $result[$i]['quotaamount']),
            "SetDate"     => new SOAP_Value("SetDate", "string", $result[$i]['setdate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaAccount($AccountID, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaAccount';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_insert('%s','%s')", $AccountID, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40015;
            break;

          case '-3':
            $this->_ERROR_CODE = 40016;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaAccountList($AccountNo, $CreatedBy, $FromDate, $ToDate){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaAccountList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_List('%s','%s',%s,%s)", $AccountNo, $CreatedBy, empty($FromDate) ? 'null':"'$FromDate'", empty($ToDate) ? 'null':"'$ToDate'");
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "OrginalQuota"  => new SOAP_Value("OrginalQuota", "string", $result[$i]['orginalquota']),
            "UsableQuota"   => new SOAP_Value("UsableQuota", "string", $result[$i]['usablequota']),
            "DayToProceed"  => new SOAP_Value("DayToProceed", "string", $result[$i]['daytoproceed']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function UpdateQuotaAccountDayToProceed($QuotaAccountID, $DayToProceed, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'UpdateQuotaAccountDayToProceed';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_updateDayToProceed('%s','%s','%s')", $QuotaAccountID, $DayToProceed, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40017;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaAccount($QuotaAccountID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaAccount';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_delete('%s','%s')", $QuotaAccountID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40017;
            break;

          case '-3':
            $this->_ERROR_CODE = 40051;
            break;

          case '-4':
            $this->_ERROR_CODE = 40052;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaAccountInfo($QuotaAccountID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaAccountInfo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_info('%s')", $QuotaAccountID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "OrginalQuota"  => new SOAP_Value("OrginalQuota", "string", $result[$i]['orginalquota']),
            "UsableQuota"   => new SOAP_Value("UsableQuota", "string", $result[$i]['usablequota']),
            "DayToProceed"  => new SOAP_Value("DayToProceed", "string", $result[$i]['daytoproceed']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaTransfer($FromAccountID, $ToAccountID, $QuotaAmount, $Note, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaTransfer';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaTransfer_insert(%s,%s,%s,'%s','%s')", $FromAccountID, $ToAccountID, $QuotaAmount, $Note, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40018;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaTransfer($QuotaTransferID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaTransfer';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaTransfer_delete('%s','%s')", $QuotaTransferID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40019;
            break;

          case '-3':
            $this->_ERROR_CODE = 40020;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmQuotaTransfer($QuotaTransferID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmQuotaTransfer';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaTransfer_confirm('%s','%s')", $QuotaTransferID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-3':
            $this->_ERROR_CODE = 40020;
            break;

          case '-2':
            $this->_ERROR_CODE = 40021;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaTransferList($FromAccountNo, $ToAccountNo, $TransferDate, $IsConfirmed, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaTransferList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaTransfer_List('%s','%s',%s,%s,'%s')", $FromAccountNo, $ToAccountNo, (empty($TransferDate) ? 'null':"'$TransferDate'"), (empty($IsConfirmed) ? ($IsConfirmed=='' ? '-1' : "'$IsConfirmed'") : "'$IsConfirmed'"), $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "FromAccountID" => new SOAP_Value("FromAccountID", "string", $result[$i]['fromaccountid']),
            "ToAccountID"   => new SOAP_Value("ToAccountID", "string", $result[$i]['toaccountid']),
            "FromAccountNo" => new SOAP_Value("FromAccountNo", "string", $result[$i]['fromaccountno']),
            "ToAccountNo"   => new SOAP_Value("ToAccountNo", "string", $result[$i]['toaccountno']),
            "QuotaAmount"   => new SOAP_Value("QuotaAmount", "string", $result[$i]['quotaamount']),
            "TransferDate"  => new SOAP_Value("TransferDate", "string", $result[$i]['transferdate']),
            "IsConfirmed"   => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
            "Note"          => new SOAP_Value("Note", "string", $result[$i]['note']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaAccountDetail($AccountNo){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaAccountDetail';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_QuotaAccount_detail('%s')", $AccountNo );
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "OrginalQuota"  => new SOAP_Value("OrginalQuota", "string", $result[$i]['orginalquota']),
            "UsableQuota"   => new SOAP_Value("UsableQuota", "string", $result[$i]['usablequota']),
            "DayToProceed"  => new SOAP_Value("DayToProceed", "string", $result[$i]['daytoproceed']),
            "CardNo"        => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
            "Amount"        => new SOAP_Value("Amount", "string", $result[$i]['amount']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaDepositWithdraw($AccountID, $QuotaAmount, $Note, $Type, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaDepositWithdraw';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_DepositWithdraw_insert(%s,%s,'%s','%s','%s')", $AccountID, $QuotaAmount, $Note, $Type, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40022;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaDepositWithdraw($QuotaDepositWithdrawID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaDepositWithdraw';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_DepositWithdraw_delete(%s,'%s')", $QuotaDepositWithdrawID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40023;
            break;

          case '-3':
            $this->_ERROR_CODE = 40024;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmQuotaDepositWithdraw($QuotaDepositWithdrawID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmQuotaDepositWithdraw';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_DepositWithdraw_confirm(%s,'%s')", $QuotaDepositWithdrawID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-3':
            $this->_ERROR_CODE = 40024;
            break;

          case '-2':
            $this->_ERROR_CODE = 40025;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaDepositWithdrawList($AccountNo, $TradingDate, $IsConfirmed, $Type, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaDepositWithdrawList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if($IsConfirmed == '') $IsConfirmed = '-1';
    $query = sprintf( "CALL sp_quota_DepositWithdraw_List('%s','%s','%s','%s','%s')", $AccountNo, $TradingDate, $IsConfirmed, $Type, $CreatedBy);
    // return returnXML(func_get_args(), $this->class_name, $function_name, $query, $this->items, $this );
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "QuotaAmount"   => new SOAP_Value("QuotaAmount", "string", $result[$i]['quotaamount']),
            "TradingDate"   => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
            "Note"          => new SOAP_Value("Note", "string", $result[$i]['note']),
            "IsConfirmed"   => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
            "Type"          => new SOAP_Value("Type", "string", $result[$i]['type']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuotaPayment4TDebt($AccountID, $Amount, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuotaPayment4TDebt';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_insertPayment4TDebt(%s,%s,'%s')", $AccountID, $Amount, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40026;
            break;

          case '-3':
            $this->_ERROR_CODE = 40027;
            break;

          case '-4':
            $this->_ERROR_CODE = 40028;
            break;

          case '-5':
            $this->_ERROR_CODE = 40029;
            break;

          case '-6':
            $this->_ERROR_CODE = 40046;
            break;
        }
      } else {
        $this->items[0] = new SOAP_Value(
          'item',
          $struct,
          array(
              "ID"    => new SOAP_Value( "ID", "string", $result )
          )
        );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function DeleteQuotaPayment4TDebt($PaymentID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'DeleteQuotaPayment4TDebt';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_deletePayment4TDebt(%s,'%s')", $PaymentID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40030;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmQuotaPayment4TDebt($PaymentID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmQuotaPayment4TDebt';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_confirmPayment4TDebt(%s,'%s')", $PaymentID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40030;
            break;

          case '-3':
            $this->_ERROR_CODE = 40031;
            break;

          case '-4':
            $this->_ERROR_CODE = 40032;
            break;

          case '-5':
            $this->_ERROR_CODE = 40033;
            break;

          case '-6':
            $this->_ERROR_CODE = 40034;
            break;

          case '-7':
            $this->_ERROR_CODE = 40035;
            break;
        }
      }
    }
    if($this->_ERROR_CODE == 0){
      $query  = sprintf("CALL sp_quota_getPayment4TDebtInfo(%u)", $PaymentID);
      $mdb    = initWriteDB();
      $result = $mdb->extended->getAll($query);

      if(isset($result[0]['isconfirmed']) && $result[0]['isconfirmed'] == 1){
        $withdraw = array(
            "TradingDate"     => date("Y-m-d"),
            'TransactionType' => BRAVO_QUOTA_DEBT_PAYMENT,
            "AccountNo"       => $result[0]['accountno'],
            "Amount"          => $result[0]['paymentamount'],
            "Fee"             => $result[0]['paymentamount'],
            "Bank"            => VIRTUAL_BANK_BRAVO_BANKCODE,
            "Branch"          => "",
            "Note"            => 'Thu no han muc');

        $soap = &new Bravo();
        $ret  = $soap->withdraw($withdraw);

        if($ret['table0']['Result']!=1){
          switch ($ret['table0']['Result']) {
            case '-2':
              $this->_ERROR_CODE = 23002;
              break;

            case '-1':
              $this->_ERROR_CODE = 23003;
              break;

            case '-13':
              $this->_ERROR_CODE = 23006;
              break;

            case '-15':
              $this->_ERROR_CODE = 23005;
              break;

            case '-16':
              $this->_ERROR_CODE = 23004;
              break;

            default:
              $this->_ERROR_CODE = 'Bravo'. $ret['table0']['Result'];
          }
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaTDebtList($Where, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaTDebtList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getTDebtList(\"%s\",'%s')", $Where, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "PaymentAmount" => new SOAP_Value("PaymentAmount", "string", $result[$i]['paymentamount']),
            "DebtAmount"    => new SOAP_Value("DebtAmount", "string", $result[$i]['debtamount']),
            "TradingDate"   => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
            "PaymentDate"   => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
            "IsPaid"        => new SOAP_Value("IsPaid", "string", $result[$i]['ispaid']),
            "NumDay "       => new SOAP_Value("NumDay", "string", $result[$i]['numday']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaPayment4TDebtList($Where, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaPayment4TDebtList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getPayment4TDebtList(\"%s\",'%s')", $Where, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "FullName"      => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "PaymentAmount" => new SOAP_Value("PaymentAmount", "string", $result[$i]['paymentamount']),
            "TradingDate"   => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
            "IsConfirmed"   => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
            "CreatedDate"   => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "CreatedBy"     => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"     => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "UpdatedDate"   => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaPayment4TDebtInfo($Payment4TDebtID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaPayment4TDebtInfo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getPayment4TDebtInfo(%s)", $Payment4TDebtID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "AccountID"     => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"     => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "PaymentAmount"   => new SOAP_Value("PaymentAmount", "string", $result[$i]['paymentamount']),
            "IsConfirmed"   => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuotaPayment4TDebtDetail($Payment4TDebtID){
    $class_name = $this->class_name;
    $function_name = 'GetQuotaPayment4TDebtDetail';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_getPayment4TDebtDetail(%s)", $Payment4TDebtID);
    $result = $this->_MDB2->extended->getAll($query);
    $count = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
            "TDebtID"       => new SOAP_Value("TDebtID", "string", $result[$i]['tdebtid']),
            "Amount"        => new SOAP_Value("Amount", "string", $result[$i]['amount']),
            "DebtAmount"    => new SOAP_Value("DebtAmount", "string", $result[$i]['debtamount']),
            "PaymentAmount" => new SOAP_Value("PaymentAmount", "string", $result[$i]['paymentamount']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function ConfirmPaymentInterest($TDebtInterestID, $UpdatedBy){
    $class_name = $this->class_name;
    $function_name = 'ConfirmPaymentInterest';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_confirmPaymentInterest(%s,'%s')", $TDebtInterestID, $UpdatedBy);
    $result = $this->_MDB2->extended->getAll($query);
    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40036;
            break;

          case '-3':
            $this->_ERROR_CODE = 40037;
            break;

          case '-5':
            $this->_ERROR_CODE = 40038;
            break;

          default:
            $this->_ERROR_CODE = $result;
            break;
        }
      }
    }
    if($this->_ERROR_CODE == 0){
      $query  = sprintf("CALL sp_quota_getDebtInterestList(\" di.ID=%s AND di.IsPaid='1'\",'+00:07')", $TDebtInterestID);
      $mdb    = initWriteDB();
      $result = $mdb->extended->getAll($query);

      if(isset($result[0]['id']) && $result[0]['interestamount'] > 0){
        $withdraw = array(
            "TradingDate"     => date("Y-m-d"),
            'TransactionType' => BRAVO_QUOTA_INTEREST_PAYMENT,
            "AccountNo"       => $result[0]['accountno'],
            "Amount"          => $result[0]['interestamount'],
            "Fee"             => $result[0]['interestamount'],
            "Bank"            => VIRTUAL_BANK_BRAVO_BANKCODE,
            "Branch"          => "",
            "Note"            => 'Thu lai han muc');

        $soap = &new Bravo();
        $ret  = $soap->withdraw($withdraw);

        if($ret['table0']['Result']!=1){
          switch ($ret['table0']['Result']) {
            case '-2':
              $this->_ERROR_CODE = 23002;
              break;

            case '-1':
              $this->_ERROR_CODE = 23003;
              break;

            case '-13':
              $this->_ERROR_CODE = 23006;
              break;

            case '-15':
              $this->_ERROR_CODE = 23005;
              break;

            case '-16':
              $this->_ERROR_CODE = 23004;
              break;

            default:
              $this->_ERROR_CODE = 'Bravo'. $ret['table0']['Result'];
          }
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function QuotaProcessReset($TradingDate, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'QuotaProcessReset';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_process_reset('%s','%s')", $TradingDate, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);
    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40039;
            break;

          case '-3':
            $this->_ERROR_CODE = 40040;
            break;

          case '-4':
            $this->_ERROR_CODE = 40041;
            break;

          case '-5':
            $this->_ERROR_CODE = 40042;
            break;

          default:
            $this->_ERROR_CODE = $result;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function QuotaProcessCalculate($TradingDate, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'QuotaProcessCalculate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_quota_process_calculate('%s','%s')", $TradingDate, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);
    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40043;
            break;

          case '-3':
            $this->_ERROR_CODE = 40044;
            break;

          default:
            $this->_ERROR_CODE = $result;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetDebtInterestList($Where, $TimeZone){
    $class_name = $this->class_name;
    $function_name = 'GetDebtInterestList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf( "CALL sp_quota_getDebtInterestList(\"%s\",'%s')", $Where, $TimeZone);
    $result = $this->_MDB2->extended->getAll($query);
    $count  = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "ID"              => new SOAP_Value("ID", "string", $result[$i]['id']),
            "AccountNo"       => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "AccountID"       => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "FullName"        => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
            "InterestAmount"  => new SOAP_Value("InterestAmount", "string", $result[$i]['interestamount']),
            "TradingDate"     => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
            "InterestRate"    => new SOAP_Value("InterestRate", "string", $result[$i]['interestrate']),
            "IsPaid"          => new SOAP_Value("IsPaid", "string", $result[$i]['ispaid']),
            "CreatedDate"     => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
            "CreatedBy"       => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
            "UpdatedBy"       => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
            "UpdatedDate"     => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetAccountDebt($AccountID){
    $class_name = $this->class_name;
    $function_name = 'GetAccountDebt';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf( "CALL sp_quota_getAccountDebt(%s)", $AccountID);
    $result = $this->_MDB2->extended->getAll($query);
    $count  = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "DebtAmount"      => new SOAP_Value("DebtAmount", "string", $result[$i]['vardebtamount']),
            "DebtAmountTotal" => new SOAP_Value("DebtAmountTotal", "string", $result[$i]['vardebtamounttotal']),
            "PaymentAmount"   => new SOAP_Value("PaymentAmount", "string", $result[$i]['varpaymentamount']),
            "InterestAmount"  => new SOAP_Value("InterestAmount", "string", $result[$i]['varinterestamount']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function QuotaTDebt($TradingDate, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'QuotaTDebt';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf( "CALL sp_quota_QuotaTDebt('%s','%s')", $TradingDate, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);
    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40043;
            break;

          default:
            $this->_ERROR_CODE = $result;
            break;
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetTDebtDetailList($TdebtID){
    $class_name = $this->class_name;
    $function_name = 'GetTDebtDetailList';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf( "CALL sp_quota_getTDebtDetailList(%s)", $TdebtID);
    $result = $this->_MDB2->extended->getAll($query);
    $count  = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "TDebtID"         => new SOAP_Value("TDebtID", "string", $result[$i]['tdebtid']),
            "OrderID"         => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
            "OrderNumber"     => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
            "Symbol"          => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
            "MatchedQuantity" => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
            "MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
            "TradingDate"     => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
            "PaymentDate"     => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function GetQuota4Bravo($TradingDate){
    $class_name = $this->class_name;
    $function_name = 'GetQuota4Bravo';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf("CALL sp_quota_getQuota4Bravo('%s', %u)", $TradingDate, OFFLINE);
    $result = $this->_MDB2->extended->getAll($query);
    $count  = count($result);
    for($i=0; $i<$count; $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "AccountID"   => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"   => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "DebtAmount"  => new SOAP_Value("DebtAmount", "string", $result[$i]['debtamount']),
            "BravoCode"   => new SOAP_Value("BravoCode", "string", $result[$i]['bravocode']),
          )
      );
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertQuota4AcountVB($AccountID, $AccountNo, $Amount, $Note, $TradingDate, $CreatedBy){
    $class_name = $this->class_name;
    $function_name = 'InsertQuota4AcountVB';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query  = sprintf("CALL sp_quota_insertQuota4AccountVB(%u, %f, '%s', '%s', %u, '%s')", $AccountID, $Amount, $Note, $TradingDate, OFFLINE, $CreatedBy);
    $result = $this->_MDB2->extended->getAll($query);

    if(!isset($result[0]['varerror'])) $this->_ERROR_CODE = 40001;
    else{
      $result = $result[0]['varerror'];
      if ($result < 0) {
        switch ($result) {
          case '-1':
            $this->_ERROR_CODE = 40002;
            break;

          case '-2':
            $this->_ERROR_CODE = 40047;
            break;

          case '-3':
            $this->_ERROR_CODE = 40048;
            break;

          case '-4':
            $this->_ERROR_CODE = 40049;
            break;

          case '-5':
            $this->_ERROR_CODE = 40050;
            break;

          default:
            $this->_ERROR_CODE = $result;
            break;
        }
      }
    }
    if($this->_ERROR_CODE == 0){
      $deposit = array(
            "TradingDate"     => date("Y-m-d"),
            'TransactionType' => BRAVO_QUOTA,
            "AccountNo"       => $AccountNo,
            "Amount"          => $Amount,
            "Fee"             => $Amount,
            "Bank"            => VIRTUAL_BANK_BRAVO_BANKCODE,
            "Branch"          => "",
            "Note"            => 'Nop han muc');

      $soap = &new Bravo();
      $ret  = $soap->deposit($deposit);

      if($ret['table0']['Result']!=1){
        switch ($ret['table0']['Result']) {
          case '-2':
            $this->_ERROR_CODE = 23002;
            break;

          case '-1':
            $this->_ERROR_CODE = 23003;
            break;

          case '-13':
            $this->_ERROR_CODE = 23006;
            break;

          case '-15':
            $this->_ERROR_CODE = 23005;
            break;

          case '-16':
            $this->_ERROR_CODE = 23004;
            break;

          default:
            $this->_ERROR_CODE = 'Bravo'. $ret['table0']['Result'];
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
  function InsertListOfQuota4AcountVB($TradingDate){
    $class_name = $this->class_name;
    $function_name = 'InsertListOfQuota4AcountVB';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $log[] = sprintf('InsertListOfQuota4AcountVB - TradingDate:%s;BankID:%s;ExecutedTime:%s', $TradingDate, OFFLINE, date('Y-m-d h:i:s'));

    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $log[] = sprintf('ErrorCode:%s(authenUser);', $this->_ERROR_CODE);
      write_my_log_path("InsertListOfQuota4AcountVB", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    $query  = sprintf("CALL sp_quota_getQuota4Bravo('%s', %u)", $TradingDate, OFFLINE);
    $result = $this->_MDB2->extended->getAll($query);
    $count  = count($result);

    $log[]  = sprintf('Query:%s;Count:%s', $query, $count);
    $f_args = func_get_args();
    $argscount = count($f_args);

    for($i=0; $i<$count; $i++){
      $error_code = 0;

      $query   = sprintf("CALL sp_quota_insertQuota4AccountVB(%u, %f, '%s', '%s', %u, '%s')", $result[$i]['accountid'], $result[$i]['debtamount'], 'Nộp hạn mức', $TradingDate, OFFLINE, $f_args[$argscount-2]);
      $mdb     = initWriteDB();
      $result2 = $mdb->extended->getAll($query);

      $log[]   = sprintf('Query:%s; Times:%s', $query, $i);

      if(!isset($result2[0]['varerror'])) $error_code = 40001;
      else{
        $varerror = $result2[0]['varerror'];
        if ($varerror < 0) {
          switch ($varerror) {
            case '-1':
              $error_code = 40002;
              break;

            case '-2':
              $error_code = 40047;
              break;

            case '-3':
              $error_code = 40048;
              break;

            case '-4':
              $error_code = 40049;
              break;

            case '-5':
              $error_code = 40050;
              break;

            default:
              $error_code = $varerror;
              break;
          }
        }
      }

      $log[]   = sprintf('ErrorCode:%s;', $error_code);

      if($error_code == 0){
        $deposit = array(
              "TradingDate"     => date("Y-m-d"),
              'TransactionType' => BRAVO_QUOTA,
              "AccountNo"       => $result[$i]['accountno'],
              "Amount"          => $result[$i]['debtamount'],
              "Fee"             => $result[$i]['debtamount'],
              "Bank"            => VIRTUAL_BANK_BRAVO_BANKCODE,
              "Branch"          => "",
              "Note"            => 'Nop han muc');

        $log[] = sprintf('Bravo: TransactionType:%s;AccountNo:%s;Amount:%s;Fee:%s;Bank:%s;', BRAVO_QUOTA, $result[$i]['accountno'], $result[$i]['debtamount'], $result[$i]['debtamount'], VIRTUAL_BANK_BRAVO_BANKCODE);

        $soap  = &new Bravo();
        $ret   = $soap->deposit($deposit);

        if($ret['table0']['Result']!=1){
          switch ($ret['table0']['Result']) {
            case '-2':
              $error_code = 23002;
              break;

            case '-1':
              $error_code = 23003;
              break;

            case '-13':
              $error_code = 23006;
              break;

            case '-15':
              $error_code = 23005;
              break;

            case '-16':
              $error_code = 23004;
              break;

            default:
              $error_code = 'Bravo'. $ret['table0']['Result'];
          }
        }
        $log[] = sprintf('ErrorCode:%s;', $error_code);
      }

      if($error_code != 0){
        $this->_ERROR_CODE = $error_code;
        $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "AccountID"   => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
            "AccountNo"   => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
            "DebtAmount"  => new SOAP_Value("DebtAmount", "string", $result[$i]['debtamount']),
            "BravoCode"   => new SOAP_Value("BravoCode", "string", $result[$i]['bravocode']),
            "ErrorCode"   => new SOAP_Value("ErrorCode", "string", $error_code),
          )
        );
      }
    }
    $log[] = "\n\n";
    write_my_log_path("InsertListOfQuota4AcountVB", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/quota/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
  // -------------------------------------------------------------------------------------------- //
}
?>
