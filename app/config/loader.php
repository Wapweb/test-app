<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    array(
        'TestApp\\Controllers' => $config->application->controllersDir,
        'TestApp\\Models' => $config->application->modelsDir,
        'TestApp\\Library' => $config->application->libraryDir,
        'TestApp\\Validators' => $config->application->validatorsDir,
    )
)->register();

