<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncReceiveController extends Controller
{
    public function country(Request $request): JsonResponse
    {
        return $this->upsert($request, Country::class, [
            'title', 'slug', 'smalltext', 'text', 'published', 'sorting',
            'metatitle', 'description', 'keywords',
        ]);
    }

    public function hotel(Request $request): JsonResponse
    {
        return $this->upsert($request, Hotel::class, [
            'country_id', 'title', 'slug', 'stars', 'rating', 'smalltext', 'text', 'published', 'sorting',
            'metatitle', 'description', 'keywords',
        ]);
    }

    public function review(Request $request): JsonResponse
    {
        return $this->upsert($request, Review::class, [
            'hotel_id', 'author_name', 'rating', 'text', 'published', 'sorting',
        ]);
    }

    /**
     * @param class-string<Model> $modelClass
     * @param string[] $fields
     */
    private function upsert(Request $request, string $modelClass, array $fields): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer',
            ...array_fill_keys($fields, 'sometimes'),
        ]);

        $id = $data['id'];
        unset($data['id']);

        // Тот же id, что и на hub'е — обязательно (доком; иначе hotel_id/country_id
        // между базами разъедутся). updateOrCreate тут не годится: 'id' не в Fillable,
        // при создании он будет молча отброшен.
        $model = $modelClass::query()->find($id) ?? new $modelClass();
        $model->id = $id;
        $model->fill($data);
        $model->save();

        return response()->json(['id' => $model->id]);
    }
}
