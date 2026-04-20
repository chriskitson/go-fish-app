<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function manage_categories(Request $request)
    {
        $user = $request->user();
        if ($user->global_admin == 1) {
            $categories = Category::orderBy('name', 'asc')->get();
            return response()->json($categories);
        } else {
            return response("Unauthorized", 401);
        }
    }

    public function manage_category(Request $request, $id)
    {
        $user = $request->user();
        if ($user->global_admin == 1) {
            $category = Category::find($id);
            if ($category) {
                return response()->json($category);
            }
            return response("Not Found", 404);
        } else {
            return response("Unauthorized", 401);
        }
    }

    public function upload_image(Request $request, $id)
    {
        $user = $request->user();
        $is_global_admin = $user->global_admin == 1;

        if ($is_global_admin) {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            if ($validator->fails()) {
                return response("Invalid image", 400);
            }

            $upload_folder = 'categories';
            $image = $request->file('image');
            $image_uploaded_path = $image->store($upload_folder, 'public');
            $image_url = '/storage/' . $image_uploaded_path;

            // update database
            Category::where([
                ["id", "=", $id]
            ])->update(array(
                "image" => $image_url
            ));

            $image_response = array(
                "image_name" => basename($image_uploaded_path),
                "image_url" => $image_url,
                "mime" => $image->getClientMimeType()
            );

            return response($image_response, 200);
        } else {
            return response("Unauthorized", 401);
        }
    }

    public function delete_image(Request $request, $id)
    {
        $user = $request->user();
        $is_global_admin = $user->global_admin == 1;

        if ($is_global_admin) {
            Category::where([
                ["id", "=", $id]
            ])->update(array(
                "image" => ""
            ));

            return response()->json(["success" => true]);
        } else {
            return response("Unauthorized", 401);
        }
    }
}
