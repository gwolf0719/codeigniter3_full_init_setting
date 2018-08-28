<?php
class Date
{
    /**
     * 範圍日期篩選週
     */
    function date_filter_week($start,$end,$frequency){
        $res = array();
        foreach($this->range_date($start,$end) as $value){
            $w = date("w",strtotime($value));
            if(in_array($w,$frequency)){
                $res[] = $value;
            }
        }
        return $res;
    }
    /**
     * 取得範圍日期
     */
    function range_date($start,$end){
        $date = $start;
        $date = new DateTime($start);
        $date = $date->format('Y-m-d');
        do{
            $res[] =  $date;
            $date = new DateTime($date);
            $date->modify('+1 day');
            $date = $date->format('Y-m-d');
        }while($date <= $end);
        return $res;
    }
    /**
     * 取得範圍日期數量
     */
    function range_date_count($start,$end){
        return count($this->range_date($start,$end));
    }
    /**
     * 日期推移 支援往前往後
     * date 起算日
     * num 推移數量，往前可輸入負值
     */
    function date_push($date,$num){
        $date = new DateTime($date);
        $date->modify('+'.$num.' day');
        $date = $date->format('Y-m-d');
        return $date;
    }
}
