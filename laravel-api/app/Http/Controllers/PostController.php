<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param  PostStoreRequest  $request
     * @return PostResource
     */
    public function store(PostStoreRequest $request): PostResource
    {
        $post = Auth::user()->posts()
            ->create($request->validated());

        $this->postService->createImage($post, $request->validated('image'));

        return new PostResource($post);
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $posts = Post::filter($request->all())
            ->sort($request->all())
            ->paginate(9);

        return PostResource::collection($posts)->all();
    }

    /**
     * @param  Post  $post
     * @return PostResource
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * @param  PostUpdateRequest  $request
     * @param  Post  $post
     * @return PostResource
     */
    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $this->postService->updateImage($post, $request->validated('image'));

        $post->update($request->validated());

        $post->load('image');

        return new PostResource($post);
    }

    /**
     * @param  Post  $post
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted',
        ]);
    }
}
