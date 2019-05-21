<?php

namespace App\Http\Controllers\API;

use App\Models\CalendarEvent;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\Product;
use DateInterval;
use DatePeriod;
use DateTime;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $data = CalendarEvent::query()->public()->get();
        return mainResponse(true, 'api.ok', $data, []);
    }

    public function calenderEvent($date)
    {
        $date= convertAr2En($date);
        $data['business'] = CalendarEvent::query()->whereHas('expo')->public()->where('type',2)
        ->where('start_date', '<=',$date)->where('end_date', '>=',$date)->get();
        $data['expo'] = CalendarEvent::query()->public()->whereHas('expo')->where('type',1)
            ->where('start_date', '<=',$date)->where('end_date', '>=',$date)->get();
        return mainResponse(true, 'api.ok', $data, []);
    }
    public function eventDaysAndroid(Request $request)
    {
        
        /////////////////////////////////
      /*  $begin = new DateTime( '2019-04-01' );
$end = new DateTime( '2019-04-31' );
$end = $end->modify( '+1 day' ); 

$interval = new DateInterval('P1D');
$daterange = new DatePeriod($begin, $interval ,$end);

foreach($daterange as $date){
    echo $date->format("Y-m-d") . "<br>";
}
return "cccccc";*/
//////////////////////////////
        
        $date= convertAr2En($request->date);
         
        $splitDate = explode("-",$date);
         
         $mnth = ((int)$splitDate[1] < 10) ? "0".(int)$splitDate[1] : $splitDate[1];
         $date = $splitDate[0].'-'.$mnth;
         
        $events = CalendarEvent::query()->whereHas('expo')->public()->whereBetween('start_date', [$date.'-01', $date.'-31'])->
            orWhereBetween('end_date',[$date.'-01',$date.'-31'])->get();
        $arr = [];
        $interval = new DateInterval('P1D');
        foreach ($events as $event){
            
            $start = new DateTime($event->start_date);
            $end  = new DateTime($event->end_date);
            $end = $end->modify('+1 day'); 
           
            $daterange = new DatePeriod($start, $interval ,  $end);
            foreach($daterange as $date1){
                if ($date1->format("Y-m") == $date){
                    $arr[] = $date1->format("Y-m-d");
                }
            }

        }
        sort($arr);
        $arr = array_unique($arr);
        return mainResponse(true, 'api.ok', array_values($arr), []);
    }
    
    public function eventDaysIOS(Request $request)
    {
        $date= convertAr2En($request->date);
        
        $splitDate = explode("-",$date);
         
         $mnth = ((int)$splitDate[1] < 10) ? "0".(int)$splitDate[1] : $splitDate[1];
         $date = $splitDate[0].'-'.$mnth;
                 

        $events = CalendarEvent::query()->whereHas('expo')->public()
        ->whereBetween('start_date', [$date.'-01', $date.'-31'])->
            orWhereBetween('end_date',[$date.'-01',$date.'-31'])->get();
         
        $arr = [];
        $interval = new DateInterval('P1D');
        foreach ($events as $event){
            $start = new DateTime($event->start_date);
            $start = $start->modify('-1 day');
            $end  = new DateTime($event->end_date);
           // $end = $end->modify('+1 day'); 
            $daterange = new DatePeriod($start, $interval ,  $end);
            foreach($daterange as $date1){
                if ($date1->format("Y-m") == $date){
                    $arr[] = $date1->format("Y-m-d");
                }
            }

        }
        sort($arr);
        $arr = array_unique($arr);
        return mainResponse(true, 'api.ok', array_values($arr), []);
    }

}
