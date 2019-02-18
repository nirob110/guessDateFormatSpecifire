<?php 

class guessFormatSpecifire {
    public $regexpWordBoundary = '/\b/m';
    public $regsep = '/[\.|,|\s|\-|\/]{0,2}/m';
    public $regnumberday = '/^[\d]{1,2}/m';
    public $regnumbermonth = '/^[\d]{1,2}/m';
    public $regnumberyear = '/^(\d{2}|\d{4})$/m';
    public $regallmonthsplit = '/JANUARY|January|january|JAN|Jan|jan|FEBRUARY|February|february|FEB|Feb|feb|MARCH|March|march|MAR|Mar|mar|APRIL|April|april|APR|Apr|apr|MAY|May|may|JUNE|June|june|JUN|Jun|jun|JULY|July|july|JUL|Jul|jul|AUGUST|August|august|AUG|Aug|aug|SEPTEMBER|September|september|SEP|Sep|sep|OCTOBER|October|october|OCT|Oct|oct|NOVEMBER|November|november|NOV|Nov|nov|DECEMBER|December|december|DEC|Dec/m';
    public $noseparatorreg = '/^[\d]{1,2}([a-zA-Z]{1,9})[\d]{2,4}$|^([a-zA-Z]{1,9})[\d]{2,4}$/m';
    public $regalltextualmonth = '/^JANUARY$|^January$|^january$|^JAN$|^Jan$|^jan$|^FEBRUARY$|^February$|^february$|^FEB$|^Feb$|^feb$|^MARCH$|^March$|^march$|^MAR$|^Mar$|^mar$|^APRIL$|^April$|^april$|^APR$|^Apr$|^apr$|^MAY$|^May$|^may$|^JUNE$|^June$|^june$|^JUN$|^Jun$|^jun$|^JULY$|^July$|^july$|^JUL$|^Jul$|^jul$|^AUGUST$|^August$|^august$|^AUG$|^Aug$|^aug$|^SEPTEMBER$|^September$|^september$|^SEP$|^Sep$|^sep$|^OCTOBER$|^October$|^october$|^OCT$|^Oct$|^oct$|^NOVEMBER$|^November$|^november$|^NOV$|^Nov$|^nov$|^DECEMBER$|^December$|^december$|^DEC$|^Dec$/m';
    public $monthFullCapReg = '/JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER/m';
    public $monthFullWCapReg = '/January|February|March|April|May|June|July|August|September|October|November|December/m';
    public $monthFullLowReg = '/january|february|march|april|may|june|july|august|september|october|november|december/m';
    public $monthShortCapReg = '/JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC/m';
    public $monthShortWcapReg = '/Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec/m';
    public $monthShortLowReg = '/jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec/m';
    
    public $primaryDateString = "";
    public $patternArray = array();
    
    public $formatArray = array(
        'format' => "",
    );
    
    
    public function parse(String $dateString){
        if($this->checkString($dateString)){
            $this->primaryDateString = $dateString;
            $this->patternArray = preg_split($this->regexpWordBoundary, $this->primaryDateString);
        }
        
        return $this->formatSpecifire();
    }
    
    public function formatSpecifire(){
        if($this->checkArray($this->patternArray)){
            foreach($this->patternArray as $key => $val){
                $this->checkEmptyPart($key, $val);
                //handle date with textual month names
                if($this->checkPatternMatchingResult($val, $this->regallmonthsplit)){
                    $this->checkDayPart($key, $val);
                    $this->checkTextualMonthPart($key, $val);
                    
                }else{
                    //handle date with numeric month names
                    
                }
            }
           
        }
    }
    
    public function checkEmptyPart($key, $val){
        if(empty($val)){
            $this->formatArray['format'] .= " ";
        }
    }
    
    public function checkDayPart($key, $val){
        $daymatch = array();
        if(preg_match($this->regnumberday, $val, $daymatch) && !empty($trimmedDay = (int)trim($daymatch[0])) && $trimmedDay > 0  && $trimmedDay < 32 && strlen($val) <= 2 && !empty($this->patternArray[5])){
            $this->formatArray['format'] .= strlen($val) == 2 ? 'd' : 'j';
        }
    }
    
    
    public function checkTextualMonthPart($key, $val){
        $monthmatch = array();
        if(preg_match($this->regalltextualmonth, $val, $monthmatch)){
            if($this->checkArray($monthmatch)){
                $trimmedmonth = (string)trim($monthmatch[0]);
                if(!empty($trimmedmonth) && strlen($trimmedmonth) > 0){
                    $this->checkFullCapitalMonthPart($key, $val, $trimmedmonth, $this->monthFullCapReg);
                }
            }
        }
    }
    
    public function checkFullCapitalMonthPart($key, $val, $trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            
        }
    }
    
    //helpers
    //HELPERS
    public function checkPatternMatchingResult($month, $pattern){
        $patternMatching = array();
        if(preg_match($pattern, $month, $patternMatching) && !empty($trimmePatternMatching = (string)trim($patternMatching[0])) && strlen($trimmePatternMatching) > 0){
            return true;
        }
        return false;
    }
    
    public function checkString($string){
        if(isset($string) && !empty($string)){
            return true;
        }
        return false;
    }
    
    
    public function checkArray($array){
        if(is_array($array) && sizeof($array) && count($array) > 0){
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


$ob = new guessFormatSpecifire();
$ob->parse("01 January 2018");