<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::paginate(5);

        return view('index')->with('products', $products);
    }
    function studentView(Request $request)
    {

        $edit_id = $request['editId'];

        $hidden_id = $request['hidden_id'];

        $delete_id = $request['deleteId'];


        if ($request['type'] == 'insert') {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;

            $uploadDirectory = 'uploads';

            $uploadPath = public_path($uploadDirectory);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }

            $request->file('image')->move($uploadPath, $imageName);
            $imagePath = $uploadDirectory . '/' . $imageName;

            $productmodel = new Product;
            if ($hidden_id) {
                $productmodel = Product::find($hidden_id);
            }
            $productmodel->name = $request->name;
            $productmodel->description = $request->description;
            $productmodel->image = $imageName;
            $productmodel->save();
            
            return response()->json(['res' => "data successfully inserted into db"]);
        } elseif ($request['type'] == 'edit') {

            $singleProductData1 = Product::select('*')->where('id', $edit_id)->get();

            $singleProductData = $singleProductData1[0];

            return response()->json(['singleProductData' => $singleProductData]);

        } elseif ($request['type'] == 'delete') {
            $user = Product::find($delete_id);
            $user->delete();

            return response()->json(['res' => "The Record $delete_id deleted successfully"]);
        }

    }

    function listing()
    {
        $perPage = 5;
        $productData = Product::paginate($perPage); 

        $tbody = "";

        
        foreach ($productData as $key => $value) {
            $tbody .= "<tr>";
            $tbody .= "<td>$value[id]</td>";
            $tbody .= "<td>$value[name]</td>";
            $tbody .= "<td>$value[description]</td>";
            $tbody .= '<td><img src="' . asset('uploads/' . $value['image']) . '" alt="Not Found!" style="max-height: 50px;"></td>';
            $tbody .= "<td><button id=" . $value['id'] . " class='btn btn-warning edit'>Edit</button> | <a id=" . $value['id'] . " class='btn btn-danger delete'>Delete</a>";
            $tbody .= "</tr>";
        }


        return response()->json(['tbody' => $tbody]);
        


    } 

}
