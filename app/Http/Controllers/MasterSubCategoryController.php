<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class MasterSubCategoryController extends Controller
{
    public function storesubcat(Request $request)
    {
        $validate_data = $request->validate([
            'subcategory_name' => 'unique:subcategories|max:100|min:5',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::create($validate_data);

        return redirect()->back()->with('message', ' Sub Category Added successfully.');
    }

    public function showsubcat($id)
    {
        $subcategory_info = SubCategory::find($id);
        return view('admin.sub_category.edit', compact('subcategory_info'));
    }

    public function updatesubcat(Request $request, $id)
    {
        $validate_data = $request->validate([
            'subcategory_name' => 'required|max:100|min:5',
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $validate_data = $request->validate([
            'category_name' => 'unique:categories|max:100|min:5',
        ]);

        $subcategory->update($validate_data);

        return redirect()->back()->with('message', 'Sub Category updated successfully.');
    }

    public function deletesubcat($id)
    {
        SubCategory::findOrFail($id)->delete();


        return redirect()->back()->with('message', 'Sub Category deleted successfully.');
    }
}
