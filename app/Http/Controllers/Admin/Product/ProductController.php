<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category_product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public $path;
    public $dimen;

    public function __construct()
    {
        $this->path = public_path() . '/image/product/';
        $this->dimen = 750;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->get('name') && $request->get('name') != null) {
            $data = $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
        }
        $data = $query->get();
        return Inertia::render('Admin/Product/Index', ['products' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = Category_product::query();
        $data = $query->get();
        return Inertia::render('Admin/Product/Create', ['category_product' => $data]);
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
            'name' => ['required', 'max:20'],
            'description' => ['required', 'max:50'],
            'image' => 'required|image|mimes:jpg,png,jpeg|max:4048',
            'category_id' => ['required']
        ]);

        $data = new Product();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->category_id = $request->category_id;
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
        return redirect()->route('product.index')->with('status', 'Berhasil');
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
        $data = Product::find($id);
        $query = Category_product::query();
        $categoryData = $query->get();
        return Inertia::render('Admin/Product/Edit', ['product' => $data, 'category_product' => $categoryData]);
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
        $request->validate([
            'name' => ['required', 'max:20'],
            'description' => ['required', 'max:50'],
            'category_id' => ['required'],
        ]);

        $data = Product::find($id);

        if (isset($request->image)) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg|max:4048'
            ]);
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
        $data->name = $request->name;
        $data->description = $request->description;
        $data->category_id = $request->category_id;
        $data->save();
        return redirect()->route('product.index')->with('status', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::destroy($id);
        return redirect()->route('product.index')->with('status', 'Berhasil');
    }
}
