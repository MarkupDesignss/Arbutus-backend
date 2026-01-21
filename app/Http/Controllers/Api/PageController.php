<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Exception;

class PageController extends Controller
{
    //Get single page by slug
    public function index($slug)
    {
        try {
            $page = Page::where('slug', $slug)->first();

            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'meta_tags' => $page->meta_tags,
                    'content' => $page->content,
                    'status' => $page->status,
                    'created_at' => $page->created_at,
                    'updated_at' => $page->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
