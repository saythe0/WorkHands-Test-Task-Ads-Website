<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ad;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validSortFields = ['price', 'created_at'];
        $validSortOrders = ['asc', 'desc'];

        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortField, $validSortFields) || !in_array($sortOrder, $validSortOrders)) {
            return response()->json(['error' => 'Неверные значения для сортировки'], 400);
        }

        $ads = Ad::orderBy($sortField, $sortOrder)->paginate(10);

        $adsData = $ads->map(function ($ad) {
            $photos = is_array($ad->photo_links) ? $ad->photo_links : json_decode($ad->photo_links, true);

            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'price' => $ad->price,
                'main_photo' => isset($photos[0]) ? $photos[0] : null,
            ];
        });

        return response()->json([
            'data' => $adsData,
            'pagination' => [
                'current_page' => $ads->currentPage(),
                'last_page' => $ads->lastPage(),
                'per_page' => $ads->perPage(),
                'total' => $ads->total(),
            ],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'photo_links' => is_array($request->input('photo_links')) ? $request->input('photo_links') : json_decode($request->input('photo_links'), true),
        ]);

        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'photo_links' => 'required|array|max:3',
            'photo_links.*' => 'required|url',
            'price' => 'required|numeric|min:0',
        ], [
            'title.required' => 'Пожалуйста, введите название объявления.',
            'title.max' => 'Название не должно превышать 200 символов.',
            'description.max' => 'Описание не должно превышать 1000 символов.',
            'photo_links.required' => 'Пожалуйста, добавьте хотя бы одну ссылку на фото.',
            'photo_links.array' => 'Ссылки на фото должны быть в формате массива.',
            'photo_links.max' => 'Вы можете добавить не более 3 фотографий.',
            'photo_links.*.url' => 'Каждая ссылка на фото должна быть действительным URL.',
            'price.required' => 'Пожалуйста, укажите цену объявления.',
            'price.numeric' => 'Цена должна быть числом.',
            'price.min' => 'Цена не может быть отрицательной.',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors()
            ]);
        }

        $ad = Ad::create([
            'title' => $request->input('title'),
            'description' => $request->input('description') ?? null,
            'photo_links' => $request->input('photo_links'),
            'price' => $request->input('price'),
        ]);

        return response()->json([
            'id' => $ad->id,
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $ad = Ad::find($id);

        if (!$ad) {
            return response()->json(['message' => 'Объявление не найдено'], 404);
        }

        $photos = is_array($ad->photo_links) ? $ad->photo_links : json_decode($ad->photo_links);

        $response = [
            'title' => $ad->title,
            'price' => $ad->price,
            'main_photo' => $photos[0],
        ];

        $availableFields = [
            'description' => $ad->description,
            'photo_links' => $photos,
        ];

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));

            foreach ($fields as $field) {
                if (array_key_exists($field, $availableFields)) {
                    $response[$field] = $availableFields[$field];
                }
            }
        }

        return response()->json($response);
    }
}
