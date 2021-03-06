<?php
/**
 * Created by PhpStorm.
 * User: evaisse
 * Date: 02/06/15
 * Time: 11:19
 */

namespace evaisse\SimpleHttpBundle\Tests\Unit;


class RequestBodyTest extends AbstractTests
{


    public function provideBaseData()
    {

        return array(
            array(
                array(
                    'foo' => 'bar'
                ),
            ),
        );
    }


    /**
     *
     */
    public function testAutomaticDecodingResult()
    {
        list($helper, $httpKernel, $container) = $this->createContext();

        $res = $helper->prepare("GET", 'http://httpbin.org/ip')
            ->execute($httpKernel)
            ->getResult();

        $this->assertEquals(array_key_exists('origin', $res), true);
    }


    /**
     * @dataProvider provideBaseData
     */
    public function testClassicPostBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();

        $statement = $helper->prepare("POST", 'http://httpbin.org/post', $args);
        $statement->execute($httpKernel);
        $res = $statement->getResult();

        $this->assertEquals($res['form'], $args);
    }

    /**
     * @dataProvider provideBaseData
     */
    public function testJsonPostBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();
        $stmt = $helper->prepare("POST", 'http://httpbin.org/post', $args);

        $res = $stmt->json()
            ->execute($httpKernel)
            ->getResult();


        $this->assertEquals($res['data'], json_encode($args));
        $this->assertEquals($res['data'], $stmt->getRequest()->getContent());
        $this->assertEquals($res['json'], $args);

    }

    /**
     * @dataProvider provideBaseData
     */
    public function testClassicPUTBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();
        $statement = $helper->prepare("PUT", 'http://httpbin.org/put', $args);
        $statement->execute($httpKernel);
        $res = $statement->getResult();

        $this->assertEquals($res['form'], $args);

    }


    /**
     * @dataProvider provideBaseData
     */
    public function testJsonPUTBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();
        $stmt = $helper->prepare("PUT", 'http://httpbin.org/put', $args);

        $res = $stmt->json()
            ->execute($httpKernel)
            ->getResult();

        $this->assertEquals($res['data'], json_encode($args));
        $this->assertEquals($res['data'], $stmt->getRequest()->getContent());
        $this->assertEquals($res['json'], $args);

    }



    /**
     * @dataProvider provideBaseData
     */
    public function testClassicDeleteBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();
        $statement = $helper->prepare("DELETE", 'http://httpbin.org/delete', $args);
        $statement->execute($httpKernel);
        $res = $statement->getResult();

        $this->assertEquals($res['form'], $args);

    }


    /**
     * @dataProvider provideBaseData
     */
    public function testJsonDeleteBodyPayloads($args)
    {
        list($helper, $httpKernel, $container) = $this->createContext();
        $stmt = $helper->prepare("DELETE", 'http://httpbin.org/delete', $args);

        $res = $stmt->json()
            ->execute($httpKernel)
            ->getResult();

        $this->assertEquals($res['data'], json_encode($args));
        $this->assertEquals($res['data'], $stmt->getRequest()->getContent());
        $this->assertEquals($res['json'], $args);
    }


}