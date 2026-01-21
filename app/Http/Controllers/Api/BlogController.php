<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Exception;

class BlogController extends Controller
{
    // All Blogs List
    public function list()
    {
        try {
            $blogs = Blog::where('status', 1)
                        ->orderBy('post_date', 'desc')
                        ->get(['id','title','slug','short_description','image','author_name','post_date']);

            // Map image to full URL
            $blogs->transform(function($blog){
                $blog->image = $blog->image ? asset('storage/blogs/'.$blog->image) : null;
                return $blog;
            });

            return response()->json([
                'status' => true,
                'message' => 'Blog list fetched successfully',
                'data' => $blogs
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch blog list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Single Blog Details by Slug
    public function details($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)
                        ->where('status', 1)
                        ->first();

            if (!$blog) {
                return response()->json([
                    'status' => false,
                    'message' => 'Blog not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Blog details fetched',
                'data' => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'author_name' => $blog->author_name,
                    'post_date' => $blog->post_date,
                    'image' => $blog->image ? asset('storage/blogs/'.$blog->image) : null,
                    'short_description' => $blog->short_description,
                    'long_description' => $blog->long_description
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch blog details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
