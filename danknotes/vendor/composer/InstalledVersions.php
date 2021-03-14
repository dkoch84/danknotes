<?php











namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'v2.1',
    'version' => '2.1.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => 'picocms/pico-composer',
  ),
  'versions' => 
  array (
    'erusev/parsedown' => 
    array (
      'pretty_version' => '1.8.0-beta-7',
      'version' => '1.8.0.0-beta7',
      'aliases' => 
      array (
      ),
      'reference' => 'fe7a50eceb4a3c867cc9fa9c0aa906b1067d1955',
    ),
    'erusev/parsedown-extra' => 
    array (
      'pretty_version' => '0.8.0-beta-1',
      'version' => '0.8.0.0-beta1',
      'aliases' => 
      array (
      ),
      'reference' => 'e756b1bf8642ab1091403e902b0503f1cec7527d',
    ),
    'picocms/composer-installer' => 
    array (
      'pretty_version' => 'v1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '6b5036c83aa091ed76e2a76ed9335885f95a7db7',
    ),
    'picocms/pico' => 
    array (
      'pretty_version' => 'v2.1.4',
      'version' => '2.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '7228129cade3f812f22904b503c939b04a75c9dd',
    ),
    'picocms/pico-composer' => 
    array (
      'pretty_version' => 'v2.1',
      'version' => '2.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'picocms/pico-deprecated' => 
    array (
      'pretty_version' => 'v2.1.4',
      'version' => '2.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '8d1a4056ecc71cc2857e91d50bcb38db91d424e0',
    ),
    'picocms/pico-theme' => 
    array (
      'pretty_version' => 'v2.1.4',
      'version' => '2.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd4ec8df28356f1e034a97d37327b9aecb3129eed',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e',
    ),
    'symfony/yaml' => 
    array (
      'pretty_version' => 'v2.8.52',
      'version' => '2.8.52.0',
      'aliases' => 
      array (
      ),
      'reference' => '02c1859112aa779d9ab394ae4f3381911d84052b',
    ),
    'twig/twig' => 
    array (
      'pretty_version' => 'v1.44.2',
      'version' => '1.44.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '138c493c5b8ee7cff3821f80b8896d371366b5fe',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
