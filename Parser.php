<?php
class Parser
{
    public $preData;

    public function parse($content,$data){
        preg_match_all('/\$\{(.*)\}/Us',$content,$matchs) ;
        if(empty($matchs[1])){
            return $content ;
        }else{
            foreach ($matchs[1] as $m){
                echo " [ m : $m]  \n" ;
                $rep = $this->parseOne($m,$data) ;
                if(!is_string($rep)){
                    $rep = json_encode($rep) ;
                }
                $search = '${'.$m.'}' ;
                $content = str_replace($search,$rep,$content) ;
            }
        }
        return $content ;
    }
    public function parseOne($str, $data)
    {
        $str = $this->nomalize($str);
        $len = strlen($str) ;
        $this->preData = $data;
        $tags = $this->parseTags($str);
        $taglen = count($tags);
        foreach ($tags as $k => $t) {
            switch ($t[0]) {
                case ']':
                    $s = $tags[$k - 1][1] + 1;
                    $e = $t[1];
                    $name = substr($str, $s, $e - $s);
                    //echo "[ name:{$name} , k:{$k} , prev:{$tags[$k-1][1]} ] current: {$t[1]} \n" ;
                    $this->preData = $this->preData[$name];
                    break;
                case '->':
                    $s = $t[1] + 2;
                    if ($k == $taglen - 1) {
                        $e = $len;
                    } else {
                        $e = $tags[$k + 1][1];
                    }
                    $name = substr($str, $s, $e - $s);
                    //echo "{ name : {$name} , s: {$s} } \n" ;
                    $this->preData = $this->preData->{$name};
                    break;
            }
        }
        return $this->preData;
    }

    private function nomalize($str){
        $len = strlen($str) ;
        $find = -1 ;
        for ($i = 0 ; $i < $len ; $i++){
            $char = $str[$i] ;
            if($char == '['){
                $find = $i ;
                break;
            }else if( ($i < $len -1 ) && $char == '-' && ( $str[$i+1] == '>') ){
                $find = $i ;
                break;
            }
        }

        if( $find == -1 ){
            $str = '['.$str.']';
        }else{
            $str = '['.substr($str ,0 , $find).']'.substr($str,$find,$len)  ;
        }
        return $str ;
    }

    private function parseTags($str){
        $tags = [];
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $c = $str[$i];
            switch ($c) {
                case '[':
                    $tags[] = ['[', $i];
                    break;
                case ']':
                    $tags[] = [']', $i];
                case '-':
                    if (($i < $len - 1) && ($str[$i + 1] == '>')) {
                        $tags[] = ['->', $i];
                    }
                    break;
            }
        }
        return $tags ;
    }
}
