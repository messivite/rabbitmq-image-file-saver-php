
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__."/config/config.php";


/**
 * Singleton Pattern.
 * 
 * Modern implementation.
 */
class Singleton
{
    /**
     * Call this method to get singleton
     */
    public static function instance()
    {
      static $instance = false;
      if( $instance === false )
      {
        // Late static binding (PHP 5.3+)
        $instance = new static();
      }

      return $instance;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct() {}

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {}

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {}

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup() {}

}


/**
 * Database.
 *
 * Inherited from Singleton, so it's now got singleton behavior.
 */
class Database extends Singleton {

  protected $label;

  public $connection,$channel,$amqObject;

  private static $_doResizeImage = "_doResizeImage";
  public function __construct() {

  	try{
		$this->connection = new AMQPStreamConnection(Config::get('rabbitmq/host'), Config::get('rabbitmq/port'), Config::get('rabbitmq/username'), Config::get('rabbitmq/password') );
  	}catch(Exception $e) {
  		throw new Exception('Please check your rabbitmq service config file',0);
  	}
  	
  }
  /**
   * Example of that singleton is working correctly.
   */
  public function setLabel($label)
  {
    $this->label = $label;
  }

  public function getLabel()
  {
    return $this->label;
  }


  public function debugRun(){

  	return $this;
  }

  public function startRabbitMQ(){
	$this->channel = $this->connection->channel();
  	return $this->channel;
  }


 

  public function amqDoResizeImage(){

  	$this->amqObject = new AMQPMessage("_doResizeImage");
  	return $this->amqObject;
  }
}











?>