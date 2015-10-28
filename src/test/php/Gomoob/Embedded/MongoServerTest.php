<?php

/**
 * gomoob/php-embedded-mongo
 *
 * @copyright Copyright (c) 2015, GOMOOB SARL (http://gomoob.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE.md file)
 */
namespace Gomoob\Embedded;

/**
 * Test case used to test the `MongoServer` class.
 *
 * @author Baptiste GAILLARD (baptiste.gaillard@gomoob.com)
 * @group MongoServerTest
 */
class MongoServerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test method for standard calls to `start()` and `stop()`.
	 */
    public function testStart()
    {
        $mongoServer = new MongoServer();
        $mongoServer->start();
        
        sleep(2);
        
        $mongoServer->stop();
    }
}