<?php
    namespace App\Http\Controllers\Api;

    use App\Models\Post;
    use Orion\Http\Controllers\Controller;
    
    class PostController extends Controller
    {
        protected $model = Post::class;

        // protected function searchableBy(): array
        // {
        //     return ['title','body'];
        // }
        protected function sortable_by(): array
        {
            return['title'];
        }
    }