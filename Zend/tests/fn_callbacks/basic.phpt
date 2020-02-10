--TEST--
fn:: callback basic usage
--FILE--
<?php

namespace Foo\Bar {
    class One {
        function getThisCallback() {
            return fn::$this->meth;
        }
    }
    function baz() {
        return 'Foo.Bar.baz';
    }
    function qux() {
        return baz();
    }

    echo "Static\n";
    var_dump(fn::One::method); // resolve in namespace
    var_dump(fn::\One::mEtHod); // resolve fully qualified

    echo "Dynamic\n";
    $one = new One();
    var_dump(fn::$one->meth);
    var_dump($one->getThisCallback());
    var_dump($one === $one->getThisCallback()[0]);

    echo "Function\n";
    var_dump(fn::intval);

    // TODO implement name resolution
    //var_dump(fn::baz);
}

namespace {
    use function Foo\Bar\baz, Foo\Bar\qux;
    var_dump(fn::iNtVal);
    var_dump(fn::Foo\intval);

    // TODO implement name resolution
    //var_dump(fn::baz);
    //var_dump(fn::qux);
}

?>
--EXPECT--
Static
array(2) {
  [0]=>
  string(11) "Foo\Bar\One"
  [1]=>
  string(6) "method"
}
array(2) {
  [0]=>
  string(3) "One"
  [1]=>
  string(6) "mEtHod"
}
Dynamic
array(2) {
  [0]=>
  object(Foo\Bar\One)#1 (0) {
  }
  [1]=>
  string(4) "meth"
}
array(2) {
  [0]=>
  object(Foo\Bar\One)#1 (0) {
  }
  [1]=>
  string(4) "meth"
}
bool(true)
Function
string(6) "intval"
string(6) "iNtVal"
string(10) "Foo\intval"
