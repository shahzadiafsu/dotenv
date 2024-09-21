<?php

declare(strict_types=1);

/**
 * 
 */
namespace Dotenv;

use Dotenv\Parser\ParserInterface;
use Dotenv\Parser\Parser;
use Dotenv\Loader\LoaderInterface;
use Dotenv\Loader\Loader;
use Dotenv\Validator\Validator;
use Dotenv\Store\StoreInterface;
use Dotenv\Store\PathBuilder;

class Dotenv
{

  /**
   * @var \Dotenv\Loader\LoaderInterface   $loader
   * @var \Dotenv\Parser\ParserInterface   $parser
   * @var \Dotenv\Store\StoreInterface     $store
   */
  private $loader;
  private $parser;
  private $store;

  /**
   * 
   * 
   * @var \Dotenv\Dotenv\VERSION         VERSION
   */
  public const VERSION = '1.0.0';

  /**
   * 
   * @param \Dotenv\Store\StoreInterface   $store
   * @param \Dotenv\Loader\LoaderInterface $loader
   * @param \Dotenv\Parser\ParserInterface $parser
   * 
   * @return void
   */
  public function __construct(StoreInterface $store, LoaderInterface $loader, ParserInterface $parser)
  {
    $this->loader = $loader;
    $this->parser = $parser;
    $this->store  = $store;
  }

  /**
   * 
   * 
   * @param string|null $path
   * @param string|null $name
   * @param string|null $file_encoding
   * @param
   * 
   * @return \Dotenv\Dotenv
   */
  public static function config(?string $path=null, ?string $name=null, ?string $file_encoding=null)
  {
    return self::init((!$path ? $_SERVER['DOCUMENT_ROOT'] : $path), $name, $file_encoding);
  }

  /**
   * 
   */
  public static function quickLoad()
  {
    return self::config()->safeLoad();
  }

  /**
   * 
   * 
   * @return \Dotenv\Dotenv
   */
  public function safeLoad()
  {
    try {$this->load();} catch(\Exception $e) {return [];}
  }

  /**
   * 
   * 
   * @return \Dotenv\Dotenv
   */
  public function load()
  {
    $this->loader->load($this->parser->parse($this->store->read()));
  }

  /**
   * 
   * 
   * @param string      $path
   * @param string|null $name
   * @param string|null $file_encoding
   * @param
   * 
   * @return \Dotenv\Dotenv
   */
  public static function init($path, ?string $name=null, ?string $file_encoding=null /*#param=end*/)
  {
    $PathBuilder = $name===null ? PathBuilder::setWithName() : PathBuilder::setWithoutName();
    $name && ($PathBuilder = $PathBuilder->addName($name));
    $path && ($PathBuilder = $PathBuilder->addPath($path));
    return new self($PathBuilder->fileEncoding($file_encoding)->make(), new Loader(), new Parser());
  }
}
?>
