<?php 

class guessFormatSpecifire {
    public $regexpWordBoundary = '/\b/m';
    public $regsep = '/[\.|,|\s|\-|\/]{0,2}/m';
    public $regseparator = "/\.|,|\s|\-|\//m";
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
        'caseDirectionBool' => 0,
        'caseDirection' => ""
    );
    
    
    public function parse(String $dateString){
        $this->formatArray['format'] = "";
        $this->formatArray['caseDirectionBool'] = 0;
        if($this->checkString($dateString)){
            $this->primaryDateString = $dateString;
            $this->patternArray = preg_split($this->regexpWordBoundary, $this->primaryDateString);
            $this->checkTypeofDateString();
        }
        return $this->formatArray;
    }
    
    public function checkTypeofDateString(){
        //check textual date string with separator
        if($this->checkPatternForSeparator($this->primaryDateString, $this->regseparator)){
            //$this->dump($this->primaryDateString);
            //check textual date string with separator
            if($this->checkPatternMatchingResult($this->primaryDateString, $this->regallmonthsplit)){
                $this->handleTextualDateWithSeparator();
            }else{
                //check numeric datestring with separator
                $this->handleNumricDateWithSeparator();
            }
        }
        
        //handle noseparator part
        if($this->checkPatternMatchingResult($this->primaryDateString, $this->noseparatorreg)){
            $this->handleNoSeparatorDates();
        }
     }
    
    public function handleTextualDateWithSeparator(){
        if($this->checkArray($this->patternArray)){
            foreach($this->patternArray as $key => $val){
                if($this->checkEmptyPart($key, $val)){continue;};
                if($this->checkSeparatorPart($key, $val)){continue;}
                if($this->checkDayPartForTextualMonth($key, $val)){continue;};
                if($this->checkTextualMonthPart($key, $val)){continue;};
                if($this->checkYearPartForTextualMonth($key, $val)){continue;};
            }
        }
    }
    
    
    public function handleNumricDateWithSeparator(){
        if($this->checkArray($this->patternArray)){
            foreach($this->patternArray as $key => $val){
                if($this->checkEmptyPart($key, $val)){continue;};
                if($this->checkSeparatorPart($key, $val)){continue;}
                if($this->checkDayPartForNumericMonth($key, $val)){continue;};
                if($this->checkMonthPartForNumericMonth($key, $val)){continue;};
                if($this->checkYearPartForNumericMonth($key, $val)){continue;};
            }
        }
    }
    
    public function handleNoSeparatorDates(){
        $pat = str_split($this->primaryDateString);
        $day = ""; $month = ""; $year = "";
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
        $this->buildFormat($day, $month, $year);
    }
    
    public function buildFormat($day, $month, $year){
        if($this->checkString($day)){
            if(strlen($day) == 2){
                $this->updateFormat('d');
            }else{
                $this->updateFormat('j');
            }
        }
        
        if($this->checkString($month)){
            $this->checkTextualMonthPart(2, $month);
        }
        
        if($this->checkString($year)){
            if(strlen($year) == 4){
                $this->updateFormat('Y');
            }else{
                $this->updateFormat('y');
            }
        }
        
    }
    
    public function checkEmptyPart($key, $val){
        if(empty($val)){
            $this->formatArray['format'] .= "";
            return true;
        }
        return false;
    }
    //need to work on that later
    public function checkDayPartForTextualMonth($key, $val){
        $daymatch = array();
        if(preg_match($this->regnumberday, $val, $daymatch) && !empty($trimmedDay = (int)trim($daymatch[0])) && $trimmedDay > 0  && $trimmedDay < 32 && strlen($val) <= 2 && !empty($this->patternArray[5]) && $key <= 3){
            if(!$this->checkCharacterInformat('d') && !$this->checkCharacterInformat('j')){
                if(strlen($val) == 2){
                    $this->updateFormat("d");
                }else{
                    $this->updateFormat("j");
                }
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function checkDayPartForNumericMonth($key, $val){
        $daymatch = array();
        if(preg_match($this->regnumberday, $val, $daymatch) && !empty($trimmedDay = (int)trim($daymatch[0])) && $trimmedDay > 0  && $trimmedDay < 32 && strlen($val) <= 2 && !empty($this->patternArray[5]) && $key <= 2){
            if(!$this->checkCharacterInformat('d') && !$this->checkCharacterInformat('j') && !$this->checkCharacterInformat('M') && !$this->checkCharacterInformat('m')){
                if(strlen($val) == 2){
                    $this->updateFormat("d");
                }else{
                    $this->updateFormat("j");
                }
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function checkMonthPartForNumericMonth($key, $val){
        $monthmatch = array();
        if(preg_match($this->regnumbermonth, $val, $monthmatch) && !empty($trimmedMonth = (int)trim($monthmatch[0])) && $trimmedMonth > 0  && $trimmedMonth < 13 && strlen($val) <= 2){
            if(!$this->checkCharacterInformat('d') && !$this->checkCharacterInformat('j') && !$this->checkCharacterInformat('M') && !$this->checkCharacterInformat('m')){
                if(strlen($val) == 2){
                    $this->updateFormat("M");
                }else{
                    $this->updateFormat("m");
                }
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function checkYearPartForNumericMonth($key, $val){
        $yearmatch = array();
        if(preg_match($this->regnumberyear, $val, $yearmatch) && !empty(trim($yearmatch[0])) && strlen($val) >= 2 && strlen($val) <= 4 && $key >= 3 ){
            if(strlen($val) == 4){
                $this->updateFormat("Y");
            }else{
                $this->updateFormat("y");
            }
            return true;
        }
        return false;
    }
    
    
    public function checkTextualMonthPart($key, $val){
        $monthmatch = array();
        if(preg_match($this->regalltextualmonth, $val, $monthmatch)){
            if($this->checkArray($monthmatch)){
                $trimmedmonth = (string)trim($monthmatch[0]);
                if(!empty($trimmedmonth) && strlen($trimmedmonth) > 0){
                    if($this->checkCapitalFullMonthPart($trimmedmonth, $this->monthFullCapReg)){  return true; } 
                    if($this->checkWordCapitalFullMonthPart($trimmedmonth, $this->monthFullWCapReg)) {return true; } 
                    if($this->checkLowerFullMonthPart($trimmedmonth, $this->monthFullLowReg)) {return true; } 
                    if($this->checkCapitalShortMonthPart($trimmedmonth, $this->monthShortCapReg)) {return true; } 
                    if($this->checkWordCapitalShortMonthPart($trimmedmonth, $this->monthShortWcapReg)){return true; }
                    if($this->checkLowerShortMonthPart($trimmedmonth, $this->monthShortLowReg)) {return true; } 
                }
            }
        }
    }
    
    public function checkSeparatorPart($key, $val){
        if($this->checkPatternForSeparator($val, $this->regsep)){
            $this->updateFormat($val);
            return true;
        }
        return false;
    }
    
    public function checkYearPartForTextualMonth($key, $val){
        //$this->dump($val);
        if($this->checkPatternMatchingResult($val, $this->regnumberyear) && strlen($val) >= 2 && strlen($val) <= 4 && strlen($val) != 3 && $key >= 3 ){
            if(strlen($val) == 4){
                $this->updateFormat("Y");
            }else{
                $this->updateFormat("y");
            }
            return true;
        }
        return false;
    }
    
    
    
    public function checkCapitalFullMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('F', true, 'uppercase');
            return true;
        }
        return false;
    }
    
    public function checkWordCapitalFullMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('F', true, 'worduppercase');
            return true;
        }
        return false;
    }
    
    public function checkLowerFullMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('F', true, 'lowercase');
            return true;
        }
        return false;
    }

    public function checkCapitalShortMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('M', true, 'uppercase');
            return true;
        }
        return false;
    }

    public function checkWordCapitalShortMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('M', true, 'worduppercase');
            return true;
        }
        return false;
    }
    
    public function checkLowerShortMonthPart($trimmedmonth, $pattern){
        if($this->checkPatternMatchingResult($trimmedmonth, $pattern)){
            $this->updateFormat('M', true, 'lowercase');
            return true;
        }
        return false;
    }
    
    
    
    //HELPERS
    public function checkCharacterInformat($char){
        if($this->checkString($char) && strpos($this->formatArray['format'], $char)){
            return true;
        }
        return false;
    }
    
    public function updateFormat($format, $isMonth = false, $caseDirection = ""){
        if($isMonth){
            $this->formatArray['format'] .= $format;
            $this->formatArray['caseDirectionBool'] = 1;
            $this->formatArray['caseDirection'] = $caseDirection;
        }else{
            $this->formatArray['format'] .= $format;
        }
    }
    
    public function checkPatternMatchingResult($subject, $pattern){
        $patternMatching = array();
        if(preg_match($pattern, $subject, $patternMatching) && isset($patternMatching[0]) && !empty($trimmePatternMatching = (string)trim($patternMatching[0])) && strlen($trimmePatternMatching) > 0){
            return true;
        }
        return false;
    }
    
    public function checkPatternForSeparator($subject, $pattern){
        $patternMatching = array();
        $data = preg_match($pattern, $subject, $patternMatching);
        //$this->dump([$patternMatching, $pattern]);
        if(preg_match($pattern, $subject, $patternMatching) &&  !empty($trimmePatternMatching = $patternMatching[0]) && strlen($trimmePatternMatching) > 0){
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


