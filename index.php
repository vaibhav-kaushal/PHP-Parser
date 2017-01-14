<?php

require_once 'vendor/autoload.php';

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

//$code = <<<'CODE'
//<?php
//
//function printLine($msg) {
//    echo $msg . "\n";
//}
//
//printLine('Hello World!!!');
//CODE;

$code = file_get_contents('test.php');

$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
$nodeDumper = new PhpParser\NodeDumper;

try {
    $stmts = $parser->parse($code);

//    echo $nodeDumper->dump($stmts), "\n";
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}

$parser        = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
$traverser     = new NodeTraverser;
$prettyPrinter = new PrettyPrinter\Js;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class MyNodeVisitor extends NodeVisitorAbstract
{
    
}

// add your visitor
$traverser->addVisitor(new MyNodeVisitor);

try {
    // traverse
    $stmts = $traverser->traverse($stmts);

    // pretty print
    $code = $prettyPrinter->prettyPrintFile($stmts);

//    echo $code;
	file_put_contents('test.js', $code);
echo 'done' . PHP_EOL;

} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
