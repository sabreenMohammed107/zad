<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\CategoriesResourceWeb;
use App\Http\Resources\SubCategoriesResource;
use App\Models\Category;
use App\Models\Language as ModelsLanguage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
    * @OA\Get(
    *
     *      path="/api/category",
    * tags={"categories web"},
    *      summary="list categories ",
    *      description="list categories ",
    *
    *     @OA\RequestBody(
    *
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *        @OA\Property(
    *           property="type",
    *           description="1",
    *           type="string",
    *         ),
    *
    *
    *       ),
    *     ),
    *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *
    *       ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {

        $category = Category::paginate(5);
        return $this->dataResponse(['data'=> CategoriesResourceWeb::collection($category)]);

    }

    /**
    * @OA\Post(
    *
     *      path="/api/category",
    *      operationId="categoryMobile",
    *      tags={"categories"},
    *      summary="list categories for mobile",
    *      description="list categories for mobile",
    *      security={{"Bearer": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *        @OA\Property(
    *           property="type",
    *           description="1",
    *           type="string",
    *         ),
    *            @OA\Property(
    *           property="language_id",
    *           description="1 or 2.",
    *           type="string",
    *         ),
    *            @OA\Property(
    *           property="id",
    *           description="1",
    *           type="string",
    *        ),
    *       ),
    *     ),
    *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Bad Request"
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    * )
    */

    public function categoryMobile(Request $request)
    {

        $category = Category::query();
        if(isset($request->id))
        {
            $category = $category->where('id',$request->id)->firstOrFail();
            return $this->dataResponse(['data'=> new CategoriesResource($category)]);

        }
        if(isset($request->page))
        {
            $category = $category->paginate(5);
        }
        else
        {
            $category = $category->get();

        }

        return $this->dataResponse(['data'=> CategoriesResource::collection($category)]);

    }
/**
    * @OA\Post(
    *
    *      path="/api/get_subcategory_by_maincategory",
    *      operationId="get sub category by main category",
    *      tags={"categories"},
    *      summary="list sub categories for mobile",
    *      description="list sub categories for mobile",
    *      security={{"Bearer": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *        @OA\Property(
    *           property="category",
    *           description="1",
    *           type="string",
    *        ),
    *       ),
    *     ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function subOfMain(Request $request)
    {

        $categories = Subcategory::query();
        if(isset($request->category))
        {
            $categories = $categories->where('category_id',$request->category);
        }

        if(isset($request->page))
        {
            $categories = $categories->paginate(5);
        }

        else
        {
            $categories = $categories->get();

        }

        return $this->dataResponse(['data'=> SubCategoriesResource::collection($categories)]);

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
        return $this->dataResponse(['data'=> CategoriesResourceWeb::make($category)]);


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

        return $this->dataResponse(['data'=> CategoriesResourceWeb::make($category)]);

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

        return $this->dataResponse(['data'=> CategoriesResourceWeb::make($category)]);
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

        return $this->dataResponse(['data'=> CategoriesResourceWeb::make($category)]);
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
        if (is_null($category)) {
            return $this->sendError('category not found.');

        }
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
        $uploadPath = storage_path('uploads/category');

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

        return $this->dataResponse(['data'=> CategoriesResourceWeb::collection($category)]);

    }
}
