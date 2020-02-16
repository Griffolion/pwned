<?php 

namespace Pwned;

use Pwned\Exceptions\HashingAlgorithmUnavailableException;
use Pwned\Exceptions\CurlFailureException;

/**
 * @class Range
 */
class Range 
{
    /**
     * @param string $password
     * @return int
     */
    public static function Check(string $password) : int {
        $password = static::Utf8EncodePassword($password);
        $password = static::Sha1HashPassword($password);
        $pieceToSearchWith = static::GetPieceToSendToSearchWith($password);
        $pieceToMatchWithSearchResults = static::GetPieceToMatchWithSearchResults($password);
        $responseString = static::Request($pieceToSearchWith);
        $matchedResult = [];
        if (!preg_match("/$pieceToMatchWithSearchResults\:(?<count>\d+)/", $responseString, $matchedResult)) { 
            return 0;
        }
        $matchCount = $matchedResult['count'];
        return intval($matchCount);
    }

    /**
     * @param string $pieceToSearchWith
     * @return string
     * @throws CurlFailureException
     */
    protected static function Request(string $pieceToSearchWith) : string {
        $curl = curl_init("https://api.pwnedpasswords.com/range/$pieceToSearchWith");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Pwned Range Checker for PHP"
        ]);
        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            throw new CurlFailureException("Curl failed to make the request with the following error: $error");
        }
        curl_close($curl);
        return $response;
    }

    /**
     * @param string $password
     * @return string
     */
    protected static function Utf8EncodePassword(string $password) : string { 
        return utf8_encode($password);
    }

    /**
     * @param string $password
     * @return string
     * @throws HashingAlgorithmUnavailableException
     */
    protected static function Sha1HashPassword(string $password) : string {
        if (!static::Sha1HashingAlgorithmIsAvailable()) {
            throw new HashingAlgorithmUnavailableException();
        }
        return hash('sha1', $password);
    }

    /**
     * @return array
     */
    protected static function GetAvailableHashingAlgorithms() : array {
        return hash_algos();
    }

    /**
     * @return bool
     */
    protected static function Sha1HashingAlgorithmIsAvailable() : bool {
        $hashingAlgorithms = static::GetAvailableHashingAlgorithms();
        return in_array('sha1', $hashingAlgorithms);
    }

    /**
     * @param string $password
     * @return string
     */
    protected static function GetPieceToSendToSearchWith(string $password) : string {
        $searchPiece = substr($password, 0, 5);
        return strtoupper($searchPiece);
    }

    /**
     * @param string $password
     * @return string
     */
    protected static function GetPieceToMatchWithSearchResults(string $password) : string {
        $matchPiece = substr($password, 5);
        return strtoupper($matchPiece);
    }
}