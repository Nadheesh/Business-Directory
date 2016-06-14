<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/**
 * @var ClassLoader $loader
 */


$loader = require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Finder\Finder;
//
$finder = new Finder();
//$finder->in(realpath(__DIR__.'/../').'/web/bundles/');

AnnotationRegistry::registerLoader([$loader, 'loadClass']);
AnnotationDriver::registerAnnotationClasses();

$loader->add('Gregwar', __DIR__.'/../vendor/bundles');


return $loader;
