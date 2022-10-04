<?php

require("src/Range.php");
require("src/Exceptions/HashingAlgorithmUnavailableException.php");
require("src/Exceptions/CurlFailureException.php");

use Pwned\Range;

$check = (new Range())->check("password");

echo $check;