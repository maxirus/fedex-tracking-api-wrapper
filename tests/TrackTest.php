<?php

use FedEx\TrackService\Track;
 
class TrackTest extends PHPUnit_Framework_TestCase {
 
  public function testTrack()
  {
    $track = new Track('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM');
    $this->assertTrue(1 == 1);
  }

  public function testGetByTrackingId()
  {
    $track = new Track('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM');
    
    $req = $track->getByTrackingId('999999999999');
    $this->assertNotEmpty($req);

    $this->assertTrue($req->HighestSeverity == 'SUCCESS');
    $this->assertTrue($req->CompletedTrackDetails->HighestSeverity == 'SUCCESS');
    $this->assertTrue(is_array($req->CompletedTrackDetails->TrackDetails->Events));

  }

  public function testGetByTrackingIdFailure()
  {
    $track = new Track('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM');
    
    $req = $track->getByTrackingId('123456789012A');
    $this->assertNotEmpty($req);

    $this->assertTrue($req->HighestSeverity == 'SUCCESS');
    $this->assertTrue($req->CompletedTrackDetails
        ->TrackDetails->Notification->Severity == 'ERROR');

  }
 
}