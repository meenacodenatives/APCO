<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class LibraryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewdateFormat($colName,$format)
    {
        $formattedDate=date('M d, Y', strtotime($colName));
        return $formattedDate;
    }

}