<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\CategoriesResourceWeb;
use App\Http\Resources\SubCategoriesResource;
use App\Models\Category;
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
     *      path="/api/categories",
     * tags={"categories web"},
     *      summary="list categories ",
     *      description="list categories ",
     *  security={{"Bearer": {}}},
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
     *     @OA\Response(
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
     *     )
     */
    public function index()
    {

        $category = Category::paginate(5);
        return $this->dataResponse(['data' => CategoriesResourceWeb::collection($category)]);

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
        if (isset($request->id)) {
            $category = $category->where('id', $request->id)->firstOrFail();
            return $this->dataResponse(['data' => new CategoriesResource($category)]);

        }
        if (isset($request->page)) {
            $category = $category->paginate(5);
        } else {
            $category = $category->get();

        }

        return $this->dataResponse(['data' => CategoriesResource::collection($category)]);

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
        if (isset($request->category)) {
            $categories = $categories->where('category_id', $request->category);
        }

        if (isset($request->page)) {
            $categories = $categories->paginate(5);
        } else {
            $categories = $categories->get();

        }

        return $this->dataResponse(['data' => SubCategoriesResource::collection($categories)]);

    }

 /**
    * @OA\Post(
    *
    *       path="/categories",
     *      operationId="storeProject",
     *     tags={"categories web"},
     *      summary="Store new category",
    *      description="Returns user data and token",
    *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
  *        @OA\Property(
     *           property="ar_name",
     *           description="Name of the new category arabic.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="en_name",
     *           description="Name of the new category english.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="language_id",
     *           description="id  of the language.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="image",
     *           description="file upload to image confirmation.",
     *           type="file",
     *         ),
     *        @OA\Property(
     *           property="order",
     *           description="category order.",
     *           type="string",
     *         ),

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
        return $this->dataResponse(['data' => CategoriesResourceWeb::make($category)]);

    }
/**
     * @OA\Get(
     *      path="/categories/{id}",
     *      operationId="storeProject",
     *      tags={"categories web"},
     *      summary="show category",
     *      description="Returns Category data",
     *   security={{"Bearer": {}}},
     *       @OA\Parameter(
     *          name="id",
     *          description="category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
  *        @OA\Property(
     *           property="ar_name",
     *           description="Name of the new category arabic.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="en_name",
     *           description="Name of the new category english.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="language_id",
     *           description="id  of the language.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="image",
     *           description="file upload to image confirmation.",
     *           type="file",
     *         ),
     *        @OA\Property(
     *           property="order",
     *           description="category order.",
     *           type="string",
     *         ),

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
    public function show($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('category not found.');

        }

        return $this->dataResponse(['data' => CategoriesResourceWeb::make($category)]);

    }


    public function edit($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('category not found.');

        }

        return $this->dataResponse(['data' => CategoriesResourceWeb::make($category)]);
    }

 /**
   * @OA\Put(
     *      path="/categories/{id}",
     *      operationId="storeProject",
     *      tags={"categories web"},
     *      summary="update exist category",
     *      description="Returns project data",
     *   security={{"Bearer": {}}},
     *       @OA\Parameter(
     *          name="id",
     *          description="category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
    *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
  *        @OA\Property(
     *           property="ar_name",
     *           description="Name of the new category arabic.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="en_name",
     *           description="Name of the new category english.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="language_id",
     *           description="id  of the language.",
     *           type="string",
     *         ),
     *        @OA\Property(
     *           property="image",
     *           description="file upload to image confirmation.",
     *           type="file",
     *         ),
     *        @OA\Property(
     *           property="order",
     *           description="category order.",
     *           type="string",
     *         ),

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

        return $this->dataResponse(['data' => CategoriesResourceWeb::make($category)]);
    }
    /**
     * @OA\Delete(
     *      path="/categories/{id}",
     *      operationId="storeProject",
     *      tags={"categories web"},
     *      summary="Delete category",
     *      description="Returns project data",
     *   security={{"Bearer": {}}},
     *       @OA\Parameter(
     *          name="id",
     *          description="category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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

        $data = [];
        foreach ($inputs as $key => $obj) {
            $category = Category::find($obj['id']);
            if ($category) {
                $category->update(['order' => $obj['order']]);
                array_push($data, $category);

            }
        }

        return $this->dataResponse(['data' => CategoriesResourceWeb::collection($category)]);

    }
}
