<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Request;

use projectivemotion\PhpScraperTools\SuperScraper;
use projectivemotion\phpSkyscanner\Exception;

class LiveFlightCreate extends SuperScraper
{
    protected function curl_setopt($ch)
    {
        parent::curl_setopt($ch);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }

    public function getCurl($url, $post = NULL, $isAjax = false)
    {
        $headers    =   parent::getCurl($url, $post, $isAjax);

        if(preg_match('#Location:\s*(.*?)\n#', $headers, $matches))
            return trim($matches[1]);
        
        list(, $body) = explode("\r\n\r\n", $headers);
        
        $json   =   json_decode($body);

        if(isset($json->ValidationErrors))
        {
            $Message    =   [];
            foreach($json->ValidationErrors as $vError)
            {
                $Message[]  =   sprintf("Validation: %s=%s => %s", $vError->ParameterName, $vError->ParameterValue ?: "***", $vError->Message);
            }

            throw new Exception(implode("\n", $Message));
        }
        return NULL;
    }
    // greece travelplan.

    public static function GetSessionURL(LiveFlightQuery $query)
    {
        $url = 'http://partners.api.skyscanner.net/apiservices/pricing/v1.0';

        $http   =   new static();
        $location   =   $http->PostAjax($url, $query->asArray());

        return $location;
    }
}