<?php

declare(strict_types=1);

namespace PackageVersions;

/**
 * This class is generated by ocramius/package-versions, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    public const ROOT_PACKAGE_NAME = 'sethsandaru/laravel-hmvc-sample';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    public const VERSIONS          = array (
  'aws/aws-sdk-php' => '3.132.5@276241cf558f883b639ecdefd0e9912f0df20b8e',
  'bensampo/laravel-enum' => 'v1.29@85915cbba12c2270d8b3147171dced92c075e282',
  'clue/stream-filter' => 'v1.4.1@5a58cc30a8bd6a4eb8f856adf61dd3e013f53f71',
  'darkaonline/l5-swagger' => '5.8.3@32b312a7c5f0501fc79efef812ed2dade6d97200',
  'defuse/php-encryption' => 'v2.2.1@0f407c43b953d571421e0020ba92082ed5fb7620',
  'dnoegel/php-xdg-base-dir' => 'v0.1.1@8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
  'doctrine/annotations' => 'v1.8.0@904dca4eb10715b92569fbcd79e201d5c349b6bc',
  'doctrine/cache' => '1.10.0@382e7f4db9a12dc6c19431743a2b096041bcdd62',
  'doctrine/dbal' => 'v2.10.1@c2b8e6e82732a64ecde1cddf9e1e06cb8556e3d8',
  'doctrine/event-manager' => '1.1.0@629572819973f13486371cb611386eb17851e85c',
  'doctrine/inflector' => '1.3.1@ec3a55242203ffa6a4b27c58176da97ff0a7aec1',
  'doctrine/lexer' => '1.2.0@5242d66dbeb21a30dd8a3e66bf7a73b66e05e1f6',
  'dragonmantank/cron-expression' => 'v2.3.0@72b6fbf76adb3cf5bc0db68559b33d41219aba27',
  'egulias/email-validator' => '2.1.14@c4b8d12921999d8a561004371701dbc2e05b5ece',
  'erusev/parsedown' => '1.7.4@cb17b6477dfff935958ba01325f2e8a2bfa6dab3',
  'fideloper/proxy' => '4.2.2@790194d5d3da89a713478875d2e2d05855a90a81',
  'fig/http-message-util' => '1.1.3@35b19404371b31b3a43823c755398c48c9966db4',
  'firebase/php-jwt' => 'v5.0.0@9984a4d3a32ae7673d6971ea00bae9d0a1abba0e',
  'giggsey/libphonenumber-for-php' => '8.11.2@1ec1059b56b40cc1b6b02b438711e4a90ba4bbc7',
  'giggsey/locale' => '1.8@85a1b251bad11c986fec2a051b10d4b80a5caa1b',
  'google/auth' => 'v1.6.1@45635ac69d0b95f38885531d4ebcdfcb2ebb6f36',
  'google/cloud-core' => 'v1.34.0@52db21acb2da25d2d79e493842de58da7836c97f',
  'google/cloud-storage' => 'v1.17.0@626e910530f0b9463a15563f697a66f1cfbd6369',
  'google/crc32' => 'v0.1.0@a8525f0dea6fca1893e1bae2f6e804c5f7d007fb',
  'guzzlehttp/guzzle' => '6.5.2@43ece0e75098b7ecd8d13918293029e555a50f82',
  'guzzlehttp/promises' => 'v1.3.1@a59da6cf61d80060647ff4d3eb2c03a2bc694646',
  'guzzlehttp/psr7' => '1.6.1@239400de7a173fe9901b9ac7c06497751f00727a',
  'hanneskod/classtools' => '1.2.0@4fba4476ff140af08ddd5ed1a42332b4bc8dcca9',
  'http-interop/http-factory-guzzle' => '1.0.0@34861658efb9899a6618cef03de46e2a52c80fc0',
  'intervention/image' => '2.5.1@abbf18d5ab8367f96b3205ca3c89fb2fa598c69e',
  'jakub-onderka/php-console-color' => 'v0.2@d5deaecff52a0d61ccb613bb3804088da0307191',
  'jakub-onderka/php-console-highlighter' => 'v0.4@9f7a229a69d52506914b4bc61bfdb199d90c5547',
  'jean85/pretty-package-versions' => '1.2@75c7effcf3f77501d0e0caa75111aff4daa0dd48',
  'kreait/clock' => '1.0.1@7bc9a0c78946393a0e1ea52fc527e14779cac47c',
  'kreait/firebase-php' => '4.38.1@c02500234e61abaa902724c7f4efbcdc2efcfb51',
  'kreait/firebase-tokens' => '1.10.0@fb4449094a7ac27b26269a388bb21cfb35f90d3d',
  'kreait/gcp-metadata' => '1.0.1@9bc4b871bd8623aa018bbd0ff38e3a286e760bc7',
  'kreait/laravel-firebase' => '1.0.0@534b5a4ba4fdfb519dd8061ff47c0afb7a1fc3fb',
  'kylekatarnls/update-helper' => '1.2.0@5786fa188e0361b9adf9e8199d7280d1b2db165e',
  'kyslik/column-sortable' => '5.8.0@4c3291b51a8b19e278b96703bc31439a13cdbe04',
  'laminas/laminas-code' => '3.4.1@1cb8f203389ab1482bf89c0e70a04849bacd7766',
  'laminas/laminas-eventmanager' => '3.2.1@ce4dc0bdf3b14b7f9815775af9dfee80a63b4748',
  'laminas/laminas-zendframework-bridge' => '1.0.1@0fb9675b84a1666ab45182b6c5b29956921e818d',
  'laravel/framework' => 'v5.7.28@8e69728f1c80a024588adbd24c65c4fcf9aa9192',
  'laravel/nexmo-notification-channel' => 'v1.0.1@03edd42a55b306ff980c9950899d5a2b03260d48',
  'laravel/passport' => 'v7.5.1@d63cdd672c3d65b3c35b73d0ef13a9dbfcb71c08',
  'laravel/slack-notification-channel' => 'v1.0.3@6e164293b754a95f246faf50ab2bbea3e4923cc9',
  'laravel/telescope' => 'v1.2@c74326c6dbf6b722c2d35e43e324b79e51a0dbc0',
  'laravel/tinker' => 'v1.0.10@ad571aacbac1539c30d480908f9d0c9614eaf1a7',
  'lcobucci/jwt' => '3.3.1@a11ec5f4b4d75d1fcd04e133dede4c317aac9e18',
  'league/event' => '2.2.0@d2cc124cf9a3fab2bb4ff963307f60361ce4d119',
  'league/flysystem' => '1.0.63@8132daec326565036bc8e8d1876f77ec183a7bd6',
  'league/flysystem-aws-s3-v3' => '1.0.23@15b0cdeab7240bf8e8bffa85ae5275bbc3692bf4',
  'league/oauth2-server' => '7.4.0@2eb1cf79e59d807d89c256e7ac5e2bf8bdbd4acf',
  'maatwebsite/excel' => '3.1.18@d0231ab1f4bb93c8695630cb445ada1fdc54add0',
  'markbaker/complex' => '1.4.7@1ea674a8308baf547cbcbd30c5fcd6d301b7c000',
  'markbaker/matrix' => '1.2.0@5348c5a67e3b75cd209d70103f916a93b1f1ed21',
  'monolog/monolog' => '1.25.3@fa82921994db851a8becaf3787a9e73c5976b6f1',
  'moontoast/math' => '1.2.1@5f47d34c87767dbcc08b30377a9827df71de91fa',
  'mtdowling/jmespath.php' => '2.5.0@52168cb9472de06979613d365c7f1ab8798be895',
  'nesbot/carbon' => '1.39.1@4be0c005164249208ce1b5ca633cd57bdd42ff33',
  'nexmo/client' => '1.9.1@c6d11d953c8c5594590bb9ebaba9616e76948f93',
  'nexmo/client-core' => '1.8.1@182d41a02ebd3e4be147baea45458ccfe2f528c4',
  'nikic/php-parser' => 'v4.3.0@9a9981c347c5c49d6dfe5cf826bb882b824080dc',
  'ocramius/package-versions' => '1.5.1@1d32342b8c1eb27353c8887c366147b4c2da673c',
  'opis/closure' => '3.5.1@93ebc5712cdad8d5f489b500c59d122df2e53969',
  'paragonie/random_compat' => 'v9.99.99@84b4dfb120c6f9b4ff7b3685f9b8f1aa365a0c95',
  'php-http/client-common' => '1.10.0@c0390ae3c8f2ae9d50901feef0127fb9e396f6b4',
  'php-http/discovery' => '1.7.4@82dbef649ccffd8e4f22e1953c3a5265992b83c0',
  'php-http/guzzle6-adapter' => 'v1.1.1@a56941f9dc6110409cfcddc91546ee97039277ab',
  'php-http/httplug' => 'v1.1.0@1c6381726c18579c4ca2ef1ec1498fdae8bdf018',
  'php-http/message' => '1.8.0@ce8f43ac1e294b54aabf5808515c3554a19c1e1c',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'php-http/promise' => 'v1.0.0@dc494cdc9d7160b9a09bd5573272195242ce7980',
  'phpoffice/phpspreadsheet' => '1.10.1@1648dc9ebef6ebe0c5a172e16cf66732918416e0',
  'phpseclib/bcmath_compat' => '1.0.4@f805922db4b3d8c1e174dafb74ac7374264e8880',
  'phpseclib/phpseclib' => '2.0.23@c78eb5058d5bb1a183133c36d4ba5b6675dfa099',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.2@446d54b4cb6bf489fc9d75f55843658e6f25d801',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.9.12@90da7f37568aee36b116a030c5f99c915267edd4',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/uuid' => '3.9.2@7779489a47d443f845271badbdcedfe4df8e06fb',
  'riverline/multipart-parser' => '2.0.6@f71c80281d8f04e840c31edede6516b63f4d699b',
  'rize/uri-template' => '0.3.2@9e5fdd5c47147aa5adf7f760002ee591ed37b9ca',
  'rohan0793/jsend' => '1.2.3@f355a18c9555b0d0f30ef59f456070476177c9b1',
  'sentry/sdk' => '2.1.0@18921af9c2777517ef9fb480845c22a98554d6af',
  'sentry/sentry' => '2.3.0@335bd24c4a817efdb7c3ec83ca42321a7761df6a',
  'sentry/sentry-laravel' => '1.5.0@724e86b3f96e2b87856b818a2bf53c80e796c279',
  'smartins/passport-multiauth' => 'v4.1.0@35c56761d6b89fab7715639828fdb099841c6cd9',
  'superbalist/flysystem-google-storage' => '7.2.2@87e2f450c0e4b5200fef9ffe6863068cc873d734',
  'swagger-api/swagger-ui' => 'v3.24.3@94e101924b84435585896f4ea7c4092182a91f23',
  'swiftmailer/swiftmailer' => 'v6.2.3@149cfdf118b169f7840bbe3ef0d4bc795d1780c9',
  'symfony/console' => 'v4.4.2@82437719dab1e6bdd28726af14cb345c2ec816d0',
  'symfony/css-selector' => 'v5.0.2@19d29e7098b7b2c3313cb03902ca30f100dcb837',
  'symfony/debug' => 'v4.4.2@5c4c1db977dc70bb3250e1308d3e8c6341aa38f5',
  'symfony/error-handler' => 'v4.4.2@6d7d7712a6ff5215ec26215672293b154f1db8c1',
  'symfony/event-dispatcher' => 'v4.4.2@b3c3068a72623287550fe20b84a2b01dcba2686f',
  'symfony/event-dispatcher-contracts' => 'v1.1.7@c43ab685673fb6c8d84220c77897b1d6cdbe1d18',
  'symfony/finder' => 'v4.4.2@ce8743441da64c41e2a667b8eb66070444ed911e',
  'symfony/http-foundation' => 'v4.4.2@fcae1cff5b57b2a9c3aabefeb1527678705ddb62',
  'symfony/http-kernel' => 'v4.4.2@fe310d2e95cd4c356836c8ecb0895a46d97fede2',
  'symfony/mime' => 'v5.0.2@0e6a4ced216e49d457eddcefb61132173a876d79',
  'symfony/options-resolver' => 'v5.0.2@1ad3d0ffc00cc1990e5c9c7bb6b81578ec3f5f68',
  'symfony/polyfill-ctype' => 'v1.13.1@f8f0b461be3385e56d6de3dbb5a0df24c0c275e3',
  'symfony/polyfill-iconv' => 'v1.13.1@a019efccc03f1a335af6b4f20c30f5ea8060be36',
  'symfony/polyfill-intl-idn' => 'v1.13.1@6f9c239e61e1b0c9229a28ff89a812dc449c3d46',
  'symfony/polyfill-mbstring' => 'v1.13.1@7b4aab9743c30be783b73de055d24a39cf4b954f',
  'symfony/polyfill-php72' => 'v1.13.1@66fea50f6cb37a35eea048d75a7d99a45b586038',
  'symfony/polyfill-php73' => 'v1.13.1@4b0e2222c55a25b4541305a053013d5647d3a25f',
  'symfony/polyfill-uuid' => 'v1.13.1@7d4215b6944add5073f0ec313a21e1bc2520520d',
  'symfony/process' => 'v4.4.2@b84501ad50adb72a94fb460a5b5c91f693e99c9b',
  'symfony/psr-http-message-bridge' => 'v1.3.0@9d3e80d54d9ae747ad573cad796e8e247df7b796',
  'symfony/routing' => 'v4.4.2@628bcafae1b2043969378dcfbf9c196539a38722',
  'symfony/service-contracts' => 'v2.0.1@144c5e51266b281231e947b51223ba14acf1a749',
  'symfony/translation' => 'v4.4.2@f7669f48a9633bf8139bc026c755e894b7206677',
  'symfony/translation-contracts' => 'v2.0.1@8cc682ac458d75557203b2f2f14b0b92e1c744ed',
  'symfony/var-dumper' => 'v4.4.2@be330f919bdb395d1e0c3f2bfb8948512d6bdd99',
  'symfony/yaml' => 'v4.4.2@a08832b974dd5fafe3085a66d41fe4c84bb2628c',
  'tijsverkoyen/css-to-inline-styles' => '2.2.2@dda2ee426acd6d801d5b7fd1001cde9b5f790e15',
  'twilio/sdk' => '5.42.0@e1ea30f30e424ae76de01cfd8d582a5d29b13267',
  'unisharp/laravel-filemanager' => 'v2.0.0-alpha8@8639557f6a945dfae4cc013b7a35d68d9fce1e74',
  'vlucas/phpdotenv' => 'v2.6.1@2a7dcf7e3e02dc5e701004e51a6f304b713107d5',
  'zendframework/zend-diactoros' => '2.2.1@de5847b068362a88684a55b0dbb40d85986cfa52',
  'zircote/swagger-php' => '3.0.3@c86386bd623ffad6f7e6f9269bf51d42d2797012',
  'beyondcode/laravel-dump-server' => '1.3.0@fcc88fa66895f8c1ff83f6145a5eff5fa2a0739a',
  'doctrine/instantiator' => '1.3.0@ae466f726242e637cebdd526a7d991b9433bacf1',
  'filp/whoops' => '2.7.1@fff6f1e4f36be0e0d0b84d66b413d9dcb0c49130',
  'fzaninotto/faker' => 'v1.9.1@fc10d778e4b84d5bd315dad194661e091d307c6f',
  'hamcrest/hamcrest-php' => 'v2.0.0@776503d3a8e85d4f9a1148614f95b7a608b046ad',
  'mockery/mockery' => '1.3.1@f69bbde7d7a75d6b2862d9ca8fab1cd28014b4be',
  'myclabs/deep-copy' => '1.9.4@579bb7356d91f9456ccd505f24ca8b667966a0a7',
  'nunomaduro/collision' => 'v2.1.1@b5feb0c0d92978ec7169232ce5d70d6da6b29f63',
  'phar-io/manifest' => '1.0.3@7761fcacf03b4d4f16e7ccb606d4879ca431fcf4',
  'phar-io/version' => '2.0.1@45a2ec53a73c70ce41d55cedef9063630abaf1b6',
  'phpdocumentor/reflection-common' => '2.0.0@63a995caa1ca9e5590304cd845c15ad6d482a62a',
  'phpdocumentor/reflection-docblock' => '4.3.4@da3fd972d6bafd628114f7e7e036f45944b62e9c',
  'phpdocumentor/type-resolver' => '1.0.1@2e32a6d48972b2c1976ed5d8967145b6cec4a4a9',
  'phpspec/prophecy' => '1.10.1@cbe1df668b3fe136bcc909126a0f529a78d4cbbc',
  'phpunit/php-code-coverage' => '6.1.4@807e6013b00af69b6c5d9ceb4282d0393dbb9d8d',
  'phpunit/php-file-iterator' => '2.0.2@050bedf145a257b1ff02746c31894800e5122946',
  'phpunit/php-text-template' => '1.2.1@31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
  'phpunit/php-timer' => '2.1.2@1038454804406b0b5f5f520358e78c1c2f71501e',
  'phpunit/php-token-stream' => '3.1.1@995192df77f63a59e47f025390d2d1fdf8f425ff',
  'phpunit/phpunit' => '7.5.20@9467db479d1b0487c99733bb1e7944d32deded2c',
  'sebastian/code-unit-reverse-lookup' => '1.0.1@4419fcdb5eabb9caa61a27c7a1db532a6b55dd18',
  'sebastian/comparator' => '3.0.2@5de4fc177adf9bce8df98d8d141a7559d7ccf6da',
  'sebastian/diff' => '3.0.2@720fcc7e9b5cf384ea68d9d930d480907a0c1a29',
  'sebastian/environment' => '4.2.3@464c90d7bdf5ad4e8a6aea15c091fec0603d4368',
  'sebastian/exporter' => '3.1.2@68609e1261d215ea5b21b7987539cbfbe156ec3e',
  'sebastian/global-state' => '2.0.0@e8ba02eed7bbbb9e59e43dedd3dddeff4a56b0c4',
  'sebastian/object-enumerator' => '3.0.3@7cfd9e65d11ffb5af41198476395774d4c8a84c5',
  'sebastian/object-reflector' => '1.1.1@773f97c67f28de00d397be301821b06708fca0be',
  'sebastian/recursion-context' => '3.0.0@5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8',
  'sebastian/resource-operations' => '2.0.1@4d7a795d35b889bf80a0cc04e08d77cedfa917a9',
  'sebastian/version' => '2.0.1@99732be0ddb3361e16ad77b68ba41efc8e979019',
  'theseer/tokenizer' => '1.1.3@11336f6f84e16a720dae9d8e6ed5019efa85a0f9',
  'webmozart/assert' => '1.6.0@573381c0a64f155a0d9a23f4b0c797194805b925',
  'xethron/laravel-4-generators' => '3.1.1@526f0a07d8ae44e365a20b1bf64c9956acd2a859',
  'xethron/migrations-generator' => 'v2.0.2@a05bd7319ed808fcc3125212e37d30ccbe0d2b8b',
  'sethsandaru/laravel-hmvc-sample' => 'dev-development@476be8758c9eb3a107abe37194b8f3ba556e4e0e',
);

    private function __construct()
    {
    }

    /**
     * @throws \OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new \OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}