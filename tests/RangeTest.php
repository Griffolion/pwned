<?php

namespace Pwned\Tests;

use Exception;
use Pwned\Tests\TestClass\TestRange;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Pwned\Exceptions\HashingAlgorithmUnavailableException;

/**
 * @covers Pwned\Range
 */
class RangeTest Extends TestCase {
    /** @var string*/
    private $validPassword;

    /** @var string*/
    private $invalidPassword;

    /** @var string*/
    private $utf8EncodedPassword;

    /** @var string*/
    private $sha1HashedPassword;

    /** @var string*/
    private $searchingPiece;

    /** @var string*/
    private $matchingPiece;

    /**
     * @return void
     */
    public function setUp() : void {
        parent::setUp();
        $this->validPassword = "password";
        $this->invalidPassword = "badpassword";
        $this->utf8EncodedPassword = "password";
        $this->sha1HashedPassword = "5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8";
        $this->searchingPiece = "5BAA6";
        $this->matchingPiece = "1E4C9B93F3F0682250B6CF8331B7EE68FD8";
    }

    /**
     * @covers Pwned\Range::Check
     * @return void
     */
    public function testCheck() : void {
        $validCheck = TestRange::Check($this->validPassword);
        Assert::assertEquals(3730471, $validCheck);
        $invalidCheck = TestRange::Check($this->invalidPassword);
        Assert::assertEquals(0, $invalidCheck);
    }

    /**
     * @covers Pwned\Range::Request
     * @return void
     */
    public function testRequest() : void {
        $responseString = TestRange::request($this->searchingPiece);
        Assert::assertIsString($responseString);
    }

    /**
     * @covers Pwned\Range::Utf8EncodePassword
     * @return void
     */
    public function testUtf8EncodePassword() : void {
        $utf8EncodedPassword = TestRange::Utf8EncodePassword($this->validPassword);
        Assert::assertEquals($this->utf8EncodedPassword, $utf8EncodedPassword);
    }

    /**
     * @covers Pwned\Range::Sha1HashPassword
     * @return void
     */
    public function testSha1HashPassword() : void {
        try {
            $sha1HashedPassword = TestRange::Sha1HashPassword($this->utf8EncodedPassword);
        } catch (Exception $e) {
            Assert::assertInstanceOf(HashingAlgorithmUnavailableException::class, $e->class);
        }
        Assert::assertEquals($this->sha1HashedPassword, $sha1HashedPassword);
    }

    /**
     * @covers Pwned\Range::GetAvailableHashingAlgorithms
     * @return void
     */
    public function testGetAvailableHashingAlgorithms() : void {
        $availableHashingAlgorithms = TestRange::GetAvailableHashingAlgorithms();
        Assert::assertIsArray($availableHashingAlgorithms);
    }

    /**
     * @covers Pwned\Range::Sha1HashingAlgorithmIsAvailable
     * @return void
     */
    public function testSha1HashingAlgorithmIsAvailable() : void {
        $sha1HashingAlgorithmIsAvailable = TestRange::Sha1HashingAlgorithmIsAvailable();
        Assert::assertIsBool($sha1HashingAlgorithmIsAvailable);
    }

    /**
     * @covers Pwned\Range::GetPieceToSendToSearchWith
     * @return void
     */
    public function testGetPieceToSendToSearchWith() : void {
        $searchingPiece = TestRange::GetPieceToSendToSearchWith($this->sha1HashedPassword);
        Assert::assertEquals($this->searchingPiece, $searchingPiece);
    }

    /**
     * @covers Pwned\Range::GetPieceToMatchWithSearchResults
     * @return void
     */
    public function testGetPieceToMatchWithSearchResults() : void {
        $matchingPiece = TestRange::GetPieceToMatchWithSearchResults($this->sha1HashedPassword);
        Assert::assertEquals($this->matchingPiece, $matchingPiece);
    }
}