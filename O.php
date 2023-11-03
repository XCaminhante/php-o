<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024192714.4: * @file O.php
#@@first
#@@language plain
$classPath = realpath(dirname(__FILE__)."/src/O");
if (!class_exists("\\O\\O")) include($classPath."/O.php");
O::init();
#@-leo
