<?php

namespace App\Http\Controllers\Admin\Art;

use App\Http\Controllers\Controller;
use App\Models\Art;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ArtController extends Controller
{
    public $path;
    public $dimen;

    public function __construct()
    {
        $this->path = public_path() . '/image/art/';
        $this->dimen = 750;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Art::query();
        if ($request->get('title') && $request->get('title') != null) {
            $arts = $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
        }
        $arts = $query->get();
        return Inertia::render('Admin/Art/Index', compact('arts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Art/Create');
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
            'title' => ['required', 'max:20'],
            'description' => ['required', 'max:50'],
            'picture' => 'required|image|mimes:jpg,png,jpeg|max:4048'
        ]);

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
        return redirect()->route('art.index')->with('status', 'Berhasil');
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
        $art = Art::find($id);
        return Inertia::render('Admin/Art/Edit', compact('art'));
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
            'title' => ['required', 'max:20'],
            'description' => ['required', 'max:50'],
        ]);

        $data = Art::find($id);

        if (isset($request->picture)) {
            $request->validate([
                'picture' => 'required|image|mimes:jpg,png,jpeg|max:4048'
            ]);
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
        return redirect()->route('art.index')->with('status', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Art::destroy($id);
        return redirect()->route('art.index')->with('status', 'Berhasil');
    }
}
