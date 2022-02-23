<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Daily_quiz;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::paginate(5);
        return $this->dataResponse([$questions], 'All questions Retrieved  Successfully');
        // return $this->paginateCollection([$questions],5, 'All category Retrieved  Successfully');


    }
    public function filter(Request $request)
    {
        $questions = Question::orderBy('id', 'DESC');

        if (!empty($request->get("language_id"))) {
            $questions->where('language_id', '=', $request->get("language_id"));
        }
        if (!empty($request->get("category_id"))) {
            $questions->where('category_id', '=', $request->get("category_id"));
        }
        if (!empty($request->get("sub_category_id"))) {
            $questions->where('sub_category_id', '=', $request->get("sub_category_id"));
        }
        $questions = $questions->paginate(5);

        return $this->dataResponse([$questions], 'All questions Retrieved  Successfully');
        // return $this->paginateCollection([$questions],5, 'All category Retrieved  Successfully');

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
        $question = Question::create($input);

        return $this->dataResponse($question->toArray(), 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);

        if (is_null($question)) {
            return $this->sendError('Question not found.');

        }

        return $this->dataResponse($question->toArray(), 'Question retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);

        if (is_null($question)) {
            return $this->sendError('Question not found.');

        }

        return $this->dataResponse($question->toArray(), 'Question retrieved successfully.');
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
        $question = Question::find($id);
        $input = $request->except(['image']);

        $validator = Validator::make($input, [
            // 'ar_name' => 'required',
            // 'language_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        $question->update($input);

        return $this->dataResponse($question->toArray(), 'question update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return $this->dataResponse(null, 'question delete successfully.');

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
        $uploadPath = public_path('uploads/question');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }

// add daily quiz
    public function addDailyQuize(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            // 'language_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        $data = $request->get('question');
        if ($inputs) {
            foreach ($data as $key => $obj) {
                foreach ($obj as  $objIn) {
                $daily = new Daily_quiz();
                $daily->language_id = $request->get('language_id');
                $daily->questions_id = $objIn;
                $daily->date_published = Carbon::parse($request->get('date_published'));
                $daily->save();
            }
        }
        }
        $daily = Daily_quiz::paginate(5);
        // return $this->paginateCollection([$daily],5, 'All category Retrieved  Successfully');

        return $this->dataResponse([$daily], 'All daily questions Retrieved  Successfully');
    }
    //delete daily quiz
    public function deleteDailyQuize($id){
        $question = Daily_quiz::find($id);
        if (is_null($question)) {
            return $this->sendError('daily question not found.');

        }
        $question->delete();
        return $this->successResponse(null, 'daily question delete successfully.');
    }

    //filter daily quiz
    public function daily_filter(Request $request)
    {
        $daily = Daily_quiz::orderBy('id', 'DESC');

        if (!empty($request->get("language_id"))) {
            $daily->where('language_id', '=', $request->get("language_id"));
        }
        if (!empty($request->get("questions_id"))) {
            $daily->where('questions_id', '=', $request->get("questions_id"));
        }

        $questions = $daily->paginate(5);
// dd($questions);
        return $this->dataResponse([$questions], 'All questions Retrieved  Successfully');
        // return $this->paginateCollection($questions, 'All category Retrieved  Successfully');

    }
	
	 public function report(){
        $questions = Question_report::paginate(5);
        return $this->dataResponse([$questions], 'All questions report by users  Retrieved  Successfully');
    }
}
