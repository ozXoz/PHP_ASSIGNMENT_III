<?php
// 101304595
// Ahmet Buyukbas


//step 1

class Mammal
{
    public $age;
    private $live_birth;

    //step 2
    function __construct($p_age)
    {
        echo "In parent constructor";
        $this->age = $p_age;
        $this->live_birth = true;

    }

    //step 3
    function __destruct() {
        echo "In parent destructor";
    }

    //step 4
    function print_str(){
        echo "The datatype of this object is: _____________";
    }

    //step 5
    function getLiveBirth(){
        return $this->live_birth;
    }

}

//step 6
$mammal = new Mammal(1);
echo "<br> Does a mammal give live birth?: ";

//step 7

class Dog extends Mammal {
    public $tail_length;
    private $bark_type;

    //step 8
    function __construct($p_age,$p_tail_length, $p_bark_type)
    {
        parent::__construct($p_age);
        echo "In child constructor: Dog";
        $this->tail_length = $p_tail_length;
        $this->bark_type = $p_bark_type;

    }

    //step 9
    function __destruct() {
        echo "In child destructor: Dog";
    }

    //step 10
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    function getBarkType(){
        return $this->bark_type;
    }

}
//step 11
$dog1 = new Dog(5,2,"Grr");
echo "<br> Dog’s bark type: ";

//step 12
class Human extends Mammal {
    public int $NUM_HUMANS_TOTAL = 8000000000;

    //step 13
    function __construct($p_age)
    {
        parent::__construct($p_age);
        echo "In child constructor: Human";
        $this->NUM_HUMANS_TOTAL += 1;

    }

    //step 14
    function __destruct() {
        echo "In child destructor: Human";
    }

}
//step 15
$human1 = new Human(10);
echo "<br> The age of this human is:".$human1->age;

?>



<?php
echo "<hr>";
show_source(__FILE__);
?>

