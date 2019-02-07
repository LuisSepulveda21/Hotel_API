<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Hotel;
use App\Keysapi;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $hotels = Hotel::all();
        return $hotels; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $name = $request->name;
        $address = $request->address;
        $type= $request->type;
        $size = $request->size;
        $phone = $request->phone;
        $fax = $request->fax;
        $email = $request->email;
        $website = $request->website;
        $state = $request->state;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $rooms = $request->rooms;


        $key = $request->key;

        $result = Keysapi::where('key',$key)->get()->count();

        if ($result=='0') {
           $flag = False;
        }else{
            $flag= True;
        }


        if ($flag) {

         DB::table('hotels')->insert(
            ['HOTEL NAME' => $name, 
            'ADDRESS' => $address,
            'TYPE' => $type,
            'SIZE' => $size,
            'PHONE' => $phone,
            'FAX' => $fax,
            'EMAIL ID' => $email,
            'WEBSITE' => $website,
            'STATE' => $state,
            'LATITUDE' => $latitude,
            'LONGITUDE' => $longitude,
            'Rooms' => $rooms]
        );

          return response()->json([
            'message'=>'Hotel successfully inserted'
        ]);

   }else{

  return response()->json([
            'message'=>'Invalid Key'
        ]);

    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function find(Request $request)
    {
        if($request->has('range') && $request->has('latitude') && $request->has('longitude')){
            $reg = Hotel::all();
            $founds = array();
            $i = 0;
            $earth_radius = 6371;
            foreach ($reg as $row) {
                $latitude1 = $request->latitude;
                $latitude2 = $row->Latitude;
                $longitude1 = $request->longitude;
                $longitude2 = $row->Longitude;
          
                $dLat = deg2rad($latitude2 - $latitude1);
                $dLon = deg2rad($longitude2 - $longitude1);
                $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
                $c = 2 * asin(sqrt($a));
                $d = $earth_radius * $c;
                
                if ($request->range >= $d) {
                    $founds[$i] = $row;
                    $i = $i+1;
                }
            }
            return json_encode($founds);
        }
    
        $query = "SELECT * FROM `hotels` WHERE ";
        $i = 0;
        $array =  array();
        if ($request->has('name')){
            $array[$i]='`HOTEL NAME`='."'".$request->name."'";
            $i=$i+1;
        }
        if($request->has('state')){
            $array[$i]='`STATE`='."'".$request->state."'";
            $i=$i+1;
        }
        if($request->has('type')){
            $array[$i]='`TYPE`='."'".$request->type."'";
            $i=$i+1;
        }
        if($request->has('size')) {
            $array[$i]='`Size`='."'".$request->size."'";
            $i=$i+1;
        }
        $query = $query.$array[0];
        for ($j=1; $j<$i; $j++) { 
            $query = $query.' AND '.$array[$j];
        }
        return DB::select($query);
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        
        $type= $request->type;
        $size = $request->size;
        $phone = $request->phone;
        $email = $request->email;
        $website = $request->website;


        $key = $request->key;

        $result = Keysapi::where('key',$key)->get()->count();

        if ($result=='0') {
           $flag = False;
        }else{
            $flag= True;
        }


        if ($flag) {

            //find by id
            $hotel = Hotel::find($id);

            //all parameters expected

        if ($type==null || $size == null || $phone == null ||
           $website == null || $email == null) {
           return response()->json([
            'message'=>'All parameters expected'
        ]);
        }else{
            //only the following columns are updatable
                  DB::table('hotels')->where('ID',$id)->update(array(
                                 'TYPE'=>$type,
                                 'SIZE'=>$size,
                                 'PHONE'=>$phone,
                                 'WEBSITE'=>$website,
                                 'EMAIL ID'=>$email,
                             ));

          return response()->json([
            'message'=>'Successfully updated'
        ]);

        }
           

   }else{

  return response()->json([
            'message'=>'Invalid Key'
        ]);

   }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $key = $request->key;

        $result = Keysapi::where('key',$key)->get()->count();

        if ($result=='0') {
           $flag = False;
        }else{
            $flag= True;
        }

        if ($flag) {

            //find by id
             $hotel = DB::table('hotels')->where('ID', $id)->first();

            if ($hotel==null) {
                return response()->json([
             'message'=>'Hotel not found'
             ]);
            }
            else{
             DB::table('hotels')->delete($id);

             return response()->json([
            'message'=>'Hotel successfully deleted'
           ]);
            }

        }else{

        return response()->json([
            'message'=>'Invalid Key'
        ]);

        }


    }

}
