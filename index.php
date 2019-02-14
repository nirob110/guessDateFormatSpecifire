<?php 

$content = array(
    "January 02 2019",
    "01/02/2019",
    "06 JANUARY, 2019",
    "03.aug, 2019",
 "3.12.2018",   
 '30 may, 1990',   
 '1 may, 1776',
 '1 may, 1776',
 '5 june 1776',
 '5 june 1776',
 '06 august 2027',
 '06 august 2027',
 '06 august 2028',
 '06 august 2028',
 '02/03/2014',
 '02/03/2014',
 '01/02/2012',
 '01/02/2012',
 '03/08/2006',
 '03/08/2006',
 '3/8/06',
 '3/8/06',
 '3/8/2006',
 '3/8/2006',
 '03Aug2006',
 '03Aug2006',
 'Aug-06',
 'Aug-06',
 'Aug-2006',
 'Aug-2006',
 '3Aug06',
 '3Aug06',
 '3Aug2006',
 '3Aug2006',
 '3-Aug-06',
 '3-Aug-06',
 '3-Aug-2006',
 '3-Aug-2006',
 '3-August-06',
 '3-August-06',
 '3-August-2006',
 '3-August-2006',
 '08/03/2006',
 '08/03/2006',
 'Aug-03-06',
 'Aug-03-06',
 'Aug-03-2006',
 'Aug-03-2006',
 '01 july 1949',
 '01 july 1949',
 '02 July 2017',
 '02 July 2017',
 '1 may, 1776',
 '1 may, 1776',
 '5 june 1776',
 '5 june 1776',
 '06 august 2027',
 '06 august 2027',
 '06 august 2028',
 '06 august 2028',
 '02/03/2014',
 '02/03/2014    ',
 '01/02/2012',
 '01/02/2012',
 '03/08/2006',
 'July, 2018',
 'January, 1898',
 'january 2018',
 'February 2018',
 'february 203855454',
 'March,2018',
 'April-2018',
 'JANUARY 2018',
 'January-2018',
 'january 2018',
 'JAN, 2018',
 'Jan 2019',
 'jan-5022',
 'FEBRUARY-2018',
 'February-2018',
 'february-2019',
 'FEB-2019',
 'Feb-2019',
 'feb-2019',
 'MARCH 2019',
 'March-2019',
 'march, 2019',
 'MAR, 2019',
 'Mar, 2019',
 'mar, 2019',
 '10 12 2019',
 '10-12-2018',
 '01 January, 2018',
 '01 Jan, 2018',
 '12,12,2018',
 '02/03/2014',
 '3-Aug-2006',
    '3-Aug-2006',
);





$regexp = '/\b/m';
$regsep = '/[\.|,|\s|\-|\/]{0,2}/m';
$regnumberday = '/^[\d]{1,2}/m';
$regnumbermonth = '/^[\d]{1,2}/m';
$regnumberyear = '/^(\d{2}|\d{4})$/m';
$regallmonth = '/JANUARY|January|january|JAN|Jan|jan|FEBRUARY|February|february|FEB|Feb|feb|MARCH|March|march|MAR|Mar|mar|APRIL|April|april|APR|Apr|apr|MAY|May|may|JUNE|June|june|JUN|Jun|jun|JULY|July|july|JUL|Jul|jul|AUGUST|August|august|AUG|Aug|aug|SEPTEMBER|September|september|SEP|Sep|sep|OCTOBER|October|october|OCT|Oct|oct|NOVEMBER|November|november|NOV|Nov|nov|DECEMBER|December|december|DEC|Dec/m';
$monthFullCapReg = '/JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER/m';
$monthFullWCapReg = '/January|February|March|April|May|June|July|August|September|October|November|December/m';
$monthFullLowReg = '/january|february|march|april|may|june|july|august|september|october|november|december/m';
$monthShortCapReg = '/JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC/m';
$monthShortWcapReg = '/Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec/m';
$monthShortLowReg = '/jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec/m';


