<?php

namespace Pwned\Tests\TestClass;

use Pwned\Range;

class TestRange extends Range {
    /**
     * @param string $password
     * @return int
     */
    public static function Check(string $password) : int {
        return parent::Check($password);
    }

    /**
     * @param string $pieceToSearchWith
     * @return string
     */
    public static function request(string $pieceToSearchWith) : string {
        $fixtureData = file_get_contents(__DIR__ . "/../fixtures/passwordresults.txt");
        return $fixtureData;
    }

    /**
     * @param string $password
     * @return string
     */
    public static function Utf8EncodePassword(string $password) : string {
        return parent::Utf8EncodePassword($password);
    }

    /**
     * @param string $password
     * @return string
     * @throws HashingAlgorithmUnavailableException
     */
    public static function Sha1HashPassword(string $password) : string {
        return parent::Sha1HashPassword($password);
    }

    /**
     * @return array
     */
    public static function GetAvailableHashingAlgorithms() : array {
        return parent::GetAvailableHashingAlgorithms();
    }

    /**
     * @return bool
     */
    public static function Sha1HashingAlgorithmIsAvailable() : bool {
        return parent::Sha1HashingAlgorithmIsAvailable();
    }

    /**
     * @param string $password
     * @return string
     */
    public static function GetPieceToSendToSearchWith(string $password) : string {
        return parent::GetPieceToSendToSearchWith($password);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function GetPieceToMatchWithSearchResults(string $password) : string {
        return parent::GetPieceToMatchWithSearchResults($password);
    }
}