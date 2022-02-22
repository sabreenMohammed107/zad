<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language as ModelsLanguage;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category = Category::paginate(5);
        $langs = ModelsLanguage::get();
        return $this->dataResponse([$category, $langs], 'All category Retrieved  Successfully');
        // return $this->paginateCollection([$category, $langs],5, 'All category Retrieved  Successfully');


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
        // $input = $request->all();
        $input = $request->except(['image']);

        $validator = Validator::make($input, [
            // 'ar_name' => 'required',
            // 'language_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        if ($request->hasFile('image')) {
            $attach_image = $request->file('image');

            $input['image'] = $this->UplaodImage($attach_image);
        }
        $category = Category::create($input);

        return $this->dataResponse($category->toArray(), 'category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('category not found.');

        }

        return $this->dataResponse($category->toArray(), 'category retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('category not found.');

        }

        return $this->dataResponse($category->toArray(), 'category retrieved successfully.');
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
        $category = Category::find($id);
        $input = $request->except(['image']);

        $validator = Validator::make($input, [
            // 'ar_name' => 'required',
            // 'language_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }
        if ($request->hasFile('image')) {
            $attach_image = $request->file('image');

            $input['image'] = $this->UplaodImage($attach_image);
        }
        $category->update($input);

        return $this->dataResponse($category->toArray(), 'category update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return $this->dataResponse(null, 'category delete successfully.');

    }

    /* uplaud image
     */
    public function UplaodImage($file_request)
    {
        //  This is Image Info..
        $file = $file_request;
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $path = $file->getRealPath();
        $mime = $file->getMimeType();

        // Rename The Image ..
        $imageName = $name;
        $uploadPath = public_path('uploads/category');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }
    public function order(Request $request)
    {
        $inputs = $request->all();

        $data=[];
        foreach ($inputs as $key=>$obj) {
            $category = Category::find($obj['id']);
            if ($category) {
                $category->update(['order' => $obj['order']]);
                array_push($data,$category);

            }
        }

        return $this->dataResponse($data, 'category update successfully.');
    }
}
