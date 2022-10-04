<?php 

namespace Pwned;

use Pwned\Exceptions\ApiFailureException;
use Pwned\Exceptions\HashingAlgorithmUnavailableException;
use Pwned\Exceptions\CurlFailureException;

/**
 * @class Range
 */
class Range 
{
    /**
     * @param string $password
     * @param bool $addPadding
     * @return int
     * @throws CurlFailureException
     * @throws HashingAlgorithmUnavailableException
     * @throws ApiFailureException
     */
    public function check(string $password, bool $addPadding = false) : int {
        if (!in_array('sha1', hash_algos())) {
            throw new HashingAlgorithmUnavailableException();
        }
        $password = hash('sha1', utf8_encode($password));
        $pieceToSearchWith = strtoupper(substr($password, 0, 5));
        $pieceToMatchWithSearchResults = strtoupper(substr($password, 5));
        $responseString = $this->request($pieceToSearchWith, $addPadding);
        $matchedResult = [];
        if (!preg_match("/$pieceToMatchWithSearchResults\:(?<count>\d+)/", $responseString, $matchedResult)) { 
            return 0;
        }
        $matchCount = $matchedResult['count'];
        return intval($matchCount);
    }

    /**
     * @param string $pieceToSearchWith
     * @param bool $addPadding
     * @return string
     * @throws CurlFailureException
     * @throws ApiFailureException
     */
    protected function request(string $pieceToSearchWith, bool $addPadding) : string {
        $curl = curl_init("https://api.pwnedpasswords.com/range/$pieceToSearchWith");
        $optArray = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Pwned Range Checker for PHP",
            CURLOPT_TIMEOUT => 15,
        ];
        if ($addPadding) {
            $optArray[CURLOPT_HEADER] = ['Add-Padding: true'];
        }
        curl_setopt_array($curl, $optArray);
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            throw new CurlFailureException("Curl failed to make the request with the following error: $error");
        }
        $info = curl_getinfo($curl);
        if ($info['http_code'] !== 200) {
            throw new ApiFailureException("HIBP API returned the following error code: " . $info['http_code'], $info['http_code']);
        }
        curl_close($curl);
        return $response;
    }
}