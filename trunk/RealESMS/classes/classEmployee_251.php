<?php
require_once('../includes.php');

/**
	Author: Ly Duong Duy Trung
	Created date: 03/13/2007
*/

class CEmployee extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;

	function CEmployee($check_ip) {
		//initialize MDB2
		$this->_MDB2 = initDB();
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		$this->class_name = get_class($this);
		$this->items = array();

		$arr = array( 'listGroups' => array( 'input' => array( 'TimeZone' ),
											'output' => array( 'ID', 'GroupName', 'Description', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')),

					'listFilterGroups' => array( 'input' => array( 'Where', 'TimeZone' ),
											'output' => array( 'ID', 'GroupName', 'Description', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')),

					'deleteGroup' => array( 'input' => array( 'GroupID', 'UpdatedBy'),
											'output' => array()),

					'insertGroup' => array( 'input' => array( 'GroupName', 'Description', 'CreatedBy'),
											'output' => array( 'ID' )),

					'updateGroup' => array( 'input' => array( 'GroupID', 'GroupName', 'Description', 'UpdatedBy'),
											'output' => array()),

					'insertEmployeeGroup' => array( 'input' => array( 'EmployeeID', 'GroupID', 'CreatedBy'),
											'output' => array( 'ID' )),

					'deleteEmployeeGroup' => array( 'input' => array( 'EmployeeID', 'GroupID', 'UpdatedBy'),
											'output' => array()),

					'listEmployeesInGroup' => array( 'input' => array( 'GroupID', 'TimeZone'),
											'output' => array( 'UserName', 'EmployeeID' )),

					'listEmployeesNotInGroup' => array( 'input' => array( 'GroupID', 'TimeZone'),
											'output' => array( 'UserName', 'EmployeeID' )),

//
					'insertGroupFunction' => array( 'input' => array( 'FunctionID', 'GroupID', 'CreatedBy'),
											'output' => array( 'ID' )),

					'deleteGroupFunction' => array( 'input' => array( 'GroupID' ),
											'output' => array()),

					'listFunctionsInGroup' => array( 'input' => array( 'GroupID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName', 'ParentID' )),

					'listFunctionsNotInGroup' => array( 'input' => array( 'GroupID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName' )),
//
					'listChildFunctions' => array( 'input' => array( 'FunctionID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName', 'Description' )),

					'listFunctions' => array( 'input' => array( 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName', 'Description' )),
//

					'listEmployees' => array( 'input' => array( 'TimeZone'),
											'output' => array( 'ID', 'UserName', 'PassWord', 'FirstName', 'LastName', 'Phone', 'CardNo', 'CardNoDate', 'CardNoIssuer',
																'ResidentAddress', 'Ethnic', 'BankAccount', 'BankName', 'DepartmentName', 'ContactAddress', 'IsActive',
																'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

					'listFilterEmployees' => array( 'input' => array( 'Where', 'TimeZone'),
											'output' => array( 'ID', 'UserName', 'PassWord', 'FirstName', 'LastName', 'Phone', 'CardNo', 'CardNoDate', 'CardNoIssuer',
																'ResidentAddress', 'Ethnic', 'BankAccount', 'BankName', 'DepartmentName', 'ContactAddress', 'IsActive',
																'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

					'deleteEmployee' => array( 'input' => array( 'EmployeeID', 'UpdatedBy'),
											'output' => array()),

					'insertEmployee' => array( 'input' => array( 'UserName', 'PassWord', 'FirstName', 'LastName', 'Phone',
																 'CardNo', 'CardNoDate', 'CardNoIssuer', 'ResidentAddress',
																'Ethnic', 'BankAccount', 'BankID', 'DepartmentID', 'ContactAddress',
																'IsActive', 'CreatedBy'),
											'output' => array( 'ID' )),

					'updateEmployee' => array( 'input' => array( 'EmployeeID', 'FirstName', 'LastName', 'Phone',
																 'CardNo', 'CardNoDate', 'CardNoIssuer', 'ResidentAddress',
																'Ethnic', 'BankAccount', 'BankID', 'DepartmentID', 'ContactAddress',
																'IsActive', 'UpdatedBy'),
											'output' => array()),
//
					'listGroupsContainEmployee' => array( 'input' => array( 'EmployeeID', 'TimeZone'),
											'output' => array( 'GroupID', 'GroupName' )),

					'listGroupsNotContainEmployee' => array( 'input' => array( 'EmployeeID', 'TimeZone'),
											'output' => array( 'GroupID', 'GroupName' )),
//
					'insertEmployeeFunction' => array( 'input' => array( 'EmployeeID', 'FunctionID', 'CreatedBy'),
											'output' => array( 'ID' )),

					'deleteEmployeeFunction' => array( 'input' => array( 'EmployeeID' ),
											'output' => array()),

					'listFunctionsBelongToEmployee' => array( 'input' => array( 'EmployeeID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName', 'ParentID' )),

					'listFunctionsNotBelongToEmployee' => array( 'input' => array( 'EmployeeID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName' )),

					'listAssignedFunctionsOfEmployee' => array( 'input' => array( 'EmployeeID', 'ParentID', 'TimeZone'),
											'output' => array( 'FunctionID', 'FunctionName' )),

					'listAssignedParentFunction' => array( 'input' => array( 'EmployeeID' ),
											'output' => array( 'FunctionID', 'FunctionName' )),
//
					'login' => array( 'input' => array(),
											'output' => array( 'ID', 'BranchID' )),

					'changePassword' => array( 'input' => array( 'UserName', 'OldPassword', 'NewPassword', 'UpdatedBy'),
											'output' => array()),

					'getBranchID' => array( 'input' => array( 'UserName' ),
											'output' => array( 'BranchID' )),

          'getFunctionWithParentID' => array(
                      'input' => array( 'ParentID', 'EmployeeID' ),
                      'output' => array( 'ID', 'FunctionName' )),

          'getAllFunctionList' => array(
                      'input' => array(),
                      'output' => array( 'ID', 'FunctionName', 'ParentID', 'Description' )),

          'insertSetOfEmployeeFunction' => array( 'input' => array( 'EmployeeID', 'SetOfFunctionID', 'CreatedBy'),
                      'output' => array( 'InsertedEmployeeFunctionID', 'SuccessdedFunctionID', 'FailedFunctionID' )),

          'insertSetOfEmployeeGroup' => array( 'input' => array( 'EmployeeID', 'SetOfGroupID', 'CreatedBy'),
                      'output' => array( 'InsertedEmployeeGroupID', 'SuccessdedGroupID', 'FailedGroupID' )),

          'deleteSetOfEmployeeGroup' => array( 'input' => array( 'EmployeeID', 'SetOfGroupID', 'UpdatedBy'),
                      'output' => array('SuccessdedGroupID', 'FailedGroupID')),

          'insertSetOfGroupFunction' => array( 'input' => array( 'GroupID', 'SetOfFunctionID', 'CreatedBy'),
                      'output' => array( 'InsertedGroupFunctionID', 'SuccessdedFunctionID', 'FailedFunctionID' )),

          'deleteSetOfFunction4Employee' => array( 'input' => array( 'EmployeeID', 'SetOfFunctionID', 'UpdatedBy'),
                      'output' => array('SuccessdedFunctionID', 'FailedFunctionID')),

          'deleteSetOfFunction4Group' => array( 'input' => array( 'GroupID', 'SetOfFunctionID', 'UpdatedBy'),
                      'output' => array('SuccessdedFunctionID', 'FailedFunctionID')),

          'insertSetOfEmployee4Group' => array( 'input' => array( 'GroupID', 'SetOfEmployeeID', 'CreatedBy'),
                      'output' => array( 'InsertedEmployeeGroupID', 'SuccessdedEmployeeID', 'FailedEmployeeID' )),

          'deleteSetOfEmployee4Group' => array( 'input' => array( 'GroupID', 'SetOfEmployeeID', 'UpdatedBy'),
                      'output' => array('SuccessdedEmployeeID', 'FailedEmployeeID')),

						);

		parent::__construct($arr);
	}

	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}

	/**
		Function: listGroups
		Description: list all Groups
		Input: time_zone
		Output: ???
	*/
    function listGroups($time_zone) {
		$function_name = 'listGroups';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, GroupName, Description, CreatedBy, Convert_TZ(%s.CreatedDate,'+00:00', '%s') as CreatedDate, UpdatedBy, Convert_TZ(%s.UpdatedDate ,'+00:00', '%s') as UpdatedDate
							FROM %s
							WHERE Deleted='0'", TBL_GROUP, $time_zone, TBL_GROUP, $time_zone, TBL_GROUP);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"GroupName"    => new SOAP_Value("GroupName", "string", $result[$i]['groupname']),
						"Description"    => new SOAP_Value("Description", "string", $result[$i]['description']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listFilterGroups
		Description: list groups with condition(s)
		Input: condition
		Output: ???
	*/
    function listFilterGroups($condition, $time_zone) {
		$function_name = 'listFilterGroups';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($condition)) {
			$this->_ERROR_CODE = 32001;
		} else {
			$query = sprintf( "SELECT ID, GroupName, Description, CreatedBy, Convert_TZ(%s.CreatedDate,'+00:00', '%s') as CreatedDate, UpdatedBy, Convert_TZ(%s.UpdatedDate,'+00:00', '%s') as UpdatedDate
								FROM %s
								WHERE Deleted='0'
								AND %s ", TBL_GROUP, $time_zone, TBL_GROUP, $time_zone, TBL_GROUP, $condition);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"GroupName"    => new SOAP_Value("GroupName", "string", $result[$i]['groupname']),
							"Description"    => new SOAP_Value("Description", "string", $result[$i]['description']),
							"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
							"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: deleteGroup
		Description: delete a Group
		Input: Group id
		Output: success / error code
	*/
	function deleteGroup($GroupID, $UpdatedBy){
		$function_name = 'deleteGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($GroupID) || !unsigned($GroupID) ) {
			$this->_ERROR_CODE = 32080;

		} else {
			/*$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);

			$mode = MDB2_AUTOQUERY_UPDATE;
			$where = sprintf(" ID=%u", $GroupID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_GROUP, $fields_values, $mode, $where);*/

			$query = sprintf( "CALL sp_deleteGroup(%u, '%s')", $GroupID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32081;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32082;
							break;

						case '-2':
							$this->_ERROR_CODE = 32083;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkexistGroupName
		Description: check a GroupName is Exist or not
		Input: GroupName
		Output: boolen
	*/
	function checkExistGroupName($GroupName)
	{
		$query = sprintf( "SELECT ID
							FROM %s
							WHERE GroupName='%s'
							AND Deleted='0'", TBL_GROUP, $GroupName);
		$result = $this->_MDB2->extended->getAll($query);
		if ( $result[0]['id'] > 0 )
			return $result[0]['id'];
		else
			return 0;
	}

	/**
		Function: insertGroup
		Description: insert a new Group
		Input: GroupName, Description, CreatedBy
		Output: success / error code
	*/
	function insertGroup($GroupName, $Description, $CreatedBy){
		$function_name = 'insertGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($GroupName)) {
			$this->_ERROR_CODE = 32090;

		} else {
			/*if ( $this->checkExistGroupName($GroupName) >0 ) {
				$this->_ERROR_CODE = 32030;
			} else {
				$fields_values = array("GroupName" => $GroupName,
										"Description" => $Description,
										"CreatedBy" => $CreatedBy,
										"CreatedDate" => $this->_MDB2_WRITE->date->mdbnow()
										);
				$mode = MDB2_AUTOQUERY_INSERT;
				$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_GROUP, $fields_values, $mode);*/

			$query = sprintf( "CALL sp_insertGroup('%s', '%s', '%s')", $GroupName, $Description, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32091;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32092;
							break;

						case '-2':
							$this->_ERROR_CODE = 32093;
							break;

						case '-3':
							$this->_ERROR_CODE = 32094;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateGroup
		Description: update the Group info
		Input: GroupID, GroupName, Description, UpdatedBy
		Output: success / error code
	*/
	function updateGroup($GroupID, $GroupName, $Description, $UpdatedBy){
		$function_name = 'updateGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($GroupID) || !unsigned($GroupID) || !required($GroupName)) {
			if (!required($GroupID) || !unsigned($GroupID) )
				$this->_ERROR_CODE = 32005;

			if (!required($GroupName))
				$this->_ERROR_CODE = 32006;

		} else {
			/*$fields_values = array("GroupName" => $GroupName,
									"Description" => $Description,
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);
			$mode = MDB2_AUTOQUERY_UPDATE;

			$where = sprintf(" ID=%u", $GroupID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_GROUP, $fields_values, $mode, $where);*/

			$query = sprintf( "CALL sp_updateGroup(%u, '%s', '%s', '%s')", $GroupID, $GroupName, $Description, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32007;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32002;
							break;

						case '-2':
							$this->_ERROR_CODE = 32003;
							break;

						case '-3':
							$this->_ERROR_CODE = 32004;
							break;

					}
				}
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: insertEmployeeGroup
		Description: insert an employee into a Group
		Input: EmployeeID, GroupID, CreatedBy
		Output: success / error code
	*/
	function insertEmployeeGroup($EmployeeID, $GroupID, $CreatedBy){
		$function_name = 'insertEmployeeGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) || !unsigned($GroupID) || !required($GroupID)) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32010;

			if (!required($GroupID) || !unsigned($GroupID))
				$this->_ERROR_CODE = 32011;

		} else {
			/*$fields_values = array("EmployeeID" => $EmployeeID,
									"GroupID" => $GroupID,
									"CreatedBy" => $CreatedBy,
									"CreatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);
			$mode = MDB2_AUTOQUERY_INSERT;
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE_GROUP, $fields_values, $mode);*/

			$query = sprintf( "CALL sp_insertEmployeeGroup(%u, %u, '%s')", $EmployeeID, $GroupID, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32012;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32013;
							break;

						case '-2':
							$this->_ERROR_CODE = 32014;
							break;

						case '-3':
							$this->_ERROR_CODE = 32015;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteEmployeeGroup
		Description: delete a EmployeeGroup
		Input: EmployeeID, GroupID
		Output: success / error code
	*/
	function deleteEmployeeGroup($EmployeeID, $GroupID, $UpdatedBy){
		$function_name = 'deleteEmployeeGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) || !unsigned($GroupID) || !required($GroupID)) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32070;

			if (!required($GroupID) || !unsigned($GroupID))
				$this->_ERROR_CODE = 32071;

		} else {

			$query = sprintf( "CALL sp_deleteEmployeeGroup(%u, %u, '%s')", $EmployeeID, $GroupID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32072;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32073;
							break;

						case '-2':
							$this->_ERROR_CODE = 32074;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listEmployeesInGroup
		Description: list employees of a group
		Input: GroupID
		Output: ???
	*/
    function listEmployeesInGroup($GroupID, $time_zone) {
		$function_name = 'listEmployeesInGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($GroupID) || !unsigned($GroupID)) {
			$this->_ERROR_CODE = 32016;
		} else {
//			 $query = sprintf( "SELECT DISTINCT %s.UserName, %s.ID
//								FROM %s, %s
//								WHERE %s.Deleted='0'
//								AND %s.ID=%s.EmployeeID
//								%s
//								AND %s.GroupID=%u ",
//						TBL_EMPLOYEE, TBL_EMPLOYEE,
//						TBL_EMPLOYEE_GROUP, TBL_EMPLOYEE,
//						TBL_EMPLOYEE,
//						TBL_EMPLOYEE, TBL_EMPLOYEE_GROUP,
//						ADMIN_USER_QUERY,
//						TBL_EMPLOYEE_GROUP, $GroupID);
      $query = sprintf("Call sp_getEmloyeeInGroupList('%s')", $GroupID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"UserName"    => new SOAP_Value("UserName", "string", $result[$i]['username']),
							"EmployeeID"    => new SOAP_Value("EmployeeID", "string", $result[$i]['id'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listEmployeesNotInGroup
		Description: list employees NOT IN a group
		Input: GroupID
		Output: ???
	*/
    function listEmployeesNotInGroup($GroupID, $time_zone) {
		$function_name = 'listEmployeesNotInGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 ) {
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		}

		if (!required($GroupID) || !unsigned($GroupID)) {
			$this->_ERROR_CODE = 32017;
		} else {
//			$query = sprintf( "SELECT %s.UserName, %s.ID
//							FROM %s
//							WHERE %s.Deleted='0'
//							%s
//							AND  %s.ID NOT IN (SELECT  %s.EmployeeID
//											FROM %s
//											WHERE %s.Deleted='0'
//											AND %s.GroupID=%u)",
//						TBL_EMPLOYEE, TBL_EMPLOYEE,
//						TBL_EMPLOYEE,
//						TBL_EMPLOYEE,
//						ADMIN_USER_QUERY,
//						TBL_EMPLOYEE,
//						TBL_EMPLOYEE_GROUP,
//						TBL_EMPLOYEE_GROUP,
//						TBL_EMPLOYEE_GROUP,
//						TBL_EMPLOYEE_GROUP, $GroupID);

			$query = sprintf("CALL sp_getEmployeeNotInGroupList('%s')", $GroupID);
      $result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"UserName"    => new SOAP_Value("UserName", "string", $result[$i]['username']),
							"EmployeeID"    => new SOAP_Value("EmployeeID", "string", $result[$i]['id'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: insertGroupFunction
		Description: insert a GroupFunction
		Input: FunctionID, GroupID, CreatedBy
		Output: success / error code
	*/
	function insertGroupFunction($FunctionID, $GroupID, $CreatedBy){
		$function_name = 'insertGroupFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($FunctionID) || !unsigned($FunctionID) || !unsigned($GroupID) || !required($GroupID)) {
			if (!required($FunctionID) || !unsigned($FunctionID))
				$this->_ERROR_CODE = 32100;

			if (!required($GroupID) || !unsigned($GroupID))
				$this->_ERROR_CODE = 32101;

		} else {
			/*if($this->checkExistGroupFunction($FunctionID, $GroupID) > 0) {
				$this->_ERROR_CODE = 32102;
			} else {
				$fields_values = array("FunctionID" => $FunctionID,
										"GroupID" => $GroupID,
										"CreatedBy" => $CreatedBy,
										"CreatedDate" => $this->_MDB2_WRITE->date->mdbnow()
										);
				$mode = MDB2_AUTOQUERY_INSERT;
				$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_GROUP_FUNCTION, $fields_values, $mode);*/

			$query = sprintf( "CALL sp_insertGroupFunction(%u, %u, '%s')", $FunctionID, $GroupID, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32103;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32104;
							break;

						case '-2':
							$this->_ERROR_CODE = 32105;
							break;

						case '-3':
							$this->_ERROR_CODE = 32102;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkexistGroupFunction
		Description: check a GroupFunction is Exist or not
		Input: FunctionID, GroupID
		Output: boolen
	*/
	function checkExistGroupFunction($FunctionID, $GroupID)
	{
		$query = sprintf( "SELECT ID
							FROM %s
							WHERE FunctionID=%u AND GroupID='%u'
							AND Deleted='0'", TBL_GROUP_FUNCTION, $FunctionID, $GroupID);
		$result = $this->_MDB2->extended->getAll($query);
		if ( $result[0]['id'] > 0 )
			return $result[0]['id'];
		else
			return 0;
	}

	/**
		Function: deleteGroupFunction
		Description: delete a GroupFunction
		Input: FunctionID, GroupID
		Output: success / error code

	function deleteGroupFunction($FunctionID, $GroupID, $UpdatedBy){
		$function_name = 'deleteGroupFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($FunctionID) || !unsigned($FunctionID) || !unsigned($GroupID) || !required($GroupID)) {
			if (!required($FunctionID) || !unsigned($FunctionID))
				$this->_ERROR_CODE = 32021;

			if (!required($GroupID) || !unsigned($GroupID))
				$this->_ERROR_CODE = 32022;

		} else {
			$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);

			$mode = MDB2_AUTOQUERY_UPDATE;
			$where = sprintf(" FunctionID=%u AND GroupID=%u", $FunctionID, $GroupID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE_FUNCTION, $fields_values, $mode, $where);

			if (empty( $rs))
				$this->_ERROR_CODE = 32023;

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	} */

	/**
		Function: deleteGroupFunction
		Description: delete a GroupFunction
		Input: GroupID
		Output: success / error code
	*/
	function deleteGroupFunction($GroupID){
		$function_name = 'deleteGroupFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!unsigned($GroupID) || !required($GroupID)) {
			if (!required($GroupID) || !unsigned($GroupID))
				$this->_ERROR_CODE = 32021;

		} else {
			$query = sprintf( "CALL sp_deleteGroupFunction(%u)", $GroupID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32022;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32023;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listFunctionsInGroup
		Description: list Functions of a group
		Input: GroupID
		Output: ???
	*/
    function listFunctionsInGroup($GroupID, $time_zone) {
    $function_name = 'listFunctionsInGroup';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if (!required($GroupID) || !unsigned($GroupID)) {
      $this->_ERROR_CODE = 32024;
    } else {
//      $query = sprintf( "SELECT %s.ID, %s.FunctionName
//                FROM %s, %s
//                WHERE %s.Deleted='0'
//                AND %s.Deleted='0'
//                AND %s.ID = %s.FunctionID
//                AND %s.GroupID=%u ",
//      TBL_FUNCTION, TBL_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_GROUP_FUNCTION, $GroupID);
      $query = sprintf("CALL sp_getGroupFunctionList('%s')", $GroupID);
      $result = $this->_MDB2->extended->getAll($query);
      for($i=0; $i<count($result); $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
              "FunctionName"  => new SOAP_Value("FunctionName", "string", $result[$i]['functionname']),
              "ParentID"      => new SOAP_Value("ParentID", "string", $result[$i]['parentid']),
              )
          );
        }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listFunctionsNotInGroup
		Description: list Functions not in a group
		Input: GroupID
		Output: ???
	*/
    function listFunctionsNotInGroup($GroupID, $time_zone) {
		$function_name = 'listFunctionsNotInGroup';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($GroupID) || !unsigned($GroupID)) {
			$this->_ERROR_CODE = 32025;
		} else {
			$query = sprintf( "SELECT %s.ID, %s.FunctionName
								FROM %s, %s
								WHERE %s.Deleted='0'
								AND %s.Deleted='0'
								AND %s.ID = %s.FunctionID
								AND %s.GroupID<>%u ",
			TBL_FUNCTION, TBL_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_FUNCTION, TBL_GROUP_FUNCTION, TBL_GROUP_FUNCTION, $GroupID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
							"FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: listChildFunctions
		Description: list all Functions
		Input: FunctionID
		Output: ???
	*/
    function listChildFunctions($FunctionID, $time_zone) {
    $function_name = 'listChildFunctions';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if (!required($FunctionID) || !unsigned($FunctionID)) {
      $this->_ERROR_CODE = 32026;
    } else {
//      $query = sprintf( "SELECT ID, FunctionName, Description
//                FROM %s
//                WHERE Deleted='0'
//                AND ParentID=%u", TBL_FUNCTION, $FunctionID);
      $query = sprintf("CALL sp_getChildFunctionList('%s')", $FunctionID);
      $result = $this->_MDB2->extended->getAll($query);
      for($i=0; $i<count($result); $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
              "FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname']),
              "Description"    => new SOAP_Value("Description", "string", $result[$i]['description'])
              )
          );
        }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listFunctions
		Description: list all Functions
		Input:
		Output: ???
	*/
    function listFunctions($time_zone) {
    $function_name = 'listFunctions';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

//    $query = sprintf( "SELECT ID, FunctionName, Description
//              FROM %s
//              WHERE Deleted='0'
//              AND ParentID=0", TBL_FUNCTION);
    $query = 'CALL sp_getFunctionList()';
    $result = $this->_MDB2->extended->getAll($query);
    for($i=0; $i<count($result); $i++) {
      $this->items[$i] = new SOAP_Value(
          'item',
          $struct,
          array(
            "FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
            "FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname']),
            "Description"    => new SOAP_Value("Description", "string", $result[$i]['description'])
            )
        );
      }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: listEmployees
		Description: list all Employees
		Input: time_zone
		Output: ???
	*/
    function listEmployees($time_zone) {
		$function_name = 'listEmployees';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "SELECT %s.ID, UserName, PassWord, FirstName, LastName, %s.Phone, CardNo, CardNoDate, CardNoIssuer, ResidentAddress,
									Ethnic, BankAccount, BankName, DepartmentName, ContactAddress, IF(IsActive='0', 'InActive', 'Active') as IsActive,
									%s.CreatedBy, Convert_TZ(%s.CreatedDate,'+00:00', '%s') as CreatedDate, %s.UpdatedBy, Convert_TZ(%s.UpdatedDate,'+00:00', '%s') as UpdatedDate
								FROM %s, %s, %s
								WHERE %s.Deleted='0'
								AND %s.ID = %s.BankID
								AND %s.ID = %s.DepartmentID
								%s ",
							TBL_EMPLOYEE, TBL_EMPLOYEE,
							TBL_EMPLOYEE, TBL_EMPLOYEE, $time_zone, TBL_EMPLOYEE, TBL_EMPLOYEE, $time_zone,
							 TBL_EMPLOYEE, TBL_DEPARTMENT, TBL_BANK,
							 TBL_EMPLOYEE,
							 TBL_BANK, TBL_EMPLOYEE,
							 TBL_DEPARTMENT, TBL_EMPLOYEE,
							 ADMIN_USER_QUERY);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"UserName"    => new SOAP_Value("UserName", "string", $result[$i]['username']),
						"PassWord"    => new SOAP_Value("PassWord", "string", $result[$i]['password']),
						"FirstName"    => new SOAP_Value("FirstName", "string", $result[$i]['firstname']),
						"LastName"    => new SOAP_Value("LastName", "string", $result[$i]['lastname']),
						"Phone" => new SOAP_Value("Phone", "string", $result[$i]['phone']),
						"CardNo"    => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
						"CardNoDate"    => new SOAP_Value("CardNoDate", "string", date_format(new DateTime($result[$i]['cardnodate']), "d/m/Y")),
						"CardNoIssuer"    => new SOAP_Value("CardNoIssuer", "string", $result[$i]['cardnoissuer']),
						"ResidentAddress"    => new SOAP_Value("ResidentAddress", "string", $result[$i]['residentaddress']),
						"Ethnic"    => new SOAP_Value("Ethnic", "string", $result[$i]['ethnic']),
						"BankAccount"    => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"DepartmentName"    => new SOAP_Value("DepartmentName", "string", $result[$i]['departmentname']),
						"ContactAddress"    => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
						"IsActive"    => new SOAP_Value("IsActive", "string", $result[$i]['isactive']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listFilterEmployees
		Description: list Employees with condition(s)
		Input: condition
		Output: ???
	*/
    function listFilterEmployees($condition, $time_zone) {
		$function_name = 'listFilterEmployees';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($condition)) {
			$this->_ERROR_CODE = 32027;
		} else {
			$query = sprintf( "SELECT %s.ID, UserName, PassWord, FirstName, LastName, %s.Phone, CardNo, CardNoDate, CardNoIssuer, ResidentAddress,
									Ethnic, BankAccount, BankName, DepartmentName, ContactAddress, IF(IsActive='0', 'InActive', 'Active') as IsActive,
									%s.CreatedBy, Convert_TZ(%s.CreatedDate,'+00:00', '%s') as CreatedDate, %s.UpdatedBy, Convert_TZ(%s.UpdatedDate,'+00:00', '%s') as UpdatedDate
								FROM %s, %s, %s
								WHERE %s.Deleted='0'
								AND %s.ID = %s.BankID
								AND %s.ID = %s.DepartmentID
								%s
								AND %s",
							TBL_EMPLOYEE, TBL_EMPLOYEE,
							TBL_EMPLOYEE, TBL_EMPLOYEE, $time_zone, TBL_EMPLOYEE, TBL_EMPLOYEE, $time_zone,
							 TBL_EMPLOYEE, TBL_DEPARTMENT, TBL_BANK,
							 TBL_EMPLOYEE,
							 TBL_BANK, TBL_EMPLOYEE,
							 TBL_DEPARTMENT, TBL_EMPLOYEE,
							 ADMIN_USER_QUERY,
							 $condition);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"               => new SOAP_Value("ID", "string", $result[$i]['id']),
              "UserName"         => new SOAP_Value("UserName", "string", $result[$i]['username']),
              "PassWord"         => new SOAP_Value("PassWord", "string", $result[$i]['password']),
              "FirstName"        => new SOAP_Value("FirstName", "string", $result[$i]['firstname']),
              "LastName"         => new SOAP_Value("LastName", "string", $result[$i]['lastname']),
              "Phone"            => new SOAP_Value("Phone", "string", $result[$i]['phone']),
              "CardNo"           => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
              "CardNoDate"       => new SOAP_Value("CardNoDate", "string", date_format(new DateTime($result[$i]['cardnodate']), "d/m/Y")),
              "CardNoIssuer"     => new SOAP_Value("CardNoIssuer", "string", $result[$i]['cardnoissuer']),
              "ResidentAddress"  => new SOAP_Value("ResidentAddress", "string", $result[$i]['residentaddress']),
              "Ethnic"           => new SOAP_Value("Ethnic", "string", $result[$i]['ethnic']),
              "BankAccount"      => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
              "BankName"         => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
              "DepartmentName"   => new SOAP_Value("DepartmentName", "string", $result[$i]['departmentname']),
              "ContactAddress"   => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
              "IsActive"         => new SOAP_Value("IsActive", "string", $result[$i]['isactive']),
              "CreatedBy"        => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
              "CreatedDate"      => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
              "UpdatedBy"        => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
              "UpdatedDate"      => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: deleteEmployee
		Description: delete a Employee
		Input: Employee id
		Output: success / error code
	*/
	function deleteEmployee($EmployeeID, $UpdatedBy){
		$function_name = 'deleteEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($EmployeeID) || !unsigned($EmployeeID) ) {
			$this->_ERROR_CODE = 32060;

		} else {
			/*$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);

			$mode = MDB2_AUTOQUERY_UPDATE;
			$where = sprintf(" ID=%u", $EmployeeID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE, $fields_values, $mode, $where);*/

			$query = sprintf( "CALL sp_deleteEmployee(%u, '%s')", $EmployeeID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32061;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32062;
							break;


						case '-2':
							$this->_ERROR_CODE = 32063;
							break;					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkExistUserName
		Description: check a GroupFunction is Exist or not
		Input: Username
		Output: boolen
	*/
	function checkExistUserName($Username)
	{
		$query = sprintf( "SELECT ID
							FROM %s
							WHERE Deleted='0'
							AND UserName='%s'", TBL_EMPLOYEE, $Username);
		$result = $this->_MDB2->extended->getAll($query);
		if ( count($result) > 0)
			return true;
		return false;
	}

	/**
		Function: insertEmployee
		Description: insert a new Employee
		Input: UserName, PassWord, FirstName, LastName, CardNo, CardNoDate, CardNoIssuer, ResidentAddress,
				Ethnic, BankAccount, BankID, DepartmentID, ContactAddress, IsActive, CreatedBy
		Output: success / error code
	*/
	function insertEmployee($UserName, $PassWord, $FirstName, $LastName, $Phone, $CardNo, $CardNoDate, $CardNoIssuer, $ResidentAddress,
				$Ethnic, $BankAccount, $BankID, $DepartmentID, $ContactAddress, $IsActive, $CreatedBy){
		$function_name = 'insertEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($UserName) || !required($PassWord) || !required($FirstName) || !required($LastName) || !required($IsActive)) {
			if (!required($UserName))
				$this->_ERROR_CODE = 32110;

			if (!required($PassWord))
				$this->_ERROR_CODE = 32111;

			if (!required($FirstName))
				$this->_ERROR_CODE = 32112;

			if (!required($LastName))
				$this->_ERROR_CODE = 32113;

			if (!required($IsActive))
				$this->_ERROR_CODE = 32114;

		} else {
			/*if ( $this->checkExistUserName($UserName) > 0 ) {
				$this->_ERROR_CODE = 32037;
			} else {
				$fields_values = array( 'UserName' => $UserName,
										'PassWord' => $PassWord,
										'FirstName' => $FirstName,
										'LastName' => $LastName,
										'Phone' => $Phone,
										'CardNo' => $CardNo,
										'CardNoDate' => $CardNoDate,
										'CardNoIssuer' => $CardNoIssuer,
										'ResidentAddress' => $ResidentAddress,
										'Ethnic' => $Ethnic,
										'BankAccount' => $BankAccount,
										'BankID' => $BankID,
										'DepartmentID' => $DepartmentID,
										'ContactAddress' => $ContactAddress,
										'IsActive' => $IsActive,
										"CreatedBy" => $CreatedBy,
										"CreatedDate" => $this->_MDB2_WRITE->date->mdbnow()
										);
				$mode = MDB2_AUTOQUERY_INSERT;
				$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE, $fields_values, $mode);

				if (empty( $rs))
					$this->_ERROR_CODE = 32036;
				else
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $this->_MDB2_WRITE->lastInsertID() )
								)
						);
			}*/

			$query = sprintf( "CALL sp_insertEmployee('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %u, %u, '%s', '%s', '%s')",
								$UserName, $PassWord, $FirstName, $LastName, $CardNo, $CardNoDate, $CardNoIssuer, $Phone, $ResidentAddress, $Ethnic, $BankAccount, $BankID, $DepartmentID, $ContactAddress, $IsActive, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32115;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32116;
							break;

						case '-2':
							$this->_ERROR_CODE = 32117;
							break;

						case '-3':
							$this->_ERROR_CODE = 32118;
							break;

						case '-4':
							$this->_ERROR_CODE = 32119;
							break;

						case '-5':
							$this->_ERROR_CODE = 32110;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateEmployee
		Description: update a new Employee
		Input: ID, UserName, PassWord, FirstName, LastName, CardNo, CardNoDate, CardNoIssuer, ResidentAddress,
				Ethnic, BankAccount, BankID, DepartmentID, ContactAddress, IsActive, CreatedBy
		Output: success / error code
	*/
	function updateEmployee($EmployeeID, $FirstName, $LastName, $Phone, $CardNo, $CardNoDate, $CardNoIssuer, $ResidentAddress,
				$Ethnic, $BankAccount, $BankID, $DepartmentID, $ContactAddress, $IsActive, $UpdatedBy){
		$function_name = 'updateEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($FirstName) || !required($LastName) || !required($IsActive) || !required($EmployeeID) || !unsigned($EmployeeID)) {
			if (!required($FirstName))
				$this->_ERROR_CODE = 32030;

			if (!required($LastName))
				$this->_ERROR_CODE = 32031;

			if (!required($IsActive))
				$this->_ERROR_CODE = 32032;

			if (!required($EmployeeID) || !unsigned($EmployeeID)) {
				$this->_ERROR_CODE = 32033;
			}

		} else {
			/*$fields_values = array(	'FirstName' => $FirstName,
									'LastName' => $LastName,
									'Phone' => $Phone,
									'CardNo' => $CardNo,
									'CardNoDate' => $CardNoDate,
									'CardNoIssuer' => $CardNoIssuer,
									'ResidentAddress' => $ResidentAddress,
									'Ethnic' => $Ethnic,
									'BankAccount' => $BankAccount,
									'BankID' => $BankID,
									'DepartmentID' => $DepartmentID,
									'ContactAddress' => $ContactAddress,
									'IsActive' => $IsActive,
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);
			$mode = MDB2_AUTOQUERY_UPDATE;
			$where = sprintf(" ID=%u", $EmployeeID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE, $fields_values, $mode, $where);*/

			$query = sprintf( "CALL sp_updateEmployee(%u, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %u, %u, '%s', '%s', '%s') ",
										$EmployeeID, $FirstName, $LastName, $CardNo, $CardNoDate, $CardNoIssuer, $Phone, $ResidentAddress, $Ethnic, $BankAccount, $BankID, $DepartmentID, $ContactAddress, $IsActive, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32034;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32035;
							break;

						case '-2':
							$this->_ERROR_CODE = 32036;
							break;

						case '-3':
							$this->_ERROR_CODE = 32037;
							break;

						case '-4':
							$this->_ERROR_CODE = 32038;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/**
		Function: listGroupsContainEmployee
		Description: list groups of employee
		Input: EmployeeID
		Output: ???
	*/
    function listGroupsContainEmployee($EmployeeID, $time_zone) {
		$function_name = 'listGroupsContainEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID)) {
			$this->_ERROR_CODE = 32044;
		} else {
			 $query = sprintf( " SELECT DISTINCT GroupID, GroupName
			 					FROM  %s e, %s g
								WHERE g.ID = e.GroupID
								AND e.Deleted='0'
								AND  e.EmployeeID=%u ",
							TBL_EMPLOYEE_GROUP, TBL_GROUP, $EmployeeID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"GroupID"    => new SOAP_Value("GroupID", "string", $result[$i]['groupid']),
							"GroupName"    => new SOAP_Value("GroupName", "string", $result[$i]['groupname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listGroupsNotContainEmployee
		Description: list groups not containing employee
		Input: EmployeeID
		Output: ???
	*/
    function listGroupsNotContainEmployee($EmployeeID, $time_zone) {
		$function_name = 'listGroupsNotContainEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID)) {
			$this->_ERROR_CODE = 32045;
		} else {
			 $query = sprintf( " SELECT ID, GroupName
								FROM %s
								WHERE Deleted='0'
								AND ID NOT IN ( SELECT GroupID
											FROM %s
											WHERE Deleted = '0'
											AND EmployeeID = %u
											GROUP BY GroupID ) ",
							TBL_GROUP, TBL_EMPLOYEE_GROUP, $EmployeeID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"GroupID"    => new SOAP_Value("GroupID", "string", $result[$i]['id']),
							"GroupName"    => new SOAP_Value("GroupName", "string", $result[$i]['groupname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: checkExistEmployeeFunction
		Description: check a EmployeeFunction is Exist or not
		Input: FunctionID, EmployeeID
		Output: boolen
	*/
	function checkExistEmployeeFunction($FunctionID, $EmployeeID)
	{
		$query = sprintf( "SELECT ID
							FROM %s
							WHERE FunctionID=%u
							AND EmployeeID=%u
							AND Deleted='0'", TBL_EMPLOYEE_FUNCTION, $FunctionID, $EmployeeID);
		$result = $this->_MDB2->extended->getAll($query);
		if ($result[0]['id'] > 0)
			return $result[0]['id'];
		else
			return 0;
	}

	/**
		Function: insertEmployeeFunction
		Description: insert a function for an employee
		Input: EmployeeID, FunctionID, CreatedBy
		Output: success / error code
	*/
	function insertEmployeeFunction($EmployeeID, $FunctionID, $CreatedBy){
		$function_name = 'insertEmployeeFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) || !unsigned($FunctionID) || !required($FunctionID)) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32130;

			if (!required($FunctionID) || !unsigned($FunctionID))
				$this->_ERROR_CODE = 32131;

		} else {
			/*if ( $this->checkExistEmployeeFunction($FunctionID, $EmployeeID) > 0 ) {
				$this->_ERROR_CODE = 32057;
			} else {
				$fields_values = array("EmployeeID" => $EmployeeID,
										"FunctionID" => $FunctionID,
										"CreatedBy" => $CreatedBy,
										"CreatedDate" => $this->_MDB2_WRITE->date->mdbnow()
										);
				$mode = MDB2_AUTOQUERY_INSERT;
				$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE_FUNCTION, $fields_values, $mode);

				if (empty( $rs))
					$this->_ERROR_CODE = 32048;
				else
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $this->_MDB2_WRITE->lastInsertID() )
								)
						);
			}*/

			$query = sprintf( "CALL sp_insertEmployeeFunction(%u, %u, '%s')", $EmployeeID, $FunctionID, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32132;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32133;
							break;

						case '-2':
							$this->_ERROR_CODE = 32134;
							break;

						case '-3':
							$this->_ERROR_CODE = 32135;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteEmployeeFunction
		Description: delete a EmployeeFunction
		Input: EmployeeID, FunctionID
		Output: success / error code

	function deleteEmployeeFunction($EmployeeID, $FunctionID, $UpdatedBy){
		$function_name = 'deleteEmployeeFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) || !unsigned($FunctionID) || !required($FunctionID)) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32049;

			if (!required($FunctionID) || !unsigned($FunctionID))
				$this->_ERROR_CODE = 32050;

		} else {
			$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);

			$mode = MDB2_AUTOQUERY_UPDATE;
			$where = sprintf(" EmployeeID=%u AND FunctionID=%u", $EmployeeID, $FunctionID);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE_FUNCTION, $fields_values, $mode, $where);

			if (empty( $rs))
				$this->_ERROR_CODE = 32051;

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}*/

	/**
		Function: deleteEmployeeFunction
		Description: delete a EmployeeFunction
		Input: EmployeeID
		Output: success / error code
	*/

	function deleteEmployeeFunction($EmployeeID){
		$function_name = 'deleteEmployeeFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) ) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32049;

		} else {
			$query = sprintf( "CALL sp_deleteEmployeeFunction(%u)", $EmployeeID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 32050;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 32051;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listFunctionsBelongToEmployee
		Description: list functions belong to employee
		Input: EmployeeID
		Output: ???
	*/
    function listFunctionsBelongToEmployee($EmployeeID, $time_zone) {
    $function_name = 'listFunctionsBelongToEmployee';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if (!required($EmployeeID) || !unsigned($EmployeeID)) {
      $this->_ERROR_CODE = 32052;
    } else {
//       $query = sprintf( " SELECT DISTINCT FunctionID, FunctionName
//                FROM  %s e, %s f
//                WHERE f.ID = e.FunctionID
//                AND e.Deleted='0'
//                AND  e.EmployeeID=%u ",
//              TBL_EMPLOYEE_FUNCTION, TBL_FUNCTION, $EmployeeID);
      $query = sprintf("CALL sp_getEmployeeFunctionList('%s')", $EmployeeID);
      $result = $this->_MDB2->extended->getAll($query);
      for($i=0; $i<count($result); $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['functionid']),
              "FunctionName"  => new SOAP_Value("FunctionName", "string", $result[$i]['functionname']),
              "ParentID"      => new SOAP_Value("ParentID", "string", $result[$i]['parentid'])
              )
          );
        }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listFunctionsNotBelongToEmployee
		Description: list functions not belong to employee
		Input: EmployeeID
		Output: ???
	*/
    function listFunctionsNotBelongToEmployee($EmployeeID, $time_zone) {
		$function_name = 'listFunctionsNotBelongToEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID)) {
			$this->_ERROR_CODE = 32053;
		} else {
			 $query = sprintf( " SELECT ID, FunctionName
								FROM %s
								WHERE Deleted='0'
								AND ID NOT IN	(SELECT FunctionID
											FROM %s
											WHERE Deleted = '0'
											AND EmployeeID = %u
											GROUP BY FunctionID ) ",
							TBL_FUNCTION, TBL_EMPLOYEE_FUNCTION, $EmployeeID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
							"FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listAssignedFunctionsOfEmployee
		Description: list functions assigned to employee
		Input: EmployeeID, ParentID
		Output: ???
	*/
    function listAssignedFunctionsOfEmployee($EmployeeID, $ParentID, $time_zone) {
		$function_name = 'listAssignedFunctionsOfEmployee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) || !required($ParentID) || !unsigned($ParentID)) {
			if (!required($EmployeeID) || !unsigned($EmployeeID))
				$this->_ERROR_CODE = 32054;

			if (!required($ParentID) || !unsigned($ParentID))
				$this->_ERROR_CODE = 32055;
		} else {
			if ( checkIsAdmin($EmployeeID) ) {
				$query = sprintf( "SELECT ID, FunctionName FROM %s WHERE Deleted='0' AND ParentID=%u ", TBL_FUNCTION, $ParentID );
			} else {
				$query = sprintf( " SELECT %s.ID, FunctionName
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND %s.FunctionID = %s.ID
									AND %s.EmployeeID=%u
									AND %s.ParentID=%u
									UNION DISTINCT
									SELECT %s.ID AS FunctionID, FunctionName
									FROM %s, %s, %s
									WHERE %s.Deleted='0'
									AND %s.EmployeeID = %u
									AND %s.ID = %s.FunctionID
									AND %s.GroupID = %s.GroupID ",
								TBL_FUNCTION,
								TBL_EMPLOYEE_FUNCTION, TBL_FUNCTION,
								TBL_FUNCTION,
								TBL_EMPLOYEE_FUNCTION, TBL_FUNCTION,
								TBL_EMPLOYEE_FUNCTION, $EmployeeID,
								TBL_FUNCTION, $ParentID,
								// UNION
								TBL_FUNCTION,
								TBL_EMPLOYEE_GROUP, TBL_GROUP_FUNCTION, TBL_FUNCTION,
								TBL_FUNCTION,
								TBL_EMPLOYEE_GROUP, $EmployeeID,
								TBL_FUNCTION, TBL_GROUP_FUNCTION,
								TBL_EMPLOYEE_GROUP, TBL_GROUP_FUNCTION

								);
			}
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['id']),
							"FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }


	/**
		Function: listAssignedParentFunction
		Description: list functions assigned to employee
		Input: EmployeeID
		Output: ???
	*/
    function listAssignedParentFunction($EmployeeID) {
		$function_name = 'listAssignedParentFunction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($EmployeeID) || !unsigned($EmployeeID) ) {
			$this->_ERROR_CODE = 32058;
		} else {
			if ( checkIsAdmin($EmployeeID) ) {
				$query = sprintf( "SELECT ID, FunctionName FROM %s WHERE Deleted='0' AND ParentID=0 ", TBL_FUNCTION );
			} else {
				$query = sprintf( " SELECT %s.ID AS FunctionID, FunctionName
										FROM %s, %s
										WHERE %s.Deleted='0'
										AND EmployeeID = %u
										AND ParentID = 0
										AND %s.FunctionID = %s.ID
										UNION DISTINCT
										SELECT %s.ID AS FunctionID, FunctionName
										FROM %s, %s, %s
										WHERE %s.Deleted='0'
										AND %s.EmployeeID = %u
										AND %s.ID = %s.FunctionID
										AND %s.GroupID = %s.GroupID  ",
								TBL_FUNCTION,
								TBL_EMPLOYEE_FUNCTION, TBL_FUNCTION,
								TBL_FUNCTION,
								$EmployeeID,
								TBL_EMPLOYEE_FUNCTION, TBL_FUNCTION,
								// UNION
								TBL_FUNCTION,
								TBL_EMPLOYEE_GROUP, TBL_GROUP_FUNCTION, TBL_FUNCTION,
								TBL_FUNCTION,
								TBL_EMPLOYEE_GROUP, $EmployeeID,
								TBL_FUNCTION, TBL_GROUP_FUNCTION,
								TBL_EMPLOYEE_GROUP, TBL_GROUP_FUNCTION
								);
			}

			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FunctionID"    => new SOAP_Value("FunctionID", "string", $result[$i]['functionid']),
							"FunctionName"    => new SOAP_Value("FunctionName", "string", $result[$i]['functionname'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: login
		Description: login
		Input:
		Output: ???
	*/
    function login() {
		$function_name = 'login';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$list_args = func_get_args();
		$authen_query = sprintf( "CALL sp_ServiceLogin('%s', '%s')", $list_args[0], $list_args[1] );
		$result = $this->_MDB2->extended->getAll($authen_query);
		if ($result[0]['varerror'] < 0) {
			$this->_ERROR_CODE = 10014;
		} else {
			$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result[0]['varerror'] ),
								"BranchID"    => new SOAP_Value( "BranchID", "string", $result[0]['varbranchid'] ),
								)
						);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: changePassword
		Description: change user password
		Input:
		Output: ???
	*/
    function changePassword($UserName, $OldPassword, $NewPassword, $UpdatedBy) {
		$function_name = 'changePassword';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( " SELECT ID
							FROM %s
							WHERE Deleted='0'
							AND UserName='%s'
							AND PassWord='%s'",
							TBL_EMPLOYEE, $UserName, $OldPassword);
		$result = $this->_MDB2->extended->getAll($query);
		$id = $result[0]['id'];

		if ( $id > 0 ) {
			$fields_values = array("PassWord" => $NewPassword,
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);
			$mode = MDB2_AUTOQUERY_UPDATE;

			$where = sprintf(" ID=%u", $id);
			$rs = $this->_MDB2_WRITE->extended->autoExecute(TBL_EMPLOYEE, $fields_values, $mode, $where);

			if (empty( $rs))
				$this->_ERROR_CODE = 10016;

		} else {
			$this->_ERROR_CODE = 10015;
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getBranchID($UserName) {
		$function_name = 'getBranchID';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT f_getBranchIDForUser('%s') as  BranchID", $UserName);
		$result = $this->_MDB2->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"BranchID"    => new SOAP_Value( "BranchID", "string", $result['branchid'] ),
								)
						);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getFunctionWithParentID($ParentID, $EmployeeID)
    {
      $function_name = 'getFunctionWithParentID';
      $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      $query = sprintf( "CALL sp_getFunctionWithParentID('%s', '%s')", $ParentID, $EmployeeID);
      $result = $this->_MDB2->extended->getAll($query);
      for($i=0; $i<count($result); $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
              "FunctionName"  => new SOAP_Value("FunctionName", "string", $result[$i]['functionname'])
              )
          );
      }
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getAllFunctionList()
    {
      $function_name = 'getAllFunctionList';
      $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      $query = 'CALL sp_getAllFunctionList()';
      $result = $this->_MDB2->extended->getAll($query);
      for($i=0; $i<count($result); $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "ID"            => new SOAP_Value("ID", "string", $result[$i]['id']),
              "FunctionName"  => new SOAP_Value("FunctionName", "string", $result[$i]['functionname']),
              "Description"   => new SOAP_Value("Description", "string", $result[$i]['description']),
              "ParentID"      => new SOAP_Value("ParentID", "string", $result[$i]['parentid'])
              )
          );
        }
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertSetOfEmployeeFunction($EmployeeID, $SetOfFunctionID, $CreatedBy){
    $function_name = 'insertSetOfEmployeeFunction';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $insert_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $insert_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("insertSetOfEmployeeFunction", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($EmployeeID) || !unsigned($EmployeeID) || !required($SetOfFunctionID)) {
      if (!required($EmployeeID) || !unsigned($EmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32130;
      if (!required($SetOfFunctionID))
        $this->_ERROR_CODE = $lastest_error = 32131;

      $insert_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_func = explode(',', $SetOfFunctionID);
      $insert_success  = array();
      $insert_fail     = array();
      $inserted_id     = array();

      $insert_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;CreatedBy:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $CreatedBy, date('Y-m-d h:i:s'));
      foreach($arr_func as $func_id){
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($func_id)){
          $this->_ERROR_CODE = 32131;
          $insert_fail[] = trim($func_id);
        }
        else{
          $query = sprintf( "CALL sp_insertEmployeeFunction(%u, %u, '%s')", $EmployeeID, trim($func_id), $CreatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32132;
            $insert_fail[] = trim($func_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $insert_fail[] = trim($func_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32133;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32134;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 32135;
                  break;

              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $insert_success[] = trim($func_id);
          $inserted_id[]    = $result;
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }

        $insert_log[] = sprintf('EmployeeID:%s;FunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, trim($func_id), $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }
      $this->items[] = new SOAP_Value(
                'item',
                $struct,
                array(
                  "InsertedEmployeeFunctionID" => new SOAP_Value( "InsertedEmployeeFunctionID", "string", implode(', ', $inserted_id) ),
                  "SuccessdedFunctionID"       => new SOAP_Value( "SuccessdedFunctionID", "string", implode(', ', $insert_success) ),
                  "FailedFunctionID"           => new SOAP_Value( "FailedFunctionID", "string", implode(', ', $insert_fail) ),
                  )
              );
    }
    write_my_log_path("insertSetOfEmployeeFunction", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function insertSetOfEmployeeGroup($EmployeeID, $SetOfGroupID, $CreatedBy){
    $function_name = 'insertSetOfEmployeeGroup';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $insert_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $insert_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("insertSetOfEmployeeGroup", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($EmployeeID) || !unsigned($EmployeeID) || !required($SetOfGroupID)) {
      if (!required($EmployeeID) || !unsigned($EmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32010;

      if (!required($SetOfGroupID))
        $this->_ERROR_CODE = $lastest_error = 32011;

      $insert_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_group = explode(',', $SetOfGroupID);
      $insert_success  = array();
      $insert_fail     = array();
      $inserted_id     = array();

      $insert_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;CreatedBy:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $CreatedBy, date('Y-m-d h:i:s'));
      foreach($arr_group as $group_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($group_id)){
          $this->_ERROR_CODE = 32011;
          $insert_fail[] = trim($group_id);
        }
        else{
          $query = sprintf( "CALL sp_insertEmployeeGroup(%u, %u, '%s')", $EmployeeID, trim($group_id), $CreatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32012;
            $insert_fail[] = trim($group_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $insert_fail[] = trim($group_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32013;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32014;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 32015;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $insert_success[] = trim($group_id);
          $inserted_id[]    = $result;
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $insert_log[] = sprintf('EmployeeID:%s;GroupID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, trim($group_id), $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }
      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "InsertedEmployeeGroupID"   => new SOAP_Value( "InsertedEmployeeGroupID", "string", implode(', ', $inserted_id) ),
            "SuccessdedGroupID"         => new SOAP_Value( "SuccessdedGroupID", "string", implode(', ', $insert_success) ),
            "FailedGroupID"             => new SOAP_Value( "FailedGroupID", "string", implode(', ', $insert_fail) ),
          )
        );
    }
    write_my_log_path("insertSetOfEmployeeGroup", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function deleteSetOfEmployeeGroup($EmployeeID, $SetOfGroupID, $UpdatedBy){
    $function_name = 'deleteSetOfEmployeeGroup';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $delete_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $delete_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("deleteSetOfEmployeeGroup", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($EmployeeID) || !unsigned($EmployeeID) || !required($SetOfGroupID)) {
      if (!required($EmployeeID) || !unsigned($EmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32070;

      if (!required($SetOfGroupID))
        $this->_ERROR_CODE = $lastest_error = 32071;

      $delete_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_group = explode(',', $SetOfGroupID);
      $delete_success  = array();
      $delete_fail     = array();

      $delete_log[] = sprintf('EmployeeID:%s;SetOfGroupID:%s;UpdatedBy:%s;ExecutedTime:%s', $EmployeeID, $SetOfGroupID, $UpdatedBy, date('Y-m-d h:i:s'));
      foreach($arr_group as $group_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($group_id)){
          $this->_ERROR_CODE = 32071;
          $delete_fail[] = trim($group_id);
        }
        else{
          $query = sprintf( "CALL sp_deleteEmployeeGroup(%u, %u, '%s')", $EmployeeID, trim($group_id), $UpdatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32072;
            $delete_fail[] = trim($group_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $delete_fail[] = trim($group_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32073;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32074;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $delete_success[] = trim($group_id);
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $delete_log[] = sprintf('EmployeeID:%s;GroupID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, trim($group_id), $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }

      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "SuccessdedGroupID" => new SOAP_Value( "SuccessdedGroupID", "string", implode(', ', $delete_success) ),
            "FailedGroupID"     => new SOAP_Value( "FailedGroupID", "string", implode(', ', $delete_fail)),
          )
        );
    }
    write_my_log_path("deleteSetOfEmployeeGroup", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function insertSetOfGroupFunction($GroupID, $SetOfFunctionID, $CreatedBy){
    $function_name = 'insertSetOfGroupFunction';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $insert_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $insert_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("insertSetOfGroupFunction", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($SetOfFunctionID) || !unsigned($GroupID) || !required($GroupID)) {
      if (!required($SetOfFunctionID))
        $this->_ERROR_CODE = $lastest_error = 32100;

      if (!required($GroupID) || !unsigned($GroupID))
        $this->_ERROR_CODE = $lastest_error = 32101;

      $insert_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_func = explode(',', $SetOfFunctionID);
      $insert_success  = array();
      $insert_fail     = array();
      $inserted_id     = array();

      $insert_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;CreatedBy:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $CreatedBy, date('Y-m-d h:i:s'));
      foreach($arr_func as $func_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($func_id)){
          $this->_ERROR_CODE = 32100;
          $insert_fail[] = trim($func_id);
        }
        else{
          $query = sprintf( "CALL sp_insertGroupFunction(%u, %u, '%s')", trim($func_id), $GroupID, $CreatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32103;
            $insert_fail[] = trim($func_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $insert_fail[] = trim($func_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32104;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32105;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 32102;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $insert_success[] = trim($func_id);
          $inserted_id[]    = $result;
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $insert_log[] = sprintf('GroupID:%s;FunctionID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, trim($func_id), $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }
      $this->items[] = new SOAP_Value(
                'item',
                $struct,
                array(
                  "InsertedGroupFunctionID"    => new SOAP_Value( "InsertedGroupFunctionID", "string", implode(', ', $inserted_id) ),
                  "SuccessdedFunctionID"       => new SOAP_Value( "SuccessdedFunctionID", "string", implode(', ', $insert_success) ),
                  "FailedFunctionID"           => new SOAP_Value( "FailedFunctionID", "string", implode(', ', $insert_fail) ),
                  )
              );
    }
    write_my_log_path("insertSetOfGroupFunction", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function deleteSetOfFunction4Employee($EmployeeID, $SetOfFunctionID, $UpdatedBy){
    $function_name = 'deleteSetOfFunction4Employee';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $delete_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $delete_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("deleteSetOfFunction4Employee", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($EmployeeID) || !unsigned($EmployeeID) || !required($SetOfFunctionID)) {
      if (!required($EmployeeID) || !unsigned($EmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32070;

      if (!required($SetOfFunctionID))
        $this->_ERROR_CODE = $lastest_error = 32100;

      $delete_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_func = explode(',', $SetOfFunctionID);
      $delete_success  = array();
      $delete_fail     = array();

      $delete_log[] = sprintf('EmployeeID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ExecutedTime:%s', $EmployeeID, $SetOfFunctionID, $UpdatedBy, date('Y-m-d h:i:s'));
      foreach($arr_func as $func_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($func_id)){
          $this->_ERROR_CODE = 32100;
          $delete_fail[] = trim($func_id);
        }
        else{
          $query = sprintf( "CALL sp_deleteFunction4Employee(%u, %u, '%s')", $EmployeeID, trim($func_id), $UpdatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32072;
            $delete_fail[] = trim($func_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $delete_fail[] = trim($func_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32073;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $delete_success[] = trim($func_id);
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $delete_log[] = sprintf('EmployeeID:%s;FunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $EmployeeID, trim($func_id), $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }

      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "SuccessdedFunctionID" => new SOAP_Value( "SuccessdedFunctionID", "string", implode(', ', $delete_success) ),
            "FailedFunctionID"     => new SOAP_Value( "FailedFunctionID", "string", implode(', ', $delete_fail)),
          )
        );
    }
    write_my_log_path("deleteSetOfFunction4Employee", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function deleteSetOfFunction4Group($GroupID, $SetOfFunctionID, $UpdatedBy){
    $function_name = 'deleteSetOfFunction4Group';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $delete_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $delete_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("deleteSetOfFunction4Group", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($GroupID) || !unsigned($GroupID) || !required($SetOfFunctionID)) {
      if (!required($GroupID) || !unsigned($GroupID))
        $this->_ERROR_CODE = $lastest_error = 32071;

      if (!required($SetOfFunctionID))
        $this->_ERROR_CODE = $lastest_error = 32100;

      $delete_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_func = explode(',', $SetOfFunctionID);
      $delete_success  = array();
      $delete_fail     = array();

      $delete_log[] = sprintf('GroupID:%s;SetOfFunctionID:%s;UpdatedBy:%s;ExecutedTime:%s', $GroupID, $SetOfFunctionID, $UpdatedBy, date('Y-m-d h:i:s'));
      foreach($arr_func as $func_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($func_id)){
          $this->_ERROR_CODE = 32100;
          $delete_fail[] = trim($func_id);
        }
        else{
          $query = sprintf( "CALL sp_deleteFunction4Group(%u, %u, '%s')", $GroupID, trim($func_id), $UpdatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32072;
            $delete_fail[] = trim($func_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $delete_fail[] = trim($func_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32073;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $delete_success[] = trim($func_id);
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $delete_log[] = sprintf('GroupID:%s;FunctionID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, trim($func_id), $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }

      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "SuccessdedFunctionID" => new SOAP_Value( "SuccessdedFunctionID", "string", implode(', ', $delete_success) ),
            "FailedFunctionID"     => new SOAP_Value( "FailedFunctionID", "string", implode(', ', $delete_fail)),
          )
        );
    }
    write_my_log_path("deleteSetOfFunction4Group", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function insertSetOfEmployee4Group($GroupID, $SetOfEmployeeID, $CreatedBy){
    $function_name = 'insertSetOfEmployee4Group';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $insert_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $insert_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("insertSetOfEmployee4Group", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($GroupID) || !unsigned($GroupID) || !required($SetOfEmployeeID)) {
      if (!required($GroupID) || !unsigned($GroupID))
        $this->_ERROR_CODE = $lastest_error = 32071;

      if (!required($SetOfEmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32070;

      $insert_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_emp         = explode(',', $SetOfEmployeeID);
      $insert_success  = array();
      $insert_fail     = array();
      $inserted_id     = array();

      $insert_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;CreatedBy:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $CreatedBy, date('Y-m-d h:i:s'));
      foreach($arr_emp as $emp_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($emp_id)){
          $this->_ERROR_CODE = 32070;
          $insert_fail[] = trim($emp_id);
        }
        else{
          $query = sprintf( "CALL sp_insertEmployeeGroup(%u, %u, '%s')", trim($emp_id), $GroupID, $CreatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32012;
            $insert_fail[] = trim($emp_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $insert_fail[] = trim($emp_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32013;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32014;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 32015;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $insert_success[] = trim($emp_id);
          $inserted_id[]    = $result;
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $insert_log[] = sprintf('GroupID:%s;EmployeeID:%s;CreatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, trim($emp_id), $CreatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }
      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "InsertedEmployeeGroupID" => new SOAP_Value( "InsertedEmployeeGroupID", "string", implode(', ', $inserted_id) ),
            "SuccessdedEmployeeID"    => new SOAP_Value( "SuccessdedEmployeeID", "string", implode(', ', $insert_success) ),
            "FailedEmployeeID"        => new SOAP_Value( "FailedEmployeeID", "string", implode(', ', $insert_fail) ),
          )
        );
    }
    write_my_log_path("insertSetOfEmployee4Group", implode("\n --> ",$insert_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

  function deleteSetOfEmployee4Group($GroupID, $SetOfEmployeeID, $UpdatedBy){
    $function_name = 'deleteSetOfEmployee4Group';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $delete_log  = array();
    $lastest_error = 0;
    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $delete_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      write_my_log_path("deleteSetOfEmployee4Group", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    if (!required($GroupID) || !unsigned($GroupID) || !required($SetOfEmployeeID)) {
      if (!required($GroupID) || !unsigned($GroupID))
        $this->_ERROR_CODE = $lastest_error = 32071;

      if (!required($SetOfEmployeeID))
        $this->_ERROR_CODE = $lastest_error = 32070;

      $delete_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
    } else {
      $arr_epm         = explode(',', $SetOfEmployeeID);
      $delete_success  = array();
      $delete_fail     = array();

      $delete_log[] = sprintf('GroupID:%s;SetOfEmployeeID:%s;UpdatedBy:%s;ExecutedTime:%s', $GroupID, $SetOfEmployeeID, $UpdatedBy, date('Y-m-d h:i:s'));
      foreach($arr_epm as $emp_id)
      {
        $this->_ERROR_CODE = 0;
        $result = NULL;

        if (!unsigned($emp_id)){
          $this->_ERROR_CODE = 32070;
          $delete_fail[] = trim($emp_id);
        }
        else{
          $query = sprintf( "CALL sp_deleteEmployeeGroup(%u, %u, '%s')", trim($emp_id), $GroupID, $UpdatedBy);
          $mdb = initWriteDB();
          $rs  = $mdb->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 32072;
            $delete_fail[] = trim($emp_id);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              $delete_fail[] = trim($emp_id);
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 32073;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 32074;
                  break;
              }
            }
          }
        }
        if($this->_ERROR_CODE == 0){
          $delete_success[] = trim($emp_id);
        } else {
          $lastest_error    = $this->_ERROR_CODE;
        }
        $delete_log[] = sprintf('GroupID:%s;EmployeeID:%s;UpdatedBy:%s;ErrorCode:%s;ExecutedTime:%s', $GroupID, trim($emp_id), $UpdatedBy, $this->_ERROR_CODE, date('Y-m-d h:i:s'));
      }

      $this->items[] = new SOAP_Value(
          'item',
          $struct,
          array(
            "SuccessdedEmployeeID" => new SOAP_Value( "SuccessdedEmployeeID", "string", implode(', ', $delete_success) ),
            "FailedEmployeeID"     => new SOAP_Value( "FailedEmployeeID", "string", implode(', ', $delete_fail)),
          )
        );
    }
    write_my_log_path("deleteSetOfEmployee4Group", implode("\n --> ",$delete_log), '/home/vhosts/eSMS/htdocs/logs/employee/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $lastest_error, $this->items, $this );
  }

}
?>