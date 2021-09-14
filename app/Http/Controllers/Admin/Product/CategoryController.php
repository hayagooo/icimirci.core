<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Category_product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category_product::query();
        if ($request->get('category') && $request->get('category') != null) {
            $data = $query->where('category', 'LIKE', '%' . $request->get('category') . '%');
        }
        $data = $query->get();
        return Inertia::render('Admin/Product/Category/Index', ['category_product' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Product/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'max:20'],
            'description' => ['required', 'max:50']
        ]);
        $data = new Category_product();
        $data->category = $request->category;
        $data->description = $request->description;
        $data->save();
        return redirect()->route('category.index')->with('status', 'berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_product = Category_product::find($id);
        return Inertia::render('Admin/Product/Category/Edit', compact('category_product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Category_product::find($id);
        $data->category = $request->category;
        $data->description = $request->description;
        $data->save();
        return redirect()->route('category.index')->with('status', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Category_product::destroy($id);
        return redirect()->route('category.index')->with('status', 'Berhasil');
    }
}
