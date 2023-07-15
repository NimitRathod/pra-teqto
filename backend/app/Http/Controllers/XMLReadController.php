<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XMLReadController extends Controller
{
    //
    public function readXML(){
        $url="https://www.notgoingtouni.co.uk/sites/default/files/recruiter_job_import/qa_d2UteVl1UFVadFVSbmxoU1lhR3FoSjlaS2MxUQ.xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
        
        $data = curl_exec($ch); // execute curl request
        curl_close($ch);
        
        $xml = simplexml_load_string($data);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        // print_r($xml);
        // return $array;
        $collection = isset($array['job']) ? $array['job'] : [];
        // return $collection[0]['id'];
        // $collection = [];
        return view('viewXML',compact('collection'));
    }
}
