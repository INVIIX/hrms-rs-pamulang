<?php

namespace App\Http\Controllers\API;

use App\Helpers\EnumHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllEnumResource;
use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class EnumReferenceController extends Controller
{
    public function index(): JsonResource
    {
        $collections = EnumHelper::getAllEnums();
        return new JsonResource($collections);
    }

    public function show(Request $request): AnonymousResourceCollection
    {
        $collection_name = $request->segment(3);
        $collections = EnumHelper::get($collection_name);
        return EnumResource::collection($collections);
    }
}
