# tpl-for-gene-generator
php 模版生成

# useage:

```
class Demo {
    public $p1 ;
    public $p2 ;
    public $p3 ;
    public function __construct($p1,$p2,$p3)
    {
        $this->p1 = $p1 ;
        $this->p2 = $p2 ;
        $this->p3 = $p3 ;
    }
}

$d0 = new Demo([1,2,3],2,3) ;
$d1 = new Demo([$d0,2,3],2,3) ;
$d2 = new Demo(1,2,3) ;
$d3 = new Demo(1,2,3) ;

$data = [
    'fff' => [
        $d1 ,
        $d2 ,
        $d3 ,
    ]
] ;
$str = 'asdfafasdf${fff[0]->p1}asdfasdas   ${fff}' ;
$paser = new Parser() ;
$content = $paser->parse($str , $data) ;
echo $content ;

```
