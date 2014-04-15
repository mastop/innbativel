<?php

class CategoryController extends BaseController {

    public function anyCategory($slug)
    {
        $category = null;
        if (!empty($slug)) {
            $category = Category::where('slug', '=', $slug)->first();
        }

        if (is_null($category)) {
            return App::abort(404);
        }
        $offers = Offer::where('category_id', '=', $category->id)->get();

        $this->layout->content = View::make('category.offers', compact('offers', 'category'));
    }
}
