<?php

class __Test extends PHPUnit_Framework_TestCase
{

    /* @compact */
    public function testCompact()
    {
        $object = array(
        	0, 1, false, 2, '', 3
        );

        $return = array(
        	1, 2, 3
        );

        $result = __::compact($object);

        $this->assertEquals($return, $result);
    }

    /* @difference */
    public function testDifference()
    {
        $object = array(
        	array(1, 2, 3, 4, 5), 
        	array(5, 2, 10)
        );

        $return = array(
        	1, 3, 4
        );

        $result = __::difference($object[0], $object[1]);

        $this->assertEquals($return, $result);
    }

    /* @findIndex */
    public function testFindIndex()
    {
        $object = array(
  			array('name' => 'barney',  'age' => 36, 'blocked' => false ),
  			array('name' => 'joe',  'age' => 50, 'blocked' => true ),
  			array('name' => 'anton',  'age' => 2, 'blocked' => false )
		);

        $return = 2;

        $result = __::findIndex($object, function($row){
        	if( $row['age'] < 10 ){
        		return true;
        	}else{
        		return false;
        	}
        });

        $this->assertEquals($return, $result);
    }

    /* @findLastIndex */
    public function testFindLastIndex()
    {
        $object = array(
  			array('name' => 'barney',  'age' => 36, 'blocked' => false ),
  			array('name' => 'joe',  'age' => 50, 'blocked' => true ),
  			array('name' => 'anton',  'age' => 2, 'blocked' => false )
		);

        $return = 1;

        $result = __::findLastIndex($object, function($row){
        	if( $row['age'] > 10 ){
        		return true;
        	}else{
        		return false;
        	}
        });

        $this->assertEquals($return, $result);
    }

    /* @first */
    public function testFirst()
    {
        $object = array(
  			5, 10 , 15, 20, 25, 30
		);

        $return = array(
  			15, 20
		);

        $result = __::first($object, 2, function($row){
        	if( $row > 10 ){
        		return true;
        	}else{
        		return false;
        	}
        });

        $this->assertEquals($return, $result);
    }

    /* @Flatten */
    public function testFlatten()
    {
        $object = array(
  			array(1,2,array(3,array(4,5)),6)
		);

        $return = array(
  			1, 2, 3, 4, 5, 6
		);

        $result = __::flatten($object);

        $this->assertEquals($return, $result);
    }

    /* @indexOf */
    public function testIndexOf()
    {
        $object = array(
            5, 10 , 15, 20
        );

        $return = 1;

        $result = __::indexOf($object, 10);

        $this->assertEquals($return, $result);
    }

    /* @last */
    public function testLast()
    {
        $object = array(
            5, 10, 15, 20
        );

        $return = array(
            5
        );

        $result = __::last($object, 2, function($row){
            if( $row < 10 ){
                return true;
            }else{
                return false;
            }
        });

        $this->assertEquals($return, $result);
    }

    /* @lastIndexOf */
    public function testLastIndexOf()
    {
        $object = array(
            5, 2, 2, 20
        );

        $return = 2;

        $result = __::lastIndexOf($object, 2);

        $this->assertEquals($return, $result);
    }

    /* @range */
    public function testRange()
    {
        $return = array(
            0, 5, 10, 15
        );

        $result = __::range(0, 20, 5);

        $this->assertEquals($return, $result);
    }

    /* @remove */
    public function testRemove()
    {
        $object = array(
            1, 2, 3, 4, 5
        );

        $return = array(
            1, 3, 5
        );

        $result = __::remove($object, function($num){
            if( $num % 2 == 0 ){
                return true;
            }else{
                return false;
            }
        });

        $this->assertEquals($return, $result);
    }

    /* @filter */
    public function testFilter()
    {
        $object = array(
            1, 2, 3, 4, 5
        );

        $return = array(
            2, 4
        );

        $result = __::filter($object, function($num){
            if( $num % 2 == 0 ){
                return true;
            }else{
                return false;
            }
        });

        $this->assertEquals($return, $result);
    }

    /* @union */
    public function testUnion()
    {
        $object = array(
            array(1, 2, 3, 4, 5),
            array(3, 4, 5, 6, 7),
            array(5, 6, 7, 8, 9, 10),
        );

        $return = array(
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        );

        $result = __::union($object[0], $object[1], $object[2]);

        $this->assertEquals($return, $result);
    }

    /* @uniq */
    public function testUniq()
    {
        $object = array(
            1, 2, 2, 2, 5
        );

        $return = array(
            1, 2, 5
        );

        $result = __::uniq($object);

        $this->assertEquals($return, $result);
    }

    /* @zip */
    public function testZip()
    {
        $object = array(
            array('a', 'b'),
            array(10, 20),
            array(true, false),
        );

        $return = array(
            array('a', 10, true),
            array('b', 20, false),
        );

        $result = __::zip($object[0], $object[1], $object[2]);

        $this->assertEquals($return, $result);
    }

    /* @tap */
    public function testTap()
    {
        $object = array(
            1, 2, 3, 4, 5
        );

        $return = array(
            1, 2, 3, 4, 'test' => true
        );

        $result = __::tap($object, function($array){
            array_pop($array);
            $array['test'] = true;

            return $array;
        });

        $this->assertEquals($return, $result);
    }

    /* @at */
    public function testAt()
    {
        $object = array(
            1, 2, 3, 4, 5
        );

        $return = array(
            2, 3
        );

        $result = __::at($object, array(1, 2));

        $this->assertEquals($return, $result);
    }

    /* @contains */
    public function testContains()
    {
        $object = array(
            1, 2, 3, 4, 5
        );

        $return = true;

        $result = __::contains($object, 4);

        $this->assertEquals($return, $result);
    }

    /* @pluck */
    public function testPluck()
    {
        $object = array(
            array('a' => '1', 'b' => '643'),
            array('a' => '2', 'b' => '423'),
            array('a' => '3', 'b' => '123'),
        );

        $return = array(
            1, 2, 3
        );

        $result = __::pluck($object, 'a');

        $this->assertEquals($return, $result);
    }

}