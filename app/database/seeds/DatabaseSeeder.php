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

		$this->call('BannersTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('PermRoleUsersTableSeeder');
		$this->call('UsersIndicationsTableSeeder');
		$this->call('UsersCreditsTableSeeder');
		$this->call('NgosTableSeeder');
		$this->call('GenresTableSeeder');
		$this->call('StatesTableSeeder');
		$this->call('DestiniesTableSeeder');
		$this->call('OffersTableSeeder');
		$this->call('OffersOptionsTableSeeder');
		$this->call('OffersImagesTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('SubcategoriesTableSeeder');
		$this->call('SavemesTableSeeder');
		$this->call('IncludedTableSeeder');
		$this->call('OffersSavemeTableSeeder');
		$this->call('CommentsTableSeeder');
		$this->call('DiscountsCouponsTableSeeder');
		$this->call('OrdersTableSeeder');
		$this->call('OrdersOffersOptionsTableSeeder');
		$this->call('VouchersTableSeeder');
		$this->call('ConfigurationsTableSeeder');
		$this->call('FaqsTableSeeder');
		$this->call('PreBookingsTableSeeder');
		$this->call('TellUsTableSeeder');
		$this->call('PartnersTestimoniesTableSeeder');
		$this->call('SuggestATripTableSeeder');
	}

}
