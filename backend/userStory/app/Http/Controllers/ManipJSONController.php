<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ManipJSONController extends Controller
{
    protected $nameFileJsonOne;
    protected $nameFileJsonTwo;
    protected $contentFileJsonOne;
    protected $contentFileJsonTwo;

    protected $workshopDetail;

    function __construct()
    {
        # inisiasi nama file
        $this->nameFileJsonOne = 'public/manipjson/json1.json';
        $this->nameFileJsonTwo = 'public/manipjson/json2.json';

        $this->storeWorkshopDetail();
    }

    function readFile()
    {
        $this->contentFileJsonOne = json_decode(Storage::disk('local')->get($this->nameFileJsonOne));
        $this->contentFileJsonTwo = json_decode(Storage::disk('local')->get($this->nameFileJsonTwo));
        
        return true;
    }

    function storeWorkshopDetail()
    {
        $readFile = $this->readFile();
        $workshopResult = [];
        foreach($this->contentFileJsonTwo->data as $workshop){
            $workshopCode = $workshop->code;
            $workshopResult[$workshopCode] = $workshop;
        }

        $this->workshopDetail = $workshopResult;

        return true;
    }

    function getWorkshopDetail($code)
    {

        return $this->workshopDetail[$code] ?? null;
    }

    function sortBookingResult($bookingResult)
    {
        usort($bookingResult, function($a, $b) {
            return $a['ahass_distance'] > $b['ahass_distance'];
        });

        return $bookingResult;
    }

    public function manip()
    {
        $bookingResult = [];
        foreach($this->contentFileJsonOne->data as $booking){
            $getWorkshopDetail = $this->getWorkshopDetail($booking->booking->workshop->code);
            $bookingResult[] = [
                'name' => $booking->name,
                'email' => $booking->email,
                'booking_number' => $booking->booking->booking_number,
                'book_date' => $booking->booking->book_date,
                'ahass_code' => $getWorkshopDetail->code ?? "",
                'ahass_name' => $getWorkshopDetail->name ?? "",
                'ahass_address' => $getWorkshopDetail->address ?? "",
                'ahass_contact' => $getWorkshopDetail->phone_number ?? "",
                'ahass_distance' => $getWorkshopDetail->distance ?? 0,
                'motorcycle_ut_code' => $booking->booking->motorcycle->ut_code
            ];
        }

        $bookingSortResult = $this->sortBookingResult($bookingResult);

        return response()->json($bookingSortResult, 200, ['Content-Type' => 'application/json']);
    }
}
