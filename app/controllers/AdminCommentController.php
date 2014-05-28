<?php

class AdminCommentController extends BaseController {

	/**
	 * Comment Repository
	 *
	 * @var Comment
	 */
	protected $comment;

	/**
	 * Constructor
	 */
	public function __construct(Comment $comment)
	{
		/*
		 * Set Comment Instance
		 */

		$this->comment = $comment;

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
	public function anyIndex($id = null)
	{
		/*
		 * Obj
		 */
		$comment = $this->comment;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['offer_id', 'user_id', 'comment', 'approved', 'display_order']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('comment')) {
			$comment = $comment->where('comment', 'like', '%'. Input::get('comment') .'%');
		}

		if (Input::has('user_id')) {
			$comment = $comment->where('user_id', '=', Input::get('user_id'));
		}

		if (Input::has('offer_id')) {
			$comment = $comment->where('offer_id', '=', Input::get('offer_id'));
		}

		if (Input::has('approved')) {
			$comment = $comment->where('approved', '=', Input::get('approved'));
		}

		if (Input::has('date_start')) {
			$comment = $comment->where('created_at', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$comment = $comment->where('created_at', '<=', Input::get('date_end'));
		}

		if (isset($id)) {
			$comment = $comment->where('id', $id);
		}

		/*
		 * Finally Obj
		 */
		$comment = $comment->with(['offer', 'user'])
						   ->orderBy($sort, $order)
						   ->paginate($pag)
						   ->appends([
								'sort' => $sort,
								'order' => $order,
								'pag' => $pag,
								'comment' => Input::get('comment'),
								'user_id' => Input::get('user_id'),
								'offer_id' => Input::get('offer_id'),
								'approved' => Input::get('approved'),
								'date_start' => Input::get('date_start'),
								'date_end' => Input::get('date_end'),
							]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.comment.list', compact('sort', 'order', 'pag', 'comment'));
	}

	/**
	 * Update approved attribute of comment.
	 *
	 * @return Response
	 */
	public function getUpdateApproved($id, $approved){
		$comment = $this->comment->find($id);
		$comment->approved = $approved;
		$id = $comment->id;
		$comment->save();

		return Redirect::route('admin.comment', $id);
	}

}
