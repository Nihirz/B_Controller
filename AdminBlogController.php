<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class AdminBlogController extends Controller
{
    public function blog()
    {
        $blog = Blog::get();
        return view('adminBlog',compact('blog'));
    }
    public function add_blog()
    {
        return view('addBlog');
    }
    public function store_blog(Request $request)
    {
        
        // data insert
        $blog = new Blog();
        $blog->title =$request->input('title');      
        $blog->description =$request->input('description');
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploads'), $imageName);
            $blog->image = $imageName;
        }
        else
        {
            return $request;
            $blog->image = '';
        }
        $blog->save();
        $request->session()->flash('message','Data Uploded Successfully.');
        return redirect()->route('admin.blog')->with('success', 'Product Inserted Successfully!');
    }
    public function edit_blog(Request $request,$id)
    {
        $blog =Blog::where('id',$id)->first();
        return view('editBlog',compact('blog'));
    }
    public function update_blog(Request $request)
     {
        $blog =Blog::find($request->id);
        $blog->title =$request->input('title');
        $blog->description =$request->input('description');      
    
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploads'), $imageName);
            $blog->image = $imageName;
        }
        else
        {
            $id = $request->id;
            $update = [  
            'title'=>$request->title,
           'description'=>$request->description,
           
           
     ];
     $file   = $request->file("image");
        if ($request->hasfile("image")) {
        $file->move("/upload", $file->getClientOriginalName());
        $update['image'] = $file->getClientOriginalName();
        }
    
        blog::where('id', $id)->update($update);
        return redirect()->route('admin.blog')->with('success', 'Product Updated Successfully!');
    
    
            return $request;
            $blog->image = '';
        }
        $blog->save();
        return redirect()->route('admin.blog')->with('success', 'Product Updated Successfully!');
     }

    public function delete_blog(Request $request,$id){
        Blog::where('id',$id)->delete();
        return redirect()->route('admin.blog')->with('warning','Product Deleted successfully!');
     }
}
