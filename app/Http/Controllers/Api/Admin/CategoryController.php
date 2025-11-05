<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Project::all();
        return $this->successResponse('', $records);
    }

    // public function active()
    // {
    //     $records = Project::select('id', 'name')->where('status', ST_ACTIVE)->get();
    //     return $this->successResponse('', $records);
    // }

    public function store(Request $request)
    {

        $rules = [
            "title"       => "required|unique:projects,title,NULL,id",
            'notebook'    => 'required',
            'description' => 'required',
            'image'       => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }
        $deleteErrorImages = [];

        try {

            $newItem              = new Project();
            $newItem->title       = $request->title;
            $newItem->notebook    = $request->notebook;
            $newItem->description = $request->description;
            $newItem->slug        = Str::slug($request->title);
            $newItem->status      = (int) $request->status ?: ST_ACTIVE;
            $newItem->mask        = generate_mask();
            $bannerImage          = $request->file('image');
            if ($bannerImage) {
                $uploadResult = uploadItemImage($bannerImage, $request->title, ST_CATEGORY_FOLDER, ST_WEB);
                if ($uploadResult) {
                    $newItem->image          = $uploadResult->path;
                    $newItem->image_filename = $uploadResult->filename;
                    $deleteErrorImages[]     = ['folder' => ST_CATEGORY_FOLDER, 'filename' => $uploadResult->filename];
                }
            }
            $newItem->mask = generate_mask();
            //return $deleteErrorImages;
            if ($newItem->save()) {
                return $this->successResponse(SUCCESS_CREATING_MESSAGE);
            }
            return $this->errorResponse(ERROR_CREATING_MESSAGE);
        } catch (Exception $e) {

            if (! empty($deleteErrorImages)) {
                foreach ($deleteErrorImages as $key => $value) {
                    $value = (object) $value;
                    deleteOldImage($value->filename, $value->folder);
                }
            }
            return $this->errorResponse($e->getMessage());

        }

        // } catch (Exception $e) {

    }

    public function show($id)
    {
        $newItem = Project::where('mask', $id)->first();
        if (! $newItem) {
            return $this->errorResponse('Resource not found');
        }
        return $this->successResponse('', $newItem);
    }

    public function update(Request $request, $id)
    {
        try {

            $newItem = Project::where('mask', $id)->first();
            if (! $newItem) {
                return $this->errorResponse('Resource not found');
            }
            $rules = [
                "title" => "required",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }
            $newItem->title       = $request->title;
            $newItem->notebook    = $request->notebook;
            $newItem->description = $request->description;
            $newItem->status      = $request->status;
            $newItem->slug        = Str::slug($request->name);
            $bannerImage          = $request->file('image');
            if ($bannerImage) {
                $uploadResult = uploadItemImage($bannerImage, $request->name, ST_CATEGORY_FOLDER, ST_WEB);
                if ($uploadResult) {
                    $newItem->banner_image          = $uploadResult->path;
                    $newItem->banner_image_filename = $uploadResult->filename;
                    $deleteErrorImages[]            = ['folder' => ST_CATEGORY_FOLDER, 'filename' => $uploadResult->filename];
                }
            }
            if ($newItem->save()) {
                return $this->successResponse(SUCCESS_UPDATING_MESSAGE);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $findRecord = Project::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }
        $findRecord = Project::where('mask', $id)->delete();

        return $this->successResponse(SUCCESS_DELETING_MESSAGE);
    }

}
