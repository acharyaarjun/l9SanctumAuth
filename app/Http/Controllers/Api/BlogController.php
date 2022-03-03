<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
   
class BlogController extends BaseController
{

    public function index(Request $request)
    {
        $blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($blogs), 'Post fetched');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'details' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

   
    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }
    

    public function update(Request $request, Blog $blog)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $blog->title = $input['title'];
        $blog->details = $input['details'];
        $blog->save();
        
        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }
   
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}