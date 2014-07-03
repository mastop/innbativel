<?php

class AdminLogController extends BaseController {

	/**
	 * NGO Repository
	 *
	 * @var NGO
	 */
	protected $log;

	/**
	 * Constructor
	 */
	public function __construct(Logs $log)
	{
		/*
		 * Set NGO Instance
		 */

		$this->log = $log;

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
		$log = $this->log;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['value']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';

		/*
		 * Search filters
		 */
		if (Input::has('type')) {
			$log = $log->where('type', 'like', '%'. Input::get('type') .'%');
		}
		
		if (Input::has('message')) {
			$log = $log->where('message', 'like', '%'. Input::get('message') .'%');
		}

		/*
		 * Finally Obj
		 */
		$log = $log->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'type' => Input::get('type'),
			'message' => Input::get('message'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Logs';
		$this->layout->content = View::make('admin.log.list', compact('sort', 'order', 'pag', 'log'));
	}

	/**
	 * Display NGO Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$log = $this->log->find($id);

        if (is_null($log))
        {
            Session::flash('error', 'Log #'.$id.' não encontrada.');
            return Redirect::route('admin.log');
        }

		Session::flash('error', 'Você tem certeza que deleja excluir esta Log? Esta operação não poderá ser desfeita.');

		$data['logData'] = $log->toArray();
		$data['logArray'] = null;

		foreach ($data['logData'] as $key => $value) {
			$data['logArray'][Lang::get('log.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Excluir Log #'.$log->id.' '.$log->name;

		$this->layout->content = View::make('admin.log.delete', $data);
	}

	/**
	 * Delete Log.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
        $log = $this->log->find($id);

        if (is_null($log))
        {
            Session::flash('error', 'Log #'.$id.' não encontrada.');
            return Redirect::route('admin.log');
        }

		$log->delete();

		Session::flash('success', 'Log excluída com sucesso.');

		return Redirect::route('admin.log');
	}

	/**
	 * Reset Log confirmation.
	 *
	 * @return Response
	 */
	public function getReset()
	{
		/*
		 * Obj
		 */
		$log = $this->log;

		/*
		 * Finally Obj
		 */
		$log = $log->orderBy('id', 'desc')->get();

		Session::flash('error', 'Você tem certeza que deleja zerar os logs? Esta operação não poderá ser desfeita.');

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Zerar os Logs';
		$this->layout->content = View::make('admin.log.reset', compact('log'));
	}

	/**
	 * Reset Log.
	 *
	 * @return Response
	 */

	public function postReset()
	{
        $this->log->truncate();

		Session::flash('success', 'Log zerado com sucesso.');

		return Redirect::route('admin.log');
	}
}
