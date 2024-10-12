<?php

namespace App\Providers;

use App\Models\MenuOption;

class UssdMenuService
{
    /**
     * Get the parent menu ID based on the USSD path
     * @param string $path (e.g. "1*2*3")
     * @return int|null
     */
    public function getParentMenuIdFromPath($path)
    {
        // Explode the USSD path into an array of option codes
        $codes = explode('*', $path);

        // Start with no parent
        $parentId = null;

        // Loop through each code and find the corresponding menu option
        foreach ($codes as $code) {
            $menuOption = MenuOption::where('option_code', $code)
                ->where('parent_id', $parentId)
                ->first();

            if (!$menuOption) {
                // If no matching menu option is found, return null
                return null;
            }

            // Update parent ID for the next iteration
            $parentId = $menuOption->id;
        }

        return $parentId;
    }
}
