<?php

require __DIR__ . '/../vendor/autoload.php';

use Biplane\Wsdl2Php\Config;
use Biplane\Wsdl2Php\Generator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

$definition = new InputDefinition(array(
    new InputArgument('service', InputArgument::REQUIRED, 'The name of API service.')
));

try {
    $argv = new ArgvInput(null, $definition);
} catch (\RuntimeException $ex) {
    echo sprintf('  Thrown exception %s with message "%s".', get_class($ex), $ex->getMessage()) . PHP_EOL;
    usage($definition);

    exit(1);
}

$defaultOptions = array(
    'outputDir'           => __DIR__ . '/../src/YandexDirect/Api/V5',
    'namespaceName'       => 'Biplane\YandexDirect\Api\V5',
    'baseSoapClientClass' => 'Biplane\YandexDirect\Api\V5SoapClient',
);

switch ($argv->getArgument('service')) {
    case 'YandexApiService':
        $options = array(
            'inputFile'           => 'https://api.direct.yandex.ru/live/v4/wsdl/',
            'outputDir'           => __DIR__ . '/../src/YandexDirect/Api/V4',
            'namespaceName'       => 'Biplane\YandexDirect\Api\V4',
            'excludeTypes'        => array('PingAPI_XInfo', 'PingAPI_XStructInfo'),
            'excludeOperations'   => array('PingAPI_X', 'PingAPI'),
            'baseSoapClientClass' => 'Biplane\YandexDirect\Api\V4SoapClient'
        );
        break;
    case 'AdGroups':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/adgroups?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace('#^(Get|Add|Update|Delete)(Request|Response)$#', '$1AdGroup$2', $typeName);
            }
        );
        break;
    case 'Ads':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/ads?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Get|Add|Update|Delete|Archive|Unarchive|Unarchive|Suspend|Resume|Moderate)(Request|Response)$#',
                    '$1Ad$2',
                    $typeName
                );
            }
        );
        break;
    case 'Bids':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/bids?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Get|Set|SetAuto)(Request|Response)$#',
                    '$1Bid$2',
                    $typeName
                );
            }
        );
        break;
    case 'Changes':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/changes?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Check)(Request|Response)$#',
                    '$1Change$2',
                    $typeName
                );
            }
        );
        break;
    case 'Keywords':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/keywords?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Add|Delete|Get|Resume|Suspend|Update)(Request|Response)$#',
                    '$1Keyword$2',
                    $typeName
                );
            }
        );
        break;
    case 'Sitelinks':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/sitelinks?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Add|Delete|Get)(Request|Response)$#',
                    '$1Keyword$2',
                    $typeName
                );
            }
        );
        break;
    case 'VCards':
        $options = $defaultOptions + array(
            'inputFile'  => 'https://api.direct.yandex.com/v5/vcards?wsdl',
            'renameType' => function ($typeName) {
                return preg_replace(
                    '#^(Add|Delete|Get)(Request|Response)$#',
                    '$1Keyword$2',
                    $typeName
                );
            }
        );
        break;
    default:
        usage($definition);
        exit(2);
}

$generator = new Generator();
$generator->generate(new Config($options));

function usage(InputDefinition $definition) {
    echo '  Usage:' . PHP_EOL;
    echo '  php bin/wsdl2.php ' . $definition->getSynopsis() . PHP_EOL . PHP_EOL;
    echo '  <service> -- The name of API service. Supports:' . PHP_EOL;
    echo '               YandexApiService (version: 4 Live);' . PHP_EOL;
    echo '               AdGroups (version: 5);' . PHP_EOL;
    echo '               Ads (version: 5);' . PHP_EOL;
    echo '               Bids (version: 5);' . PHP_EOL;
    echo '               Changes (version: 5);' . PHP_EOL;
    echo '               Keywords (version: 5);' . PHP_EOL;
    echo '               Sitelinks (version: 5);' . PHP_EOL;
    echo '               VCards (version: 5);' . PHP_EOL;
}
