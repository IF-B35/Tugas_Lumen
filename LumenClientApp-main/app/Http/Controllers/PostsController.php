<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;

class PostsController extends Controller
{
    public function getRequestJson(Request $request)
    {
        $url = 'http://localhost:8000/public/posts';
        $header = ['Accept: application/json'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        // echo"<pre>";print_r($response);die();
        return view('posts/getRequestJson', ['results' => $response]);
    }

    public function getRequestXml(Request $request)
    {
        $url = 'http://localhost:8000/public/posts';
        $headers = ['Accept: application/xml'];
        // Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);
        
    

        // parse xml response from request to be php object
        $parseXml = new SimpleXMLElement($result);

        $response = [];

        // restructure response
        foreach($parseXml->children() as $item) {
            array_push($response, array(
                'id' => $item->id,
                'user_id' => $item->user_id,
                'title' => $item->title,
                'content' => $item->content,
                'status' => $item->status,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ));
        }

        // echo"<pre>";print_r($response);die();

        return view('posts/getRequestXml', ['results' => $response]);
    }


    public function postRequestJson(Request $request)
    {
        $url='http://localhost:8000/public/posts';
        $headers = ['Accept: application/json','Content-Type: application/json'];
        $data = [
                "user_id" => "1",
                "title" => "Post Title",
                "content" => "Post Content",
                "status" => "1",
            
        ];


        $dataJSON = json_encode($data);

        // initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // set url
        curl_setopt($ch, CURLOPT_URL,$url);
        // set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // set posst data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON);
        // execute
        $result = curl_exec($ch);
        // closing
        curl_close($ch);

        // parse json response from request to be php object
        $response = json_decode($result, true);
    
        // echo"<pre>";print_r($response);die();
        // dd($response);
        // return response()->json($response, 200);
        return view('posts/postRequestJson', ['result' => $response]);
    }

    public function postRequestXml(Request $request)
    {
        $url='http://localhost:8000/public/posts';
        $headers = ['Accept: application/xml','Content-Type: application/xml'];
        $data = [
                "user_id" => "1",
                "title" => "Post Title",
                "content" => "Post Content",
                "status" => "draft",
        ];

        // initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // set url
        curl_setopt($ch, CURLOPT_URL,$url);
        // set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // set posst data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // execute
        $result = curl_exec($ch);
        // closing
        curl_close($ch);



        // parse xml response from request to be php object
        $parseXml = new \SimpleXMLElement($result);

        $response = [];

        // restructure response
        foreach($parseXml->children() as $item) {
            array_push($response, array(
                'id' => $item->id,
                'user_id' => $item->user_id,
                'title' => $item->title,
                'content' => $item->content,
                'status' => $item->status,
            ));
            
        }

        return view('posts/postRequestXml', ['results' => $response]);
    }

}