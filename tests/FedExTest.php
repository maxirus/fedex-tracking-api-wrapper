<?php

use maxirus\FedEx\FedEx;
 
class FedExTest extends PHPUnit_Framework_TestCase {
 
  public function testFedEx()
  {
    $fedex = new FedEx('TrackService_v9.wsdl', '', '', '', '');
    $this->assertTrue(1 == 1);
  }

  /**
    * @expectedException SoapFault
    */
  public function testFedExException()
  {
    $fedex = new FedEx("dontFindMe.wdsl", '', '', '', '');
  }

  public function testBuildRequest()
  {
    $fedex = new FedEx('TrackService_v9.wsdl', '', '', '', '');
    $req = $fedex->buildRequest();
    $this->assertNotEmpty($req);

    $this->assertNotEmpty($req['WebAuthenticationDetail']);
    $this->assertNotEmpty($req['ClientDetail']);
    $this->assertNotEmpty($req['TransactionDetail']);
    $this->assertNotEmpty($req['Version']);
  }
 
}