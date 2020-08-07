<?php

namespace App\Http\Controllers;

use App\Models\SearchRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MapController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sendData)
    {



        // Frontum gtnuma nshvac taracqner@
        $data = explode('&', $sendData);


        $center_lat = substr($data[1], 4);
        $center_lng = substr($data[2], 4);
        $radius = substr($data[3], 7);

        $result = SearchRestaurant::findLocation($center_lat, $center_lng, $radius);


        $dom = new \DOMDocument();
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        foreach ($result as $item) {
            $node = $dom->createElement("marker");

            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $item->id);
            $newnode->setAttribute("name", $item->name);
            $newnode->setAttribute("address", $item->address);
            $newnode->setAttribute("lat", $item->lat);
            $newnode->setAttribute("lng", $item->lng);
            $newnode->setAttribute("distance", $item->distance);
        }

        echo $dom->saveXML();



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
