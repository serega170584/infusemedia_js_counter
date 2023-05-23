<?php
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/Database/Config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Database/QueryExecutorInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Database/QueryExecutor.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Visitor/VisitorConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controller/ControllerInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controller/ImageIdController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controller/IncreaseController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controller/NumberController.php';

$config = Config::createFromEnv();
$visitorConfig = VisitorConfig::createFromEnv();

$client = new PDO(sprintf('%s:host=%s;dbname=%s', $config->getDatabaseType(), $config->getDatabaseHost(), $config->getDatabaseName()), $config->getDatabaseUser(), $config->getDatabasePassword());

$method = ucfirst(htmlspecialchars($_GET['method']));
$controllerName = $method . 'Controller';

/**
 * @var ControllerInterface $controller
 */
$controller = new $controllerName($client, $visitorConfig);
printf('%s', $controller->getContent());

