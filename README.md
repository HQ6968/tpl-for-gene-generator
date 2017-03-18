# tpl-for-gene-generator
php 模版生成

# dev
useage:

```

$content =  <<<FILE
<?php
dddfasfasfsafd ${a} a
adfasfasdfasfd ${b[0]->xxxx} adf

adfasfasdfasfd ${b[0][cccc]} adf

adfasfasdfasfd ${b[0][ccc]}
FIlE:


// 解析过程

1. 提取${ A }  A
2. 取出空格 
3. 解析开始关键词 [ , ->  
4. 如果是 [ 记录位置 p , 第一个变量为  $v0 = ${substr(A,0,p0)}
5. 解析到下一个 ] ,记录位置 p1 , 得到key为  $key = ${substr(A,p0+1,p1)}  $v1 = $v0[$key]

// $var 为提取出来的关键词 b[0]->xxxx  b[0][ccc]  aaa
function parseVar($var,$data){
  // 简单变量
  if(strpos($var , '[') ===false &&  strpos($var , '->') == false){
    return $data[$var] ;
  }
  
  $len = strlen($var) ;
  foreach( $var as $p => $c ){
    if($c == '['){
      //如果是数组解析key 
    }else if( ($p < $len-1 ) &&  $c == '-' && $var[$p+1] == '>'){   // ->
      
    }
  }
}




use Tpl ;
class demo {
   public function exec(){
      $d['a'] = 'aa' ;
      $d['b'] = [1,2,3] ;
      $d['c'] = [
        'f1' => 'ssss'  ,
        'f2' => '2222' 
      ]
      
      Tpl::parse($content , $d) ;
   }
}




```
