<?php 
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Articles",
 *     description="Endpoints for managing articles"
 * )
 */
class ArticleController extends Controller
{
    /**
 * @OA\Schema(
 *     schema="Article",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 * )
 */

    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    /**
     * @OA\Post(
     *     path="/api/articles",
     *     summary="Create a new article",
     *     tags={"Articles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Article created", @OA\JsonContent(ref="#/components/schemas/Article"))
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $article = Article::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json($article, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/articles/{article}",
     *     summary="Update an existing article",
     *     tags={"Articles"},
     *     @OA\Parameter(name="article", in="path", required=true, @OA\Schema(type="integer"), description="Article ID"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Article updated", @OA\JsonContent(ref="#/components/schemas/Article"))
     * )
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $article->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json($article);
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/{article}",
     *     summary="Delete an article",
     *     tags={"Articles"},
     *     @OA\Parameter(name="article", in="path", required=true, @OA\Schema(type="integer"), description="Article ID"),
     *     @OA\Response(response="204", description="Article deleted")
     * )
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}