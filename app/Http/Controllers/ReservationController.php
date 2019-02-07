<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Hotel;
use App\Reservation;
class ReservationController extends Controller
{
     public function store(Request $request){	
    	$rooms = DB::select("SELECT SUM(`NroRooms`) as Rooms FROM `reservations` WHERE `Hotel_ID`= "."'".$request->HotelID."'"." AND ((`StartDate` BETWEEN "."'".$request->StartDate."'"." AND "."'".$request->EndDate."'".") OR (`EndDate` BETWEEN "."'".$request->StartDate."'"." AND "."'".$request->EndDate."'".") OR (`StartDate` < "."'".$request->StartDate."'"." AND `EndDate` > "."'".$request->EndDate."'".")) GROUP BY `Hotel_ID`");
    	
    	$total_rooms= DB::select("SELECT `Rooms`, `STATE`  FROM `hotels` WHERE `ID`= ".$request->HotelID." "); 
    	if ($rooms== NULL) {
    		if ($total_rooms[0]->Rooms-$request->NroRooms>=0) {
    			$reserva = Reservation::create([
    			'Hotel_ID' => $request['HotelID'],
    			'State' => $total_rooms[0]->STATE,
    			'User_ID' => $request['UserID'],
    			'StartDate' => $request['StartDate'],
    			'EndDate' => $request['EndDate'],
    			'NroRooms' => $request['NroRooms'],
    			]);
                $ret = "The reservation ID is ".$reserva->id;
    			return response()->json($ret, 201);
    		}else{
    			return "No se puede reservar";
    		}
    	}
    	if($total_rooms[0]->Rooms-($rooms[0]->Rooms+$request->NroRooms)>=0){
    		$reserva = Reservation::create([
    			'Hotel_ID' => $request['HotelID'],
    			'State' => $total_rooms[0]->STATE,
    			'User_ID' => $request['UserID'],
    			'StartDate' => $request['StartDate'],
    			'EndDate' => $request['EndDate'],
    			'NroRooms' => $request['NroRooms'],

    		]);
             $ret = "The reservation ID is ".$reserva->id;
    		return response()->json($ret, 201);
    	}else{
    		return "No se puede reservar";
    	}
    }
    

    public function check(Request $request){
     $query = DB::select("SELECT `hotels`.* 
          FROM `hotels` 
       LEFT JOIN (SELECT `reservations`.`Hotel_ID` , SUM(`NroRooms`) as Rooms
       FROM `reservations` 
       WHERE `reservations`.`State`= "."'".$request->State."'"." AND ((`StartDate` BETWEEN "."'".$request->StartDate."'"." AND "."'".$request->EndDate."'".") OR (`EndDate` BETWEEN "."'".$request->StartDate."'"." AND "."'".$request->EndDate."'".") OR (`StartDate` < "."'".$request->StartDate."'"." AND `EndDate` > "."'".$request->EndDate."'".")) GROUP BY `Hotel_ID`) Tabla ON Tabla.`Hotel_ID`= `hotels`.`ID` WHERE `hotels`.`STATE`= "."'".$request->State."'"." AND IF(Tabla.`Hotel_ID`= `hotels`.`ID`,IF(`hotels`.`Rooms`-Tabla.`Rooms`>0,TRUE,FALSE),TRUE)");
     return $query;
    }
}