function dump($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function checkArray($array){
    if(is_array($array) && count($array)> 0){
        return true;
    }
    return false;
}

function checkString($str){
    if(isset($str) && !empty($str)){
        return true;
    }
    return false;
}

// day functions
function getDayFormat($val){
    if(strlen($val) == 2){
        return 'd';
    }else {
        return 'j';
    }
}



foreach($content as $date){
    $pattAr = preg_split($regexp, $date);
    if(checkArray($pattAr)){
        $format = "";
        foreach($pattAr as $key => $val){
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
            //dump($key);
           // dump($val);
            try{
                //day part
                if(preg_match($regnumberday, $val, $daymatch) && !empty($trimmedDay = (int)trim($daymatch[0])) && $trimmedDay > 0  && $trimmedDay < 32 && strlen($val) <= 2 && $key < 2){
                    $currentFormat = strlen($val) == 2 ? 'd' : 'j';
                    $format .= strlen($val) == 2 ? 'd' : 'j';
                    dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $daymatch, 'daypart']);
                    continue;
                }
                // still I got to handle format like January 02 2018 and so on.
                //textual month part
                if(preg_match($regallmonth, $val, $monthmatch) && !empty($trimmedmonth = (string)trim($monthmatch[0])) && strlen($trimmedmonth) > 0){
                    if(preg_match($monthFullCapReg, $trimmedmonth, $monthFullCapRegMatching) && !empty($trimmedmonthFullCapReg = (string)trim($monthFullCapRegMatching[0])) && strlen($trimmedmonthFullCapReg) > 0){
                        //need to store information that the month name should be capitalized
                        $currentFormat = "F";
                        $format .= "F";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthFullCapReg, 'textualmonthpart fullcapitalized']);
                        continue;
                    }
                    
                    if(preg_match($monthFullWCapReg, $trimmedmonth, $monthFullWCapRegMatching) && !empty($trimmedmonthFullWCapReg = (string)trim($monthFullWCapRegMatching[0])) && strlen($trimmedmonthFullWCapReg) > 0){
                        //need to store information that the month name should be first letter capitalized
                        $currentFormat = "F";
                        $format .= "F";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthFullWCapReg, 'textualmonthpart fullwcapitalized']);
                        continue;
                    }
                    
                    if(preg_match($monthFullLowReg, $trimmedmonth, $monthFullLowRegMatching) && !empty($trimmedmonthFullLowReg = (string)trim($monthFullLowRegMatching[0])) && strlen($trimmedmonthFullLowReg) > 0){
                        //need to store information that the month name should be lower cased
                        $currentFormat = "F";
                        $format .= "F";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthFullLowReg, 'textualmonthpart fulllower']);
                        continue;
                    }
                    
                    if(preg_match($monthShortCapReg, $trimmedmonth, $monthShortCapRegMatching) && !empty($trimmedmonthShortCapReg = (string)trim($monthShortCapRegMatching[0])) && strlen($trimmedmonthShortCapReg) > 0){
                        //need to store information that the month name should be upper cased
                        $currentFormat = "M";
                        $format .= "M";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthShortCapReg, 'textualmonthpart short cap ']);
                        continue;
                    }

                    if(preg_match($monthShortWcapReg, $trimmedmonth, $monthShortWcapRegMatching) && !empty($trimmedmonthShortWcapReg = (string)trim($monthShortWcapRegMatching[0])) && strlen($trimmedmonthShortWcapReg) > 0){
                        //need to store information that the month name should be w upper cased
                        $currentFormat = "M";
                        $format .= "M";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthShortWcapReg, 'textualmonthpart short W cap ']);
                        continue;
                    }
                    
                    if(preg_match($monthShortLowReg, $trimmedmonth, $monthShortLowRegMatching) && !empty($trimmedmonthShortLowReg = (string)trim($monthShortLowRegMatching[0])) && strlen($trimmedmonthShortLowReg) > 0){
                        //need to store information that the month name should be lower cased
                        $currentFormat = "M";
                        $format .= "M";
                        dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmedmonthShortLowReg, 'textualmonthpart short cap ']);
                        continue;
                    }
                    
                    //if month name contais other numeric characters
                    if(preg_match('/\d/m', $trimmedmonth)){
                        
                    }
                }
                //numeric month part
                if(preg_match($regnumbermonth, $val, $regnumbermonthmatch) && !empty($trimmednubermonth = (int)trim($regnumbermonthmatch[0])) && $trimmednubermonth > 0  && $trimmednubermonth < 13 && strlen($val) > 0 && $key >= 2 && $key <= 3){
                    if(preg_match('/d|j/m', $format)){
                        $currentFormat = strlen($val) == 2 ? 'm' : 'n';
                        $format .= strlen($val) == 2 ? 'm' : 'n';
                    }else{
                        $currentFormat = strlen($val) == 2 ? 'd' : 'j';
                        $format .= strlen($val) == 2 ? 'd' : 'j';
                    }
                    dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $trimmednubermonth, 'numeric month part']);
                    continue;
                }
                
        
                
                //yearpart
                if(preg_match($regnumberyear, $val, $yearmatch) && !empty($trimmedyear = (int)trim($yearmatch[0])) && $trimmedyear > 0  && strlen($val) >= 2 && $key > 3){
                    $currentFormat = strlen($val) == 4 ? 'Y' : 'y';
                    $format .= strlen($val) == 4 ? 'Y' : 'y';
                    dump(['currentFormat' => $currentFormat,'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $val, 'year part']);
                    continue;
                }
                
                
                //var_dump(preg_match($regsep, $val, $sepMatch));
                if(preg_match($regsep, $val, $sepMatch) && !empty($sep = $sepMatch[0]) && strlen($sep)){
                    $currentFormat = $sep;
                    $format .= $sep;
                    dump(['currentFormat' => $currentFormat, 'format' => $format,'pattern' => $pattAr, 'date' => $date , 'key' => $key, 'val' => $val, 'match'=> $sep, 'separatorpart']);
                    continue;
                }
            }catch (Exception $e){
                    //dump($e->getMessage());
            }
            echo $format;
        }
        
    }
  
}
?>

