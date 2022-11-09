<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* include */
use App\Models\Category;

class CategoryController extends Controller
{
    /* -- Add categories -------------------------------------------------------------- */
    public function addCategories(Request $request)
    {
        //validation - fields all required
        $request->validate([
            'name' => 'required|max:64|min:3|regex:/^[\pL\s\-]+$/u',
        ]);

        return Category::create($request->all());
    }
    /* ------------------------------------------------------------------------------- */


    /* -- Get categories and sorth them ASC-------------------------------------------------------- */
    public function getCategories()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        if ($categories != null) {
            // Get category name
            foreach ($categories as $category_object) {
                $category = Category::find($category_object->id);
                $category_object->category_name_id = $category->name;
            }
            return $categories;
        } else {
            return response()->json([
                'Categories table is empty!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */


    /* -- get category by id ----------------------------------------------------------- */
    public function categoriesById($id)
    {
        //read out specific category
        $categories = Category::find($id);
        //validayion
        if ($categories != null) {

            return $categories;
        } else {
            return response()->json([
                'Category not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* -- delete category ------------------------------------------------------------ */
    public function deleteCategories($id)
    {
        //delete entry
        $categories = Category::find($id);
        //validation messeges
        if ($categories != null) {
            $categories->delete();
            return response()->json([
                'Category deleted!'
            ]);
        } else {
            return response()->json([
                'Category not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Update category-------------------------------------------------------------- */
    public function updateCategories(Request $request, $id)
    {
        //validation for update, response feedback if you fail to enter correct data
        $request->validate([
            'name' => 'required|max:64|min:3|regex:/^[\pL\s\-]+$/u',
        ]);

        //update categories post
        $categories = Category::find($id);
        //validation messeges
        if ($categories != null) {
            $categories->update($request->all());
            return $categories;
        } else {
            return response()->json([
                'Category not found!'
            ], 404);
        }
    }

    /* ------------------------------------------------------------------------------- */
}
