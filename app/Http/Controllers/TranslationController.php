<?php

namespace App\Http\Controllers;

use App\Contracts\TranslationExportInterface;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    public function __construct(
        private TranslationExportInterface $exportService
    ) {}

   /**
     * Display a paginated listing of translations.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Translation::paginate(50);
    }

    /**
     * Store a newly created translation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'locale' => 'required|string|max:10',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255'
        ]);

        $translation = Translation::create($validated);

        Cache::forget('translations.export.all');
        Cache::forget("translations.export.{$validated['locale']}");

        return response()->json($translation, 201);
    }

    /**
     * Display the specified translation.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Translation $translation)
    {
        return response()->json($translation);
    }

    /**
     * Update the specified translation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Translation $translation)
    {
        $validated = $request->validate([
            'key' => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|string',
            'locale' => 'sometimes|required|string|max:10',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255'
        ]);

        $translation->update($validated);

        Cache::forget('translations.export.all');
        Cache::forget("translations.export.{$translation->locale}");

        return response()->json($translation);
    }

    /**
     * Remove the specified translation.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();

        Cache::forget('translations.export.all');
        Cache::forget("translations.export.{$translation->locale}");

        return response()->json(null, 204);
    }

    /**
     * Search translations by key.
     *
     * @param  string  $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByKey($key)
    {
        return response()->json([
            'data' => Translation::byKey($key)->paginate(50),
            'message' => 'Translations filtered by key'
        ]);
    }

    /**
     * Search translations by tag.
     *
     * @param  string  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByTag($tag)
    {
        return response()->json([
            'data' => Translation::byTag($tag)->paginate(50),
            'message' => 'Translations filtered by tag'
        ]);
    }

    /**
     * Search translations by content.
     *
     * @param  string  $content
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByContent($content)
    {
        return response()->json([
            'data' => Translation::searchContent($content)->paginate(50),
            'message' => 'Translations containing search term'
        ]);
    }

    /**
     * Export translations as JSON.
     *
     * @param  string|null  $locale
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportJson($locale = null)
    {
        return response()->json(
            $this->exportService->export($locale)
        );
    }
}