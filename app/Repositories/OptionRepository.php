<?php

namespace App\Repositories;

use App\Models\Option;

class OptionRepository
{
    /**
     * Get all options for a specific product.
     *
     * @param int $productId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOptionsForProduct(int $productId)
    {
        return Option::where('product_id', $productId)->get();
    }

    /**
     * Create a new option for the specified product.
     *
     * @param array $data
     * @return \App\Models\Option
     */
    public function createOption(array $data)
    {
        return Option::create($data);
    }

    /**
     * Get the specified option for the product.
     *
     * @param int $optionId
     * @param int $productId
     * @return \App\Models\Option|null
     */
    public function getOptionForProduct(int $optionId, int $productId)
    {
        return Option::where('id', $optionId)
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Update the specified option for the product.
     *
     * @param int $optionId
     * @param int $productId
     * @param array $data
     * @return bool
     */
    public function updateOptionForProduct(int $optionId, int $productId, array $data)
    {
        return Option::where('id', $optionId)
            ->where('product_id', $productId)
            ->update($data);
    }

    /**
     * Delete the specified option for the product.
     *
     * @param int $optionId
     * @param int $productId
     * @return bool|null
     */
    public function deleteOptionForProduct(int $optionId, int $productId)
    {
        return Option::where('id', $optionId)
            ->where('product_id', $productId)
            ->delete();
    }
}
