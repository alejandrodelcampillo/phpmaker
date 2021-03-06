<?php
namespace PHPMaker2019\demo2019;

/**
 * Page class
 */
class products_edit extends products
{

	// Page ID
	public $PageID = "edit";

	// Project ID
	public $ProjectID = "{DFB61542-7FFC-43AB-88E7-31D7F8D95066}";

	// Table name
	public $TableName = 'products';

	// Page object name
	public $PageObjName = "products_edit";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken = CHECK_TOKEN;
	public $CheckTokenFn;
	public $CreateTokenFn;
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message <> "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fa fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fa fa-warning"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage <> "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fa fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fa fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = array();

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message <> "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage <> "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage <> "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage <> "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header <> "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer <> "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(TOKEN_NAME) === NULL)
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn(Post(TOKEN_NAME), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;

		//if ($this->CheckToken) { // Always create token, required by API file/lookup request
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$CurrentToken = $this->Token; // Save to global variable

		//}
	}

	// Constructor
	public function __construct()
	{
		global $Conn, $Language, $COMPOSITE_KEY_SEPARATOR;

		// Initialize
		$this->CheckTokenFn = PROJECT_NAMESPACE . "CheckToken";
		$this->CreateTokenFn = PROJECT_NAMESPACE . "CreateToken";
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (products)
		if (!isset($GLOBALS["products"]) || get_class($GLOBALS["products"]) == PROJECT_NAMESPACE . "products") {
			$GLOBALS["products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["products"];
		}

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'edit');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'products');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($Conn))
			$Conn = GetConnection($this->Dbid);
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EXPORT, $products;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($products);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url <> "") {
			if (!DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "productsview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = array();
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = array();
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {

								//$url = FullUrl($fld->TableVar . "/" . API_FILE_ACTION . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))); // URL rewrite format
								$url = FullUrl(GetPageName(API_URL) . "?" . API_OBJECT_NAME . "=" . $fld->TableVar . "&" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&" . API_FIELD_NAME . "=" . $fld->Param . "&" . API_KEY_NAME . "=" . rawurlencode($this->getRecordKeyValue($ar))); // Query string format
								$row[$fldname] = ["mimeType" => ContentType($val), "url" => $url];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, MULTIPLE_UPLOAD_SEPARATOR)) { // Single file
								$row[$fldname] = ["mimeType" => MimeContentType($val), "url" => FullUrl($fld->hrefPath() . $val)];
							} else { // Multiple files
								$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
								$ar = [];
								foreach ($files as $file) {
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => FullUrl($fld->hrefPath() . $file)];
								}
								$row[$fldname] = $ar;
							}
						}
					} else {
						$row[$fldname] = $val;
					}
				}
			}
		}
		return $row;
	}

	// Get record key value from array
	protected function getRecordKeyValue($ar)
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['ProductID'];
		}
		return $key;
	}

	/**
	 * Hide fields for add/edit
	 *
	 * @return void
	 */
	protected function hideFieldsForAddEdit()
	{
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->ProductID->Visible = FALSE;
	}
	public $FormClassName = "ew-horizontal ew-form ew-edit-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter;
	public $DbDetailFilter;
	public $DisplayRecs = 1;
	public $StartRec;
	public $StopRec;
	public $TotalRecs = 0;
	public $RecRange = 10;
	public $Pager;
	public $AutoHidePager = AUTO_HIDE_PAGER;
	public $RecCnt;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . "CheckToken";
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->ProductID->setVisibility();
		$this->ProductName->setVisibility();
		$this->SupplierID->setVisibility();
		$this->CategoryID->setVisibility();
		$this->QuantityPerUnit->setVisibility();
		$this->UnitPrice->setVisibility();
		$this->UnitsInStock->setVisibility();
		$this->UnitsOnOrder->setVisibility();
		$this->ReorderLevel->setVisibility();
		$this->Discontinued->setVisibility();
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up lookup cache
		// Check modal

		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-edit-form ew-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$returnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (IsApi()) {
			$this->CurrentAction = "update"; // Update record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get action code
			if (!$this->isShow()) // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($CurrentForm->hasValue("x_ProductID")) {
				$this->ProductID->setFormValue($CurrentForm->getValue("x_ProductID"));
			}
		} else {
			$this->CurrentAction = "show"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (Get("ProductID") !== NULL) {
				$this->ProductID->setQueryStringValue(Get("ProductID"));
				$loadByQuery = TRUE;
			} else {
				$this->ProductID->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($rs = $this->loadRecordset()) // Load records
			$this->TotalRecs = $rs->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$this->terminate("productslist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->setupStartRec(); // Set up start record position

			// Point to current record
			if ($this->StartRec <= $this->TotalRecs) {
				$rs->move($this->StartRec - 1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if ($this->ProductID->CurrentValue != NULL) {
				while (!$rs->EOF) {
					if (SameString($this->ProductID->CurrentValue, $rs->fields('ProductID'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$rs->moveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->loadRowValues($rs);

		// Process form if post back
		if ($postBack) {
			$this->loadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->setFailureMessage($FormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues();
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = ""; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "show": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
					$this->terminate("productslist.php"); // Return to list page
				} else {
				}
				break;
			case "update": // Update
				$returnUrl = $this->getReturnUrl();
				if (GetPageName($returnUrl) == "productslist.php")
					$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->editRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
					if (IsApi()) {
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl); // Return to caller
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
					$this->terminate($returnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render the record
		$this->RowType = ROWTYPE_EDIT; // Render as Edit
		$this->resetAttributes();
		$this->renderRow();
	}

	// Set up starting record parameters
	public function setupStartRec()
	{
		if ($this->DisplayRecs == 0)
			return;
		if ($this->isPageRequest()) { // Validate request
			if (Get(TABLE_START_REC) !== NULL) { // Check for "start" parameter
				$this->StartRec = Get(TABLE_START_REC);
				$this->setStartRecordNumber($this->StartRec);
			} elseif (Get(TABLE_PAGE_NO) !== NULL) {
				$pageNo = Get(TABLE_PAGE_NO);
				if (is_numeric($pageNo)) {
					$this->StartRec = ($pageNo - 1) * $this->DisplayRecs + 1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1) {
						$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->StartRec > $this->TotalRecs) { // Avoid starting record > total records
			$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec - 1) % $this->DisplayRecs <> 0) {
			$this->StartRec = (int)(($this->StartRec - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'ProductID' first before field var 'x_ProductID'
		$val = $CurrentForm->hasValue("ProductID") ? $CurrentForm->getValue("ProductID") : $CurrentForm->getValue("x_ProductID");
		if (!$this->ProductID->IsDetailKey)
			$this->ProductID->setFormValue($val);

		// Check field name 'ProductName' first before field var 'x_ProductName'
		$val = $CurrentForm->hasValue("ProductName") ? $CurrentForm->getValue("ProductName") : $CurrentForm->getValue("x_ProductName");
		if (!$this->ProductName->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->ProductName->Visible = FALSE; // Disable update for API request
			else
				$this->ProductName->setFormValue($val);
		}

		// Check field name 'SupplierID' first before field var 'x_SupplierID'
		$val = $CurrentForm->hasValue("SupplierID") ? $CurrentForm->getValue("SupplierID") : $CurrentForm->getValue("x_SupplierID");
		if (!$this->SupplierID->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->SupplierID->Visible = FALSE; // Disable update for API request
			else
				$this->SupplierID->setFormValue($val);
		}

		// Check field name 'CategoryID' first before field var 'x_CategoryID'
		$val = $CurrentForm->hasValue("CategoryID") ? $CurrentForm->getValue("CategoryID") : $CurrentForm->getValue("x_CategoryID");
		if (!$this->CategoryID->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->CategoryID->Visible = FALSE; // Disable update for API request
			else
				$this->CategoryID->setFormValue($val);
		}

		// Check field name 'QuantityPerUnit' first before field var 'x_QuantityPerUnit'
		$val = $CurrentForm->hasValue("QuantityPerUnit") ? $CurrentForm->getValue("QuantityPerUnit") : $CurrentForm->getValue("x_QuantityPerUnit");
		if (!$this->QuantityPerUnit->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->QuantityPerUnit->Visible = FALSE; // Disable update for API request
			else
				$this->QuantityPerUnit->setFormValue($val);
		}

		// Check field name 'UnitPrice' first before field var 'x_UnitPrice'
		$val = $CurrentForm->hasValue("UnitPrice") ? $CurrentForm->getValue("UnitPrice") : $CurrentForm->getValue("x_UnitPrice");
		if (!$this->UnitPrice->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->UnitPrice->Visible = FALSE; // Disable update for API request
			else
				$this->UnitPrice->setFormValue($val);
		}

		// Check field name 'UnitsInStock' first before field var 'x_UnitsInStock'
		$val = $CurrentForm->hasValue("UnitsInStock") ? $CurrentForm->getValue("UnitsInStock") : $CurrentForm->getValue("x_UnitsInStock");
		if (!$this->UnitsInStock->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->UnitsInStock->Visible = FALSE; // Disable update for API request
			else
				$this->UnitsInStock->setFormValue($val);
		}

		// Check field name 'UnitsOnOrder' first before field var 'x_UnitsOnOrder'
		$val = $CurrentForm->hasValue("UnitsOnOrder") ? $CurrentForm->getValue("UnitsOnOrder") : $CurrentForm->getValue("x_UnitsOnOrder");
		if (!$this->UnitsOnOrder->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->UnitsOnOrder->Visible = FALSE; // Disable update for API request
			else
				$this->UnitsOnOrder->setFormValue($val);
		}

		// Check field name 'ReorderLevel' first before field var 'x_ReorderLevel'
		$val = $CurrentForm->hasValue("ReorderLevel") ? $CurrentForm->getValue("ReorderLevel") : $CurrentForm->getValue("x_ReorderLevel");
		if (!$this->ReorderLevel->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->ReorderLevel->Visible = FALSE; // Disable update for API request
			else
				$this->ReorderLevel->setFormValue($val);
		}

		// Check field name 'Discontinued' first before field var 'x_Discontinued'
		$val = $CurrentForm->hasValue("Discontinued") ? $CurrentForm->getValue("Discontinued") : $CurrentForm->getValue("x_Discontinued");
		if (!$this->Discontinued->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->Discontinued->Visible = FALSE; // Disable update for API request
			else
				$this->Discontinued->setFormValue($val);
		}
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->ProductID->CurrentValue = $this->ProductID->FormValue;
		$this->ProductName->CurrentValue = $this->ProductName->FormValue;
		$this->SupplierID->CurrentValue = $this->SupplierID->FormValue;
		$this->CategoryID->CurrentValue = $this->CategoryID->FormValue;
		$this->QuantityPerUnit->CurrentValue = $this->QuantityPerUnit->FormValue;
		$this->UnitPrice->CurrentValue = $this->UnitPrice->FormValue;
		$this->UnitsInStock->CurrentValue = $this->UnitsInStock->FormValue;
		$this->UnitsOnOrder->CurrentValue = $this->UnitsOnOrder->FormValue;
		$this->ReorderLevel->CurrentValue = $this->ReorderLevel->FormValue;
		$this->Discontinued->CurrentValue = $this->Discontinued->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = &$this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->ProductID->setDbValue($row['ProductID']);
		$this->ProductName->setDbValue($row['ProductName']);
		$this->SupplierID->setDbValue($row['SupplierID']);
		$this->CategoryID->setDbValue($row['CategoryID']);
		$this->QuantityPerUnit->setDbValue($row['QuantityPerUnit']);
		$this->UnitPrice->setDbValue($row['UnitPrice']);
		$this->UnitsInStock->setDbValue($row['UnitsInStock']);
		$this->UnitsOnOrder->setDbValue($row['UnitsOnOrder']);
		$this->ReorderLevel->setDbValue($row['ReorderLevel']);
		$this->Discontinued->setDbValue($row['Discontinued']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['ProductID'] = NULL;
		$row['ProductName'] = NULL;
		$row['SupplierID'] = NULL;
		$row['CategoryID'] = NULL;
		$row['QuantityPerUnit'] = NULL;
		$row['UnitPrice'] = NULL;
		$row['UnitsInStock'] = NULL;
		$row['UnitsOnOrder'] = NULL;
		$row['ReorderLevel'] = NULL;
		$row['Discontinued'] = NULL;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("ProductID")) <> "")
			$this->ProductID->CurrentValue = $this->getKey("ProductID"); // ProductID
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = &$this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->UnitPrice->FormValue == $this->UnitPrice->CurrentValue && is_numeric(ConvertToFloatString($this->UnitPrice->CurrentValue)))
			$this->UnitPrice->CurrentValue = ConvertToFloatString($this->UnitPrice->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// ProductID
		// ProductName
		// SupplierID
		// CategoryID
		// QuantityPerUnit
		// UnitPrice
		// UnitsInStock
		// UnitsOnOrder
		// ReorderLevel
		// Discontinued

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// ProductID
			$this->ProductID->ViewValue = $this->ProductID->CurrentValue;
			$this->ProductID->ViewCustomAttributes = "";

			// ProductName
			$this->ProductName->ViewValue = $this->ProductName->CurrentValue;
			$this->ProductName->ViewCustomAttributes = "";

			// SupplierID
			$this->SupplierID->ViewValue = $this->SupplierID->CurrentValue;
			$this->SupplierID->ViewValue = FormatNumber($this->SupplierID->ViewValue, 0, -2, -2, -2);
			$this->SupplierID->ViewCustomAttributes = "";

			// CategoryID
			$this->CategoryID->ViewValue = $this->CategoryID->CurrentValue;
			$this->CategoryID->ViewValue = FormatNumber($this->CategoryID->ViewValue, 0, -2, -2, -2);
			$this->CategoryID->ViewCustomAttributes = "";

			// QuantityPerUnit
			$this->QuantityPerUnit->ViewValue = $this->QuantityPerUnit->CurrentValue;
			$this->QuantityPerUnit->ViewCustomAttributes = "";

			// UnitPrice
			$this->UnitPrice->ViewValue = $this->UnitPrice->CurrentValue;
			$this->UnitPrice->ViewValue = FormatNumber($this->UnitPrice->ViewValue, 2, -2, -2, -2);
			$this->UnitPrice->ViewCustomAttributes = "";

			// UnitsInStock
			$this->UnitsInStock->ViewValue = $this->UnitsInStock->CurrentValue;
			$this->UnitsInStock->ViewValue = FormatNumber($this->UnitsInStock->ViewValue, 0, -2, -2, -2);
			$this->UnitsInStock->ViewCustomAttributes = "";

			// UnitsOnOrder
			$this->UnitsOnOrder->ViewValue = $this->UnitsOnOrder->CurrentValue;
			$this->UnitsOnOrder->ViewValue = FormatNumber($this->UnitsOnOrder->ViewValue, 0, -2, -2, -2);
			$this->UnitsOnOrder->ViewCustomAttributes = "";

			// ReorderLevel
			$this->ReorderLevel->ViewValue = $this->ReorderLevel->CurrentValue;
			$this->ReorderLevel->ViewValue = FormatNumber($this->ReorderLevel->ViewValue, 0, -2, -2, -2);
			$this->ReorderLevel->ViewCustomAttributes = "";

			// Discontinued
			if (ConvertToBool($this->Discontinued->CurrentValue)) {
				$this->Discontinued->ViewValue = $this->Discontinued->tagCaption(1) <> "" ? $this->Discontinued->tagCaption(1) : "1";
			} else {
				$this->Discontinued->ViewValue = $this->Discontinued->tagCaption(2) <> "" ? $this->Discontinued->tagCaption(2) : "0";
			}
			$this->Discontinued->ViewCustomAttributes = "";

			// ProductID
			$this->ProductID->LinkCustomAttributes = "";
			$this->ProductID->HrefValue = "";
			$this->ProductID->TooltipValue = "";

			// ProductName
			$this->ProductName->LinkCustomAttributes = "";
			$this->ProductName->HrefValue = "";
			$this->ProductName->TooltipValue = "";

			// SupplierID
			$this->SupplierID->LinkCustomAttributes = "";
			$this->SupplierID->HrefValue = "";
			$this->SupplierID->TooltipValue = "";

			// CategoryID
			$this->CategoryID->LinkCustomAttributes = "";
			$this->CategoryID->HrefValue = "";
			$this->CategoryID->TooltipValue = "";

			// QuantityPerUnit
			$this->QuantityPerUnit->LinkCustomAttributes = "";
			$this->QuantityPerUnit->HrefValue = "";
			$this->QuantityPerUnit->TooltipValue = "";

			// UnitPrice
			$this->UnitPrice->LinkCustomAttributes = "";
			$this->UnitPrice->HrefValue = "";
			$this->UnitPrice->TooltipValue = "";

			// UnitsInStock
			$this->UnitsInStock->LinkCustomAttributes = "";
			$this->UnitsInStock->HrefValue = "";
			$this->UnitsInStock->TooltipValue = "";

			// UnitsOnOrder
			$this->UnitsOnOrder->LinkCustomAttributes = "";
			$this->UnitsOnOrder->HrefValue = "";
			$this->UnitsOnOrder->TooltipValue = "";

			// ReorderLevel
			$this->ReorderLevel->LinkCustomAttributes = "";
			$this->ReorderLevel->HrefValue = "";
			$this->ReorderLevel->TooltipValue = "";

			// Discontinued
			$this->Discontinued->LinkCustomAttributes = "";
			$this->Discontinued->HrefValue = "";
			$this->Discontinued->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// ProductID
			$this->ProductID->EditAttrs["class"] = "form-control";
			$this->ProductID->EditCustomAttributes = "";
			$this->ProductID->EditValue = $this->ProductID->CurrentValue;
			$this->ProductID->ViewCustomAttributes = "";

			// ProductName
			$this->ProductName->EditAttrs["class"] = "form-control";
			$this->ProductName->EditCustomAttributes = "";
			$this->ProductName->EditValue = HtmlEncode($this->ProductName->CurrentValue);
			$this->ProductName->PlaceHolder = RemoveHtml($this->ProductName->caption());

			// SupplierID
			$this->SupplierID->EditAttrs["class"] = "form-control";
			$this->SupplierID->EditCustomAttributes = "";
			$this->SupplierID->EditValue = HtmlEncode($this->SupplierID->CurrentValue);
			$this->SupplierID->PlaceHolder = RemoveHtml($this->SupplierID->caption());

			// CategoryID
			$this->CategoryID->EditAttrs["class"] = "form-control";
			$this->CategoryID->EditCustomAttributes = "";
			$this->CategoryID->EditValue = HtmlEncode($this->CategoryID->CurrentValue);
			$this->CategoryID->PlaceHolder = RemoveHtml($this->CategoryID->caption());

			// QuantityPerUnit
			$this->QuantityPerUnit->EditAttrs["class"] = "form-control";
			$this->QuantityPerUnit->EditCustomAttributes = "";
			$this->QuantityPerUnit->EditValue = HtmlEncode($this->QuantityPerUnit->CurrentValue);
			$this->QuantityPerUnit->PlaceHolder = RemoveHtml($this->QuantityPerUnit->caption());

			// UnitPrice
			$this->UnitPrice->EditAttrs["class"] = "form-control";
			$this->UnitPrice->EditCustomAttributes = "";
			$this->UnitPrice->EditValue = HtmlEncode($this->UnitPrice->CurrentValue);
			$this->UnitPrice->PlaceHolder = RemoveHtml($this->UnitPrice->caption());
			if (strval($this->UnitPrice->EditValue) <> "" && is_numeric($this->UnitPrice->EditValue))
				$this->UnitPrice->EditValue = FormatNumber($this->UnitPrice->EditValue, -2, -2, -2, -2);

			// UnitsInStock
			$this->UnitsInStock->EditAttrs["class"] = "form-control";
			$this->UnitsInStock->EditCustomAttributes = "";
			$this->UnitsInStock->EditValue = HtmlEncode($this->UnitsInStock->CurrentValue);
			$this->UnitsInStock->PlaceHolder = RemoveHtml($this->UnitsInStock->caption());

			// UnitsOnOrder
			$this->UnitsOnOrder->EditAttrs["class"] = "form-control";
			$this->UnitsOnOrder->EditCustomAttributes = "";
			$this->UnitsOnOrder->EditValue = HtmlEncode($this->UnitsOnOrder->CurrentValue);
			$this->UnitsOnOrder->PlaceHolder = RemoveHtml($this->UnitsOnOrder->caption());

			// ReorderLevel
			$this->ReorderLevel->EditAttrs["class"] = "form-control";
			$this->ReorderLevel->EditCustomAttributes = "";
			$this->ReorderLevel->EditValue = HtmlEncode($this->ReorderLevel->CurrentValue);
			$this->ReorderLevel->PlaceHolder = RemoveHtml($this->ReorderLevel->caption());

			// Discontinued
			$this->Discontinued->EditCustomAttributes = "";
			$this->Discontinued->EditValue = $this->Discontinued->options(FALSE);

			// Edit refer script
			// ProductID

			$this->ProductID->LinkCustomAttributes = "";
			$this->ProductID->HrefValue = "";

			// ProductName
			$this->ProductName->LinkCustomAttributes = "";
			$this->ProductName->HrefValue = "";

			// SupplierID
			$this->SupplierID->LinkCustomAttributes = "";
			$this->SupplierID->HrefValue = "";

			// CategoryID
			$this->CategoryID->LinkCustomAttributes = "";
			$this->CategoryID->HrefValue = "";

			// QuantityPerUnit
			$this->QuantityPerUnit->LinkCustomAttributes = "";
			$this->QuantityPerUnit->HrefValue = "";

			// UnitPrice
			$this->UnitPrice->LinkCustomAttributes = "";
			$this->UnitPrice->HrefValue = "";

			// UnitsInStock
			$this->UnitsInStock->LinkCustomAttributes = "";
			$this->UnitsInStock->HrefValue = "";

			// UnitsOnOrder
			$this->UnitsOnOrder->LinkCustomAttributes = "";
			$this->UnitsOnOrder->HrefValue = "";

			// ReorderLevel
			$this->ReorderLevel->LinkCustomAttributes = "";
			$this->ReorderLevel->HrefValue = "";

			// Discontinued
			$this->Discontinued->LinkCustomAttributes = "";
			$this->Discontinued->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!SERVER_VALIDATE)
			return ($FormError == "");
		if ($this->ProductID->Required) {
			if (!$this->ProductID->IsDetailKey && $this->ProductID->FormValue != NULL && $this->ProductID->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->ProductID->caption(), $this->ProductID->RequiredErrorMessage));
			}
		}
		if ($this->ProductName->Required) {
			if (!$this->ProductName->IsDetailKey && $this->ProductName->FormValue != NULL && $this->ProductName->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->ProductName->caption(), $this->ProductName->RequiredErrorMessage));
			}
		}
		if ($this->SupplierID->Required) {
			if (!$this->SupplierID->IsDetailKey && $this->SupplierID->FormValue != NULL && $this->SupplierID->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->SupplierID->caption(), $this->SupplierID->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->SupplierID->FormValue)) {
			AddMessage($FormError, $this->SupplierID->errorMessage());
		}
		if ($this->CategoryID->Required) {
			if (!$this->CategoryID->IsDetailKey && $this->CategoryID->FormValue != NULL && $this->CategoryID->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CategoryID->caption(), $this->CategoryID->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->CategoryID->FormValue)) {
			AddMessage($FormError, $this->CategoryID->errorMessage());
		}
		if ($this->QuantityPerUnit->Required) {
			if (!$this->QuantityPerUnit->IsDetailKey && $this->QuantityPerUnit->FormValue != NULL && $this->QuantityPerUnit->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->QuantityPerUnit->caption(), $this->QuantityPerUnit->RequiredErrorMessage));
			}
		}
		if ($this->UnitPrice->Required) {
			if (!$this->UnitPrice->IsDetailKey && $this->UnitPrice->FormValue != NULL && $this->UnitPrice->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->UnitPrice->caption(), $this->UnitPrice->RequiredErrorMessage));
			}
		}
		if (!CheckNumber($this->UnitPrice->FormValue)) {
			AddMessage($FormError, $this->UnitPrice->errorMessage());
		}
		if ($this->UnitsInStock->Required) {
			if (!$this->UnitsInStock->IsDetailKey && $this->UnitsInStock->FormValue != NULL && $this->UnitsInStock->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->UnitsInStock->caption(), $this->UnitsInStock->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->UnitsInStock->FormValue)) {
			AddMessage($FormError, $this->UnitsInStock->errorMessage());
		}
		if ($this->UnitsOnOrder->Required) {
			if (!$this->UnitsOnOrder->IsDetailKey && $this->UnitsOnOrder->FormValue != NULL && $this->UnitsOnOrder->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->UnitsOnOrder->caption(), $this->UnitsOnOrder->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->UnitsOnOrder->FormValue)) {
			AddMessage($FormError, $this->UnitsOnOrder->errorMessage());
		}
		if ($this->ReorderLevel->Required) {
			if (!$this->ReorderLevel->IsDetailKey && $this->ReorderLevel->FormValue != NULL && $this->ReorderLevel->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->ReorderLevel->caption(), $this->ReorderLevel->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->ReorderLevel->FormValue)) {
			AddMessage($FormError, $this->ReorderLevel->errorMessage());
		}
		if ($this->Discontinued->Required) {
			if ($this->Discontinued->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Discontinued->caption(), $this->Discontinued->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError <> "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($filter);
		$conn = &$this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// ProductName
			$this->ProductName->setDbValueDef($rsnew, $this->ProductName->CurrentValue, NULL, $this->ProductName->ReadOnly);

			// SupplierID
			$this->SupplierID->setDbValueDef($rsnew, $this->SupplierID->CurrentValue, NULL, $this->SupplierID->ReadOnly);

			// CategoryID
			$this->CategoryID->setDbValueDef($rsnew, $this->CategoryID->CurrentValue, NULL, $this->CategoryID->ReadOnly);

			// QuantityPerUnit
			$this->QuantityPerUnit->setDbValueDef($rsnew, $this->QuantityPerUnit->CurrentValue, NULL, $this->QuantityPerUnit->ReadOnly);

			// UnitPrice
			$this->UnitPrice->setDbValueDef($rsnew, $this->UnitPrice->CurrentValue, NULL, $this->UnitPrice->ReadOnly);

			// UnitsInStock
			$this->UnitsInStock->setDbValueDef($rsnew, $this->UnitsInStock->CurrentValue, NULL, $this->UnitsInStock->ReadOnly);

			// UnitsOnOrder
			$this->UnitsOnOrder->setDbValueDef($rsnew, $this->UnitsOnOrder->CurrentValue, NULL, $this->UnitsOnOrder->ReadOnly);

			// ReorderLevel
			$this->ReorderLevel->setDbValueDef($rsnew, $this->ReorderLevel->CurrentValue, NULL, $this->ReorderLevel->ReadOnly);

			// Discontinued
			$tmpBool = $this->Discontinued->CurrentValue;
			if ($tmpBool <> "1" && $tmpBool <> "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->Discontinued->setDbValueDef($rsnew, $tmpBool, 0, $this->Discontinued->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);
			if ($updateRow) {
				$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("productslist.php"), "", $this->TableVar, TRUE);
		$pageId = "edit";
		$Breadcrumb->add("edit", $pageId, $url);
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL
			switch ($fld->FieldVar) {
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql <> "" && count($fld->Lookup->Options) == 0) {
				$conn = &$this->getConnection();
				$totalCnt = $this->getRecordCount($sql);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
