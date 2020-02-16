<?php

require("src/Range.php");
require("src/Exceptions/HashingAlgorithmUnavailableException.php");
require("src/Exceptions/CurlFailureException.php");

use Pwned\Range;

$check = Range::Check("password");

echo $check;