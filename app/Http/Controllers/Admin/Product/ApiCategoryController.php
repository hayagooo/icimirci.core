<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Category_product;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ApiCategoryController extends Controller
{
    public $data;
    public $dataType;

    public function __construct(Category_product $data){
        $this->data = $data;
        $this->dataType = 'Category_product';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'description' => ['required', 'mas:50']
        ]);
        $data = new Category_product();
        $data->category = $request->category;
        $data->description = $request->description;
        $data->save();
        return $this->onSuccess($this->dataType, $data, 'created');
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
        //
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
        //
        $data = Category_product::find($id);
        $data->category = $request->category;
        $data->description = $request->description;
        $data->save();
        return $this->onSuccess($this->dataType, $data, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Category_product::find($id);
        $data->delete();
        return $this->onSuccess($this->dataType, $data, 'Destroyed');
    }
}
