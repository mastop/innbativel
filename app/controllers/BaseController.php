<?php

class BaseController extends Controller {

    /**
     * Controller layout.
     *
     * @var string
     */
    protected $layout;

    /**
     * Controller layout type.
     *
     * @var string
     */
    protected $type;

    /**
     * Controller sidebar status.
     *
     * @var bol
     */
    protected $sidebar;

    /**
     * Initializer.
     *
     * @access   public
     * @return BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        /**
         * Set type as backend if controller starts with admin.
         */

        if (starts_with(Route::currentRouteAction(), 'Admin')) {
           $this->type = 'backend';
        }

        if (starts_with(Route::currentRouteAction(), 'Painel')) {
           $this->type = 'frontend';
        }

        /**
         * Set type as frontend if null.
         */

        if (is_null($this->type))
        {
            $this->type = 'frontend';
        }

        /**
         * Set layout if null
         */

        if (!is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }

        else
        {
            $layout_data = [
                Config::get('theme.path'),
                Config::get('theme.active'),
                $this->type,
                Config::get('layout.active'),
            ];

            $this->layout = View::make(implode($layout_data, '.'));
        }

        /**
         * Set layout type value to view.
         */

        $this->layout->type = $this->type;

        /**
         * Set type as frontend if null.
         */

        if (!is_null($this->sidebar) && $this->sidebar = true)
        {
            $this->sidebar = true;
        }
        else {
            $this->sidebar = false;
        }

        $this->layout->sidebar = $this->sidebar;

        /*
         * Helpers
         */

        $current_action = Route::currentRouteAction();
        $segmentsTotal = count(Request::segments());

        /*
         * Set html Classes
         */

        $this->layout->html_classes = 'no-js';

        /*
         * Set body Classes
         */
        $this->layout->body_classes = 'innbativel';
        // $this->layout->body_classes = preg_replace('/\s+/', '-',
        //     str_replace(array('@', 'controller', 'get', 'post', 'any'), ' ',
        //     strtolower($current_action)));

        if ($segmentsTotal >= 1)
        {
            $this->layout->body_classes .= ' section-'. strtolower(Request::segment(1));
        }

        $this->layout->body_classes .= ' '. $this->layout->type;

        if (!$this->sidebar) {
            $this->layout->body_classes .= ' no-sidebar';
        }
        else
        {
        	$this->layout->body_classes .= ' sidebar';
        }

        $this->layout->page_title = 'Título Padrão';
        $this->layout->page_description = '';
        $this->layout->seo = Config::get('seo');
	}

}
