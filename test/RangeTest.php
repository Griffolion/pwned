<?php

namespace Pwned\Tests;

use Mockery;
use Pwned\Exceptions\ApiFailureException;
use Pwned\Exceptions\CurlFailureException;
use Pwned\Exceptions\HashingAlgorithmUnavailableException;
use Pwned\Range;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;

/**
 * @covers \Pwned\Range
 */
class RangeTest Extends TestCase {
    /** @var string*/
    private $pwnedPassword;

    /** @var string*/
    private $safePassword;

    /**
     * @return void
     */
    public function setUp() : void {
        parent::setUp();
        $this->pwnedPassword = "password";
        $this->safePassword = "safepassword";
    }

    /**
     * @covers \Pwned\Range::check
     * @return void
     * @throws CurlFailureException
     * @throws HashingAlgorithmUnavailableException
     * @throws ApiFailureException
     */
    public function testCheck() : void {
        $fixtureData = file_get_contents(__DIR__ . '/fixtures/passwordresults.txt');
        /** @var Mockery\MockInterface|Range $rangeCheck */
        $rangeCheck = Mockery::mock(Range::class)->makePartial();
        $rangeCheck->shouldAllowMockingProtectedMethods();
        $rangeCheck->shouldReceive('request')->twice()->andReturn($fixtureData);
        $validCheck = $rangeCheck->check($this->pwnedPassword);
        Assert::assertEquals(3730471, $validCheck);
        $invalidCheck = $rangeCheck->check($this->safePassword);
        Assert::assertEquals(0, $invalidCheck);
    }
}