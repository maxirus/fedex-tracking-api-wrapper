PHP FedEX Tracking API Wrapper
==============================
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://packagist.org/packages/maxirus/fedex)
[![Latest Stable Version](http://img.shields.io/packagist/v/maxirus/fedex.svg?style=flat)](https://packagist.org/packages/maxirus/fedex)
[![Total Downloads](http://img.shields.io/packagist/dt/maxirus/fedex.svg?style=flat)](https://packagist.org/packages/maxirus/fedex)

This package is aimed at wrapping the FedEx Tracking service in a simple to use PHP Library. Feel free to contribute.

## Table Of Content

1. [Requirements](#requirements)
2. [Track Class](#track-class)
    * [Example](#track-class-example)
    * [Parameters](#track-class-parameters)

<a name="requirements"></a>
## Requirements

This library uses PHP 5.3+.

To use the FedEx API, you have to [request an access key from FedEx](http://www.fedex.com/us/developer/). For every request,
you will have to provide the Access Key, Password, Account Number and Meter Number.

<a name="installation"></a>
## Installation

It is recommended that you install the PHP FedEx Tracking API Wrapper library [through composer](http://getcomposer.org/). To do so,
add the following lines to your ``composer.json`` file.

```JSON
{
    "require": {
        "maxirus/fedex": "dev-master"
    }
}
```
<a name="track-class"></a>
## Track Class

The Track Class allows you to track a shipment using the FedEx Tracking API by simply providing a Tracking # or Order Tag number. 

<a name="tracking-class-example"></a>
### Example

```php
$tracking = new FedEx\TrackService\Track($accessKey, $password, $acctNum, $meterNum);

try {
	$shipment = $tracking->getByTrackingId('TRACKING NUMBER');
		
	var_dump($shipment);
	
} catch (Exception $e) {
	var_dump($e);
}
```

<a name="tracking-class-parameters"></a>
### Parameters

Track parameters are:

 * `trackingNumber` The package’s tracking number.

