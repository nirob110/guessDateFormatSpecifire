<?php 

class guessFormatSpecifire {
    public $regexpWordBoundary = '/\b/m';
    public $regsep = '/[\.|,|\s|\-|\/]{0,2}/m';
    public $regnumberday = '/^[\d]{1,2}/m';
    public $regnumbermonth = '/^[\d]{1,2}/m';
    public $regnumberyear = '/^(\d{2}|\d{4})$/m';
    //$regallmonthsplit = '/JANUARY|January|january|JAN|Jan|jan|FEBRUARY|February|february|FEB|Feb|feb|MARCH|March|march|MAR|Mar|mar|APRIL|April|april|APR|Apr|apr|MAY|May|may|JUNE|June|june|JUN|Jun|jun|JULY|July|july|JUL|Jul|jul|AUGUST|August|august|AUG|Aug|aug|SEPTEMBER|September|september|SEP|Sep|sep|OCTOBER|October|october|OCT|Oct|oct|NOVEMBER|November|november|NOV|Nov|nov|DECEMBER|December|december|DEC|Dec/m';
    public $noseparatorreg = '/^[\d]{1,2}([a-zA-Z]{1,9})[\d]{2,4}$|^([a-zA-Z]{1,9})[\d]{2,4}$/m';
    public $regallmonth = '/^JANUARY$|^January$|^january$|^JAN$|^Jan$|^jan$|^FEBRUARY$|^February$|^february$|^FEB$|^Feb$|^feb$|^MARCH$|^March$|^march$|^MAR$|^Mar$|^mar$|^APRIL$|^April$|^april$|^APR$|^Apr$|^apr$|^MAY$|^May$|^may$|^JUNE$|^June$|^june$|^JUN$|^Jun$|^jun$|^JULY$|^July$|^july$|^JUL$|^Jul$|^jul$|^AUGUST$|^August$|^august$|^AUG$|^Aug$|^aug$|^SEPTEMBER$|^September$|^september$|^SEP$|^Sep$|^sep$|^OCTOBER$|^October$|^october$|^OCT$|^Oct$|^oct$|^NOVEMBER$|^November$|^november$|^NOV$|^Nov$|^nov$|^DECEMBER$|^December$|^december$|^DEC$|^Dec$/m';
    public $monthFullCapReg = '/JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER/m';
    public $monthFullWCapReg = '/January|February|March|April|May|June|July|August|September|October|November|December/m';
    public $monthFullLowReg = '/january|february|march|april|may|june|july|august|september|october|november|december/m';
    public $monthShortCapReg = '/JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC/m';
    public $monthShortWcapReg = '/Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec/m';
    public $monthShortLowReg = '/jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec/m';
    
    public $primaryDateString = "";
    public $patternArray = array();
    
    public function parse(String $dateString){
        if($this->checkString($dateString)){
            $this->primaryDateString = $dateString;
            $this->patternArray = preg_split($this->regexpWordBoundary, $this->primaryDateString);
        }
        
        return $this->formatSpecifire();
    }
    
    public function formatSpecifire(){
        if($this->checkArray($this->patternArray)){
            $format = "";
            foreach($this->patternArray as $key => $val){
                $sepMatch = array();
                $daymatch = array();
                $monthmatch = array();
                $monthFullCapRegMatching = array();
                $monthFullWCapRegMatching = array();
                $monthFullLowRegMatching = array();
                $monthShortCapRegMatching = array();
                $monthShortWcapRegMatching = array();
                $monthShortLowRegMatching = array();
                $yearmatch = array();
                $regnumbermonthmatch = array();
                if(empty($val)) {
                    $format .= " ";
                    continue;
                }
                
                if(preg_match($noseparatorreg, $val)){
                    $pat = str_split($val);
                    // dump($pat);
                    $day = "";
                    $month = "";
                    $year = "";
                    foreach($pat as $v){
                        //day
                        if(preg_match('/\d/m',$v)){
                            if(empty($month)){
                                $day .= $v;
                            }
                        }
                        
                        if(preg_match('/[a-zA-Z]{1}/m',$v)){
                            $month .= $v;
                        }
                        
                        if(preg_match('/\d/m',$v)){
                            if(isset($month) && !empty($month)){
                                $year .= $v;
                            }
                        }
                    }
                    
                    echo 'day: ' .$day .' month: '.$month. ' year: '.$year . '<br>';
                    //echo $val;
                    continue;
                }
                
            }
        }
    }
    
    //helpers
    //HELPERS
    public function checkString($string){
        if(isset($string) && !empty($string)){
            return true;
        }
        return false;
    }
    
    
    public function checkArray($array){
        if(is_array($array) && sizeof($array)){
            return true;
        }
        return false;
    }
    
    public function dd($data){
        $args = func_get_args();
        echo '<pre>';
        if(count($args) > 1){
            print_r($args);
        }else{
            print_r($data);
        }
        echo '</pre>';
        die();
    }
    
    public function dump($data){
        $args = func_get_args();
        echo '<pre>';
        if(count($args) > 1){
            print_r($args);
        }else{
            print_r($data);
        }
        echo '</pre>';
    }
    
    
}