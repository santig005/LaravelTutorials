<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public static $products = [
        ["id"=>"1", "name"=>"TV", "description"=>"Best TV", "price"=>500],
        ["id"=>"2", "name"=>"iPhone", "description"=>"Best iPhone", "price"=>1000],
        ["id"=>"3", "name"=>"Chromecast", "description"=>"Best Chromecast", "price"=>50],
        ["id"=>"4", "name"=>"Glasses", "description"=>"Best Glasses", "price"=>20],
    ];

    public function index(): View
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] =  "List of products";
        $viewData["products"] = ProductController::$products;
        return view('product.index')->with("viewData", $viewData);
    }

    public function show(string $id) : View | RedirectResponse
    {   
        if ($id<0 || $id >count(ProductController::$products)) {
            return redirect()->route('home.index');
        }

        $viewData = [];
        $product = ProductController::$products[$id-1];
        $viewData["title"] = $product["name"]." - Online Store";
        $viewData["subtitle"] =  $product["name"]." - Product information";
        $viewData["product"] = $product;
        return view('product.show')->with("viewData", $viewData);
    }

    public function create(): View
    {
        $viewData = []; //to be sent to the view
        $viewData["title"] = "Create product";

        return view('product.create')->with("viewData",$viewData);
    }

    public function save(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required|numeric|min:0.01"
        ]);
        //dd($request->all());
        //here will be the code to call the model and save it to the database
        return redirect()->route('product.success');
    }

    public function success(): View
    {
        $viewData = [];
        $viewData["title"] = "Product created";

        return view('product.success')->with("viewData", $viewData);
    }

}
