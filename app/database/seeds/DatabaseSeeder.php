<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ConfigurationsTableSeeder');
		$this->call('BannersTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('PermRoleUsersTableSeeder');
		$this->call('NgosTableSeeder');
		$this->call('GenresTableSeeder');
		$this->call('StatesTableSeeder');
		$this->call('DestiniesTableSeeder');
		$this->call('SortsOfDestinyTableSeeder');
		$this->call('IncludedTableSeeder');
		$this->call('TagsTableSeeder');
		$this->call('HolidaysTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('OffersTableSeeder');
		$this->call('OffersOptionsTableSeeder');
		// $this->call('OffersImagesTableSeeder');
		// $this->call('CommentsTableSeeder');
		// $this->call('DiscountsCouponsTableSeeder');
		// $this->call('OrdersTableSeeder');
		// $this->call('VouchersTableSeeder');
		// $this->call('FaqsTableSeeder');
		// $this->call('TellUsTableSeeder');
		// $this->call('PartnersTestimoniesTableSeeder');
		// $this->call('SuggestATripTableSeeder');
		// $this->call('ContractsTableSeeder');
		// $this->call('ContractsOptionsTableSeeder');
		// $this->call('PaymentsTableSeeder');
		// $this->call('PaymentsPartnersTableSeeder');
		// $this->call('TransactionsTableSeeder');
		// $this->call('TransactionsVouchersTableSeeder');
		// $this->call('Triggers');
	}

}
