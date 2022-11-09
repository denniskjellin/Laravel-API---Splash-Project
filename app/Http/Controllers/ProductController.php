<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
/* include */
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Response;
/* use Symfony\Component\HttpFoundation\Response; */

class ProductController extends Controller
{
    /* --- Add product ----------------------------------------------------------------- */
    public function addproducts(Request $request)
    {
        /* ---------------Check if category ID exists----------------- */
        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 400);
        }

        /* ---------------Check if supplier ID exists----------------- */
        $supplier = Supplier::find($request->supplier_id);
        if (!$supplier) {
            return response()->json([
                'message' => 'Supplier not found'
            ], 400);
        }

        /* $product = new Product; */
        /* --------------- Validation of input fields ----------------- */
        $request->validate([

            'name' => 'required|max:64',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'info' => 'required|max:500'
        ]);

        $data = $request->all();        // Läs in anropet, så det går att modifiera innan lagring

        /* check if image has ben entered or not (img not required) */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $request->image->move(public_path('img/products'), $image_name);

            $data['image'] = $image_name;   // Lagra filnamnet i databasen
        }

        /*  return response($data, Response::HTTP_CREATED); */

        return Product::create($data);
    }

    /* ------------------------------------------------------------------------------- */

    /* --- Get all products and sort them ASC ------------------------------------------------------ */
    public function getProducts()
    {
        $products = Product::orderBy('name', 'ASC')->paginate(8); 

        if ($products != null) {

            foreach ($products as $product) {
                // Get category name
                $category = Category::find($product->category_id);
                $product->category_name = $category->name;

                // Get supplier name
                $supplier = Supplier::find($product->supplier_id);
                $product->supplier_name = $supplier->name;

                // Add URL to image
                $image = $product->image;
                if ($image) {
                    $product->image_url = url('/') . "/img/products/" . $image;
                }
            }
            
            return $products;
        } else {
            return response()->json([
                'Products table is empty!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* --- Show product by ID -------------------------------------------------------- */
    public function productsById($id)
    {
        //read out specific product
        $products = Product::find($id);
        //validayion
        if ($products != null) {
            return $products;
        } else {
            return response()->json([
                'Product not be found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* ----- Delete product by id ---------------------------------------------------- */
    public function deleteProducts($id)
    {
        //delete entry
        $products = Product::find($id);
        //validation messeges
        if ($products != null) {
            $products->delete();
            return response()->json([
                'Product deleted!'
            ]);
        } else {
            return response()->json([
                'Product not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* --- Update product by ID ------------------------------------------------------- */
    public function updateProducts(Request $request, $id)
    {
        //validation for update, response feedback if you fail to enter correct data
        $products = Product::find($id);
        if ($products != null) {
            $request->validate([

                'name' => '|max:64|required',
                'supplier_id' => 'required', 
                'category_id' => 'required', 
                'amount' => '|required|numeric',
                'price' => '|required|numeric',
                'info' => '|max:500'
            ]);

            $products->update($request->all());
            return $products;
        } else {
            return response()->json([
                'Product not found!'
            ], 404);
        }
    }

    /* --- Search product, that gives you products that matches letters you enter --------- */
    public function searchProduct($response)
    {
        /* sql syntax for getting data from db thats has % match of the searchword */
        $response = Product::where('name', 'like', '%' . $response . '%')->get();

        if ($response != null) {
            // Get category name
            foreach ($response as $product) {
                $category = Category::find($product->category_id);
                $product->category_name = $category->name;
             // Get supplier name
             
                $supplier = Supplier::find($product->supplier_id);
                $product->supplier_name = $supplier->name;
            

             // Add URL to image
             $image = $product->image;
             if ($image) {
                 $product->image_url = url('/') . "/img/products/" . $image;
             }
            }
            return $response;
        } else {
            return response()->json([
                'Products table is empty!'
            ], 404);
        }
    }

    /* ------------------------------------------------------------------------------- */
}
