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
        $offers = $category->offer()->orderBy('created_at', 'desc')
            ->remember(5)
            ->get();
        $offers->load('genre', 'genre2', 'destiny', 'included');

        $this->layout->content = View::make('category.offers', compact('offers', 'category'));
    }
}
