<?php

class AdminNewsletterController extends BaseController {

	/**
	 * Newsletter Repository
	 *
	 * @var Newsletter
	 */
	protected $newsletter;

	/**
	 * Constructor
	 */
	public function __construct(Newsletter $newsletter)
	{
		/*
		 * Set Newsletter Instance
		 */

		$this->newsletter = $newsletter;

		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$newsletter = $this->newsletter;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'id']) ? Input::get('sort') : 'name';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$newsletter = $newsletter->where('name', 'like', '%'. Input::get('name') .'%');
		}
        if (Input::has('email')) {
            $newsletter = $newsletter->where('email', 'like', '%'. Input::get('email') .'%');
        }

		/*
		 * Finally Obj
		 */
		$newsletter = $newsletter->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.newsletter.list', compact('sort', 'order', 'pag', 'newsletter'));
	}

    public function getExport(){
        $newsletters = Newsletter::all();
        $output = "";
        foreach ($newsletters as $row) {
            $output .= implode(",",$row->toArray())."\n";
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="innbativel-newsletter.csv"',
        );

        return Response::make(rtrim($output, "\n"), 200, $headers);
    }
}
