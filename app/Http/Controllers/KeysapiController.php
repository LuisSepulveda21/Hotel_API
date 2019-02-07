<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keysapi;
use App\Http\Controllers\Controller;


class KeysapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ContactName = $request->contact;
        $Company = $request->company;
        $Email = $request->email;
        $ApiKey = bin2hex(openssl_random_pseudo_bytes(30));

        KeysApi::create([
            'contact'=>$ContactName,
            'company'=> $Company,
            'email'=>$Email,
            'key'=>$ApiKey
        ]);
        return response()->json([
            'message'=>'Insert successfuly',
            'Key' => $ApiKey
        ]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
