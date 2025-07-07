<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Direct Category List Page(admin)
    public function list()
    {
        $categoryList = Category::when(request('searchKey'), function ($query) {
            $query->where('name', 'like', '%' . request('searchKey') . '%');
        })->orderBy('id', 'desc')->paginate(5);
        // $categoryList->appends(request()->all());

        return view('admin.category.list', compact('categoryList'));
    }

    // Direct Category create Page(admin)
    public function createPage()
    {
        return view('admin.category.create');
    }

    // admin -> Create category(get data to create)

    public function create(Request $request)
    {
        // dd($request->all());

        $this->validationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }
    // admin -> Delete category
    public function delete($id)
    {
        // dd($id);
        Category::where('id', $id)->delete();
        return back()->with(['deleteMessage' => 'Category Deleted...']);
    }

    // admin -> Edit category
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    // admin -> Update category
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validationCheck($request);
        $data = $this->requestCategoryData($request);
        // dd($data);
        Category::where('id', $request->categoryId)->update($data);
        return redirect()->route('category#list');
    }

    // Category Validation Check
    private function validationCheck($request)
    {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,name,' . $request->categoryId
        ])->validate();
    }

    // Request Category Data(obj to array)
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->categoryName
        ];
    }
}
