<?php

// app/Http/Controllers/API/OptionController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest\OptionRequest;
use App\Models\Option;
use App\Models\Product;
use App\Repositories\OptionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class OptionController extends Controller
{

    public function __construct(protected OptionRepository $optionRepository)
    {
    }

    /**
     * Display the options for a specific product.
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function index(Product $product): JsonResponse
    {
        $options = $this->optionRepository->getAllOptionsForProduct($product->id);
        return response()->json(['options' => $options], Response::HTTP_OK);
    }

    /**
     * Store a new option for the specified product.
     *
     * @param  OptionRequest  $request
     * @param  Product  $product
     * @return JsonResponse
     */
    public function store(OptionRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        $data['product_id'] = $product->id;
        $option = $this->optionRepository->createOption($data);

        return response()->json(['option' => $option], Response::HTTP_CREATED);
    }

    /**
     * Show the specified option for the product.
     *
     * @param  Product  $product
     * @param  Option  $option
     * @return JsonResponse
     */
    public function show(Product $product, Option $option): JsonResponse
    {
        if ($this->optionRepository->getOptionForProduct($option->id, $product->id) === null) {
            return response()->json(['message' => 'Option not found for the product'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['option' => $option], Response::HTTP_OK);
    }

    /**
     * Update the specified option for the product.
     *
     * @param  OptionRequest  $request
     * @param  Product  $product
     * @param  Option  $option
     * @return JsonResponse
     */
    public function update(OptionRequest $request, Product $product, Option $option): JsonResponse
    {
        if ($this->optionRepository->getOptionForProduct($option->id, $product->id) === null) {
            return response()->json(['message' => 'Option not found for the product'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validated();

        if ($this->optionRepository->updateOptionForProduct($option->id, $product->id, $data)) {
            $option->refresh();
            return response()->json(['option' => $option], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Failed to update option'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified option for the product.
     *
     * @param  Product  $product
     * @param  Option  $option
     * @return JsonResponse
     */
    public function destroy(Product $product, Option $option): JsonResponse
    {
        if ($this->optionRepository->getOptionForProduct($option->id, $product->id) === null) {
            return response()->json(['message' => 'Option not found for the product'], Response::HTTP_NOT_FOUND);
        }

        if ($this->optionRepository->deleteOptionForProduct($option->id, $product->id)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json(['message' => 'Failed to delete option'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

