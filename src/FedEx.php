<?php namespace FedEx;

class FedEx {

	protected $_soapClient;
	private $request;
	private $endPoint;	

	private $key;
	private $password;
	private $acct_num;
	private $meter_num;
	private $service_id;
	private $major;
	private $intermediate;
	private $minor;
	private $customerTransactionId;



	/**
	 * 	Create a new FedEx instance.
	 *	Requires a WSDL file, and FedEx
	 *	API credentials.
	 *
	 *	@param string 	// WSDL File
	 *	@param string 	// Key
	 * 	@param string 	// Password
	 *	@param string 	// Account Number
	 *	@param string 	// Meter number
	 * 	@return void
	 */
	public function __construct($wsdlFile, $k, $p, $a, $m)
	{
		$wsdlPath = __DIR__.'/_wsdl/'.$wsdlFile;
		// Will throw a SoapFault exception if wsdlPath is unreachable
		$this->_soapClient = new \SoapClient($wsdlPath, array('trace' => true));		

		// Initialize request to an empty array
		$this->request = array();

		$this->customerTransactionId = "Defualt ID";

		$this->key = $k;
		$this->password = $p;
		$this->acct_num = $a;
		$this->meter_num = $m;

		// TODO: Change to env() and default to beta
		$this->endPoint = 'https://wsbeta.fedex.com:443/web-services';
		
	}

	/**
	 * 	Retrieve the SoapClient object.
	 *
	 *	@return SoapClient
	 */
	public function getSoapClient()
    {
        return $this->_soapClient;
    }

    /**
     *	Sets the TransactionDetail/CustomerTransactionId
     *	for the current request.
     *
     *	@param string 	// Any text up to 40 characters
     *	@return void
     */
    public function setCustomerTransactionId($id) {
    	$this->customerTransactionId = $id;
    }

	/**
     *	Gets the TransactionDetail/CustomerTransactionId
     *	for the current request.
     *
     *	@param string 	// Any transaction ID
     *	@return string
     */
    public function getCustomerTransactionId($id) {
    	return $this->customerTransactionId;
    }

    /**
     *	Sets the API service to be used
     *	and the version information.
     *
     *	@param string 	// Service to use, ie. "trck"
     * 	@param int 		// Major version to use, ie. 9
     * 	@param int 		// Intermediate version to use, ie. 1
     * 	@param int 		// Minor version to use, ie. 0
     */
    public function setVersion($service_id, $major, $intermediate, $minor) {
    	$this->service_id = $service_id;
    	$this->major = $major;
    	$this->intermediate = $intermediate;
    	$this->minor = $minor;
    }

    /**
     * 	Builds and returns the basic request array to be sent
     *	with each request to the FedEx API. This assumes the
     *	setVersion method has already been called by an extended class.
   	 *
     *	Takes an optional parameter, $addReq. This parameter is 
     *	used to set the additonal request details. These details
     *	are determined by the particular service being called and
     *	are passed by the extended service classes.
     *
     *	@param array 	// Additonal request details
     */
    public function buildRequest($addReq = null) {
    	// Build Authentication
    	$this->request['WebAuthenticationDetail'] = array(
			'UserCredential'=> array(
				'Key' 		=> $this->key, 
				'Password'	=> $this->password
			)
		);

		//Build Client Detail
		$this->request['ClientDetail'] = array(
			'AccountNumber' => $this->acct_num, 
			'MeterNumber' 	=> $this->meter_num
		);

		// Build Customer Transaction Id
		$this->request['TransactionDetail'] = array(
			'CustomerTransactionId' => $this->customerTransactionId
		);
		
		// Build API Version info
		$this->request['Version'] = array(
			'ServiceId' 	=> $this->service_id, 
			'Major' 		=> $this->major, 
			'Intermediate'	=> $this->intermediate, 
			'Minor' 		=> $this->minor
		);

		// Enable detailed scans
		$this->request['ProcessingOptions'] = 'INCLUDE_DETAILED_SCANS';

		if(!is_null($addReq))
			$this->request = array_merge($this->request, $addReq);

		return $this->request;
    }

}