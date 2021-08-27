<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class ApiProductController extends Controller
{
    public $data;
    public $path;
    public $dataType;
    public $dimen;

    public function __construct(Product $data)
    {
        $this->data = $data;
        $this->dataType = 'Product';
        $this->path = public_path() . '/image/product/';
        $this->dimen = 750;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return $this->onSuccess('Product', $data, 'Founded');
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
        $data = new Product();
        $data->name = $request->name;
        $data->description = $request->description;
        // make new picture
        $image = $request->file('image');
        $pictureName = 'image_' . $request->name . '_' . uniqid() . '.' . $image->extension();
        $pictureImg = Image::make($image->path());
        $pictureImg->resize($this->dimen, $this->dimen, function ($constraint) {
            $constraint->aspectRatio();
        });
        if (!File::isDirectory($this->path)) {
            File::makeDirectory($this->path, 0777, true, true);
        }
        $pictureImg->save($this->path . $pictureName);
        $data->image = $pictureName;
        $data->save();
        return $this->onSuccess($this->dataType, $data, 'Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::find($id);
        return $this->onSuccess($this->dataType, $data, 'Founded');
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
        $data = Product::find($id);

        $data->name = $request->name;
        $data->description = $request->description;
        if (isset($request->image)) {
            unlink($this->path . $data->image);
            $image = $request->file('image');
            $pictureName = 'image_' . $request->name . '_' . uniqid() . '.' . $image->extension();
            $pictureImg = Image::make($image->path());
            $pictureImg->resize($this->dimen, $this->dimen, function ($constraint) {
                $constraint->aspectRatio();
            });
            if (!File::isDirectory($this->path)) {
                File::makeDirectory($this->path, 0777, true, true);
            }
            $pictureImg->save($this->path . $pictureName);
            $data->image = $pictureName;
        }
        $data->save();
        return $this->onSuccess($this->dataType, $data, 'Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        if (File::exists($this->path . $data->image)) {
            unlink($this->path . $data->image);
        }
        $data->delete();
        return $this->onSuccess($this->dataType, $data, 'Destroyed');
    }
}
