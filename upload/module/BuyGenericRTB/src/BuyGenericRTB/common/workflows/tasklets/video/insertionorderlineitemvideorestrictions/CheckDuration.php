<?php
/**
 * NGINAD Project
 *
 * @link http://www.nginad.com
 * @copyright Copyright (c) 2013-2016 NginAd Foundation. All Rights Reserved
 * @license GPLv3
 */

namespace buyrtb\workflows\tasklets\video\insertionorderlineitemvideorestrictions;

class CheckDuration {
	
	public static function execute(&$Logger, &$Workflow, \model\openrtb\RtbBidRequest &$RtbBidRequest, \model\openrtb\RtbBidRequestImp &$RtbBidRequestImp, &$InsertionOrderLineItem, &$InsertionOrderLineItemVideoRestrictions) {
		
		$RtbBidRequestVideo = $RtbBidRequestImp->RtbBidRequestVideo;
		
		$result1 = true;
		$result2 = true;
		
		if (is_numeric($InsertionOrderLineItemVideoRestrictions->MinDuration) && $InsertionOrderLineItemVideoRestrictions->MinDuration != 0):
			
			// Validate that the value is a number
			if (!is_numeric($RtbBidRequestVideo->minduration)):
				if ($Logger->setting_log === true):
					$Logger->log[] = "Failed: " . "Check video minimum duration :: EXPECTED: "
							. 'Numeric Value,'
							. " GOT: " . $RtbBidRequestVideo->minduration;
				endif;
				$result1 = false;
				
			else:
			
				$result1 = $RtbBidRequestVideo->minduration > $InsertionOrderLineItemVideoRestrictions->MinDuration;
				
				if ($result1 === false && $Logger->setting_log === true):
					$Logger->log[] = "Failed: " . "Check video minimum duration :: EXPECTED: "
							. $InsertionOrderLineItemVideoRestrictions->MinDuration
							. " GOT: " . $RtbBidRequestVideo->minduration;
				endif;
			endif;
			
		endif;
		
		if (is_numeric($InsertionOrderLineItemVideoRestrictions->MaxDuration) && $InsertionOrderLineItemVideoRestrictions->MaxDuration != 0):
			
			// Validate that the value is a number
			if (!is_numeric($RtbBidRequestVideo->maxduration)):
				if ($Logger->setting_log === true):
					$Logger->log[] = "Failed: " . "Check video maximum duration :: EXPECTED: "
							. 'Numeric Value,'
							. " GOT: " . $RtbBidRequestVideo->maxduration;
				endif;
				$result2 = false;
			
			else:
				
				$result2 = $RtbBidRequestVideo->maxduration < $InsertionOrderLineItemVideoRestrictions->MaxDuration;
				
				if ($result2 === false && $Logger->setting_log === true):
					$Logger->log[] = "Failed: " . "Check video maximum duration :: EXPECTED: "
							. $InsertionOrderLineItemVideoRestrictions->MaxDuration
							. " GOT: " . $RtbBidRequestVideo->maxduration;
				endif;
			
			endif;
			
		endif;
		
		return $result1 && $result2;
	}
}
