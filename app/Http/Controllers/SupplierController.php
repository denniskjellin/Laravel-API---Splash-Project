<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* include */
use App\Models\Supplier;

class SupplierController extends Controller
{
    /* ---- Add supplier -------------------------------------------------------------- */
    public function addSuppliers(Request $request)
    {
        //validation - fields all required
        $request->validate([
            'name' => 'required|max:64|min:2',
            'email' => 'required|max:256',
            'phone' => 'required|min:6|numeric|'
        ]);

        return Supplier::create($request->all());
    }
    /* ------------------------------------------------------------------------------- */

    /* ---- Get all suppliers -------------------------------------------------------- */
    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        if ($suppliers != null) {
             // Get suppliers name from id
             foreach ($suppliers as $suppliers_object) {
                $supplier = Supplier::find($suppliers_object->id);
                $suppliers_object->supplier_name_id = $supplier->name;
            }
            return $suppliers;
        } else {
            return response()->json([
                'Suppliers table is empty!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* ----- Show supplier by ID ----------------------------------------------------- */
    public function suppliersById($id)
    {
        //read out specific suppliers
        $suppliers = Supplier::find($id);
        //validayion
        if ($suppliers != null) {
            return $suppliers;
        } else {
            return response()->json([
                'Supplier not be found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* --- Delete supplier ----------------------------------------------------------- */
    public function deleteSuppliers($id)
    {
        //delete entry
        $suppliers = Supplier::find($id);
        //validation messeges
        if ($suppliers != null) {
            $suppliers->delete();
            return response()->json([
                'Supplier deleted!'
            ]);
        } else {
            return response()->json([
                'Supplier not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* --- Update supplier ----------------------------------------------------------- */
    public function updateSuppliers(Request $request, $id)
    {
        //validation for update, response feedback if you fail to enter correct data
        $request->validate([
            'name' => 'required|max:64|min:3',
            'email' => 'required|max:256',
            'phone' => 'required|min:6|numeric'
        ]);

        //update suppliers post
        $suppliers = Supplier::find($id);
        //validation messeges
        if ($suppliers != null) {
            $suppliers->update($request->all());
            return $suppliers;
        } else {
            return response()->json([
                'Supplier not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */
}
