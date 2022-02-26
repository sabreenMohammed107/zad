<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResourceWeb;
use App\Models\Category;
use App\Models\Language;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Validator;
class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category = Category::get();
        // $langs = Language::get();
        $subcategory = Subcategory::paginate(5);
        return $this->dataResponse(['data'=> SubcategoryResourceWeb::collection($subcategory)]);
        // return $this->paginateCollection([$subcategory],5, 'All category Retrieved  Successfully');
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
        $input = $request->except(['image']);

        $validator = Validator::make($input, [
            'ar_name' => 'required',
            // 'language_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        if ($request->hasFile('image')) {
            $attach_image = $request->file('image');

            $input['image'] = $this->UplaodImage($attach_image);
        }
        $subcategory = Subcategory::create($input);

        return $this->dataResponse(['data'=> SubcategoryResourceWeb::make($subcategory)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);

        if (is_null($subcategory)) {
            return $this->sendError('Subcategory not found.');

        }

        return $this->dataResponse(['data'=> SubcategoryResourceWeb::make($subcategory)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);


        if (is_null($subcategory)) {
            return $this->sendError('subcategory not found.');

        }

        return $this->dataResponse(['data'=> SubcategoryResourceWeb::make($subcategory)]);
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
        $subcategory = Subcategory::find($id);
        $input = $request->except(['image']);

        $validator = Validator::make($input, [
            // 'ar_name' => 'required',
            // 'language_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        $subcategory->update($input);

        return $this->dataResponse(['data'=> SubcategoryResourceWeb::make($subcategory)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        if (is_null($subcategory)) {
            return $this->sendError('category not found.');

        }
        $subcategory->delete();
        return $this->dataResponse(null, 'subcategory delete successfully.');

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
        $uploadPath = storage_path('uploads/subCategory');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }

    public function order(Request $request)
    {
        $inputs = $request->all();

        $data=[];
        foreach ($inputs as $key=>$obj) {
            $subcategory = Subcategory::find($obj['id']);
            if ($subcategory) {
                $subcategory->update(['order' => $obj['order']]);
                array_push($data,$subcategory);

            }
        }

        return $this->dataResponse(['data'=> SubcategoryResourceWeb::collection($data)]);
    }
}
