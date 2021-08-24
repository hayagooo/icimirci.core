<?php

namespace App\Http\Controllers\Admin\Art;

use App\Http\Controllers\Controller;
use App\Models\Art;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class ApiArtController extends Controller
{
    public $data;
    public $path;
    public $dataType;
    public $dimen;

    public function __construct(Art $data)
    {
        $this->data = $data;
        $this->dataType = 'Art';
        $this->path = public_path() . '/image/art/';
        $this->dimen = 750;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Art::all();
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
        $data = new Art();
        $data->title = $request->title;
        $data->description = $request->description;
        // make new picture
        $picture = $request->file('picture');
        $pictureName = 'picture_' . $request->title . '_' . uniqid() . '.' . $picture->extension();
        $pictureImg = Image::make($picture->path());
        $pictureImg->resize($this->dimen, $this->dimen, function ($constraint) {
            $constraint->aspectRatio();
        });
        if (!File::isDirectory($this->path)) {
            File::makeDirectory($this->path, 0777, true, true);
        }
        $pictureImg->save($this->path . $pictureName);
        $data->picture = $pictureName;
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
        $data = Art::find($id);
        return $this->onSuccess($this->dataType, $data, 'Founded');
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
        $data = Art::find($id);

        if (isset($request->picture)) {
            unlink($this->path . $data->picture);
            $picture = $request->file('picture');
            $pictureName = 'picture_' . $request->title . '_' . uniqid() . '.' . $picture->extension();
            $pictureImg = Image::make($picture->path());
            $pictureImg->resize($this->dimen, $this->dimen, function ($constraint) {
                $constraint->aspectRatio();
            });
            if (!File::isDirectory($this->path)) {
                File::makeDirectory($this->path, 0777, true, true);
            }
            $pictureImg->save($this->path . $pictureName);
            $data->picture = $pictureName;
        }
        $data->title = $request->title;
        $data->description = $request->description;
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
        $data = Art::find($id);
        if (File::exists($this->path . $data->picture)) {
            unlink($this->path . $data->picture);
        }
        $data->delete();
        return $this->onSuccess($this->dataType, $data, 'Destroyed');
    }
}
